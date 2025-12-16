<?php
session_start();
require "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$cartIds = $data['cart_ids'] ?? [];

if (empty($cartIds)) {
    echo json_encode(["error" => "No items selected"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Prepare placeholders (?, ?, ?)
$placeholders = implode(',', array_fill(0, count($cartIds), '?'));
$types = str_repeat('i', count($cartIds) + 1);

// Fetch selected cart items
$sql = "
SELECT c.cart_id, c.product_id, c.quantity, p.price, p.stock_count
FROM cart c
JOIN products p ON c.product_id = p.product_id
WHERE c.user_id = ? AND c.cart_id IN ($placeholders)
";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, $user_id, ...$cartIds);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$items = [];

while ($row = $result->fetch_assoc()) {
    if ($row['quantity'] > $row['stock_count']) {
        echo json_encode(["error" => "Not enough stock"]);
        exit;
    }
    $total += $row['price'] * $row['quantity'];
    $items[] = $row;
}

if ($total <= 0) {
    echo json_encode(["error" => "Invalid total"]);
    exit;
}

// Create order
$insertOrder = $conn->prepare(
    "INSERT INTO orders (user_id, total_amount) VALUES (?, ?)"
);
$insertOrder->bind_param("id", $user_id, $total);
$insertOrder->execute();

// Deduct stock
foreach ($items as $item) {
    $updateStock = $conn->prepare(
        "UPDATE products SET stock_count = stock_count - ? WHERE product_id = ?"
    );
    $updateStock->bind_param("ii", $item['quantity'], $item['product_id']);
    $updateStock->execute();
}

// Remove ONLY checked items from cart
$deleteSql = "DELETE FROM cart WHERE user_id = ? AND cart_id IN ($placeholders)";
$deleteStmt = $conn->prepare($deleteSql);
$deleteStmt->bind_param($types, $user_id, ...$cartIds);
$deleteStmt->execute();

echo json_encode(["success" => true]);

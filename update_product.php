<?php
session_start();
require "db_connect.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if (!isset($_POST['id'], $_POST['product_name'], $_POST['description'], $_POST['price'], $_POST['stock_count'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$id = intval($_POST['id']);
$product_name = $_POST['product_name'];
$description = $_POST['description'];
$price = floatval($_POST['price']);
$stock_count = intval($_POST['stock_count']);

$status = 'outofstock';
if ($stock_count > 10) $status = 'instock';
elseif ($stock_count > 0) $status = 'lowstock';

$stmt = $conn->prepare("UPDATE products SET product_name=?, description=?, price=?, stock_count=?, status=? WHERE product_id=?");
$stmt->bind_param("ssdssi", $product_name, $description, $price, $stock_count, $status, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update product']);
}

$stmt->close();
$conn->close();
?>

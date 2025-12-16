<?php
session_start();
require "db_connect.php";

$user_id = $_SESSION['user_id'];

$sql = "
SELECT 
    c.cart_id,
    c.quantity,
    p.product_name,
    p.price,
    p.image_path
FROM cart c
JOIN products p ON c.product_id = p.product_id
WHERE c.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);

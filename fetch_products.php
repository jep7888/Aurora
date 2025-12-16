<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode([]);
    exit;
}

require "db_connect.php";

$result = $conn->query("
    SELECT product_id, product_name, description, price, stock_count, status, image_path
    FROM products
    ORDER BY product_id DESC
");

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);

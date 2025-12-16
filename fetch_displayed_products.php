<?php
require "db_connect.php"; // make sure $conn is defined

$sql = "SELECT product_id, product_name, description, price, image_path, stock_count 
        FROM products 
        WHERE stock_count > 0
        ORDER BY created_at DESC";

$result = $conn->query($sql);

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

header("Content-Type: application/json");
echo json_encode($products);

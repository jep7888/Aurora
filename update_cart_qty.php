<?php
session_start();
require "db_connect.php";

$data = json_decode(file_get_contents("php://input"), true);

$cart_id = (int)$data['cart_id'];
$quantity = (int)$data['quantity'];

$stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
$stmt->bind_param("ii", $quantity, $cart_id);
$stmt->execute();

echo json_encode(["success" => true]);

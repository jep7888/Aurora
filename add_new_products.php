<?php
require "db_connect.php";
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name   = $_POST['product_name'];
    $desc   = $_POST['description'];
    $price  = $_POST['price'];
    $stock  = (int)$_POST['stock_count'];

    // AUTO STATUS (SERVER-SIDE)
    if ($stock === 0) {
        $status = 'outofstock';
    } elseif ($stock <= 10) {
        $status = 'lowstock';
    } else {
        $status = 'instock';
    }

    // Image upload
    $uploadDir = "uploads/";
    $fileName = time() . "_" . basename($_FILES["product_image"]["name"]);
    $targetFile = $uploadDir . $fileName;

    if (!move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
        echo json_encode(["success" => false, "message" => "Image upload failed"]);
        exit;
    }

    $stmt = $conn->prepare(
        "INSERT INTO products 
        (product_name, description, price, stock_count, status, image_path)
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssdiss",
        $name,
        $desc,
        $price,
        $stock,
        $status,
        $targetFile
    );

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "product" => [
                "product_name" => $name,
                "price" => $price,
                "stock_count" => $stock,
                "status" => $status,
                "image_path" => $targetFile
            ]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error"]);
    }
}

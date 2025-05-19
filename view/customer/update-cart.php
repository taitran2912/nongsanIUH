<?php
session_start();
include_once '../../model/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerId = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

    if ($customerId > 0 && $productId > 0 && $quantity > 0) {
        $db = new clsketnoi();
        $conn = $db->moKetNoi();

        $sql = "UPDATE cart SET quantity = ? WHERE customer_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $quantity, $customerId, $productId);

        $success = mysqli_stmt_execute($stmt);

        $db->dongKetNoi($conn);

        echo json_encode(['success' => $success]);
        exit;
    }
}

echo json_encode(['success' => false]);
?>

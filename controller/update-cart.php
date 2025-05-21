<?php
session_start();
include_once '../model/mCart.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION["id"])) {
    echo json_encode([
        'success' => false, 
        'message' => 'Vui lòng đăng nhập để tiếp tục.'
    ]);
    exit;
}

$customerId = $_SESSION["id"];
$action = isset($_POST['action']) ? $_POST['action'] : 'update';
$productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

// Create model instance
$cartModel = new mCart();

try {
    // Handle different actions
    switch ($action) {
        case 'update':
            // Validate inputs
            if ($productId <= 0) {
                throw new Exception('ID sản phẩm không hợp lệ.');
            }
            
            if ($quantity <= 0) {
                throw new Exception('Số lượng phải lớn hơn 0.');
            }
            
            // Check if product exists in cart
            $checkSql = "SELECT COUNT(*) as count FROM cart WHERE customer_id = $customerId AND product_id = $productId";
            $checkResult = $cartModel->mCart($checkSql);
            
            if ($checkResult && $row = $checkResult->fetch_assoc()) {
                if ($row['count'] > 0) {
                    // Update existing cart item
                    $sql = "UPDATE cart SET quantity = $quantity, updated_at = NOW() WHERE customer_id = $customerId AND product_id = $productId";
                } else {
                    // Insert new cart item
                    $sql = "INSERT INTO cart (customer_id, product_id, quantity, created_at, updated_at) VALUES ($customerId, $productId, $quantity, NOW(), NOW())";
                }
                
                $result = $cartModel->mCart($sql);
                
                if ($result) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Giỏ hàng đã được cập nhật thành công.',
                        'quantity' => $quantity
                    ]);
                } else {
                    throw new Exception('Không thể cập nhật giỏ hàng.');
                }
            } else {
                throw new Exception('Lỗi khi kiểm tra sản phẩm trong giỏ hàng.');
            }
            break;
            
        case 'remove':
            // Validate inputs
            if ($productId <= 0) {
                throw new Exception('ID sản phẩm không hợp lệ.');
            }
            
            // Remove item from cart
            $sql = "DELETE FROM cart WHERE customer_id = $customerId AND product_id = $productId";
            $result = $cartModel->mCart($sql);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.'
                ]);
            } else {
                throw new Exception('Không thể xóa sản phẩm khỏi giỏ hàng.');
            }
            break;
            
        case 'clear':
            // Clear entire cart
            $sql = "DELETE FROM cart WHERE customer_id = $customerId";
            $result = $cartModel->mCart($sql);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Giỏ hàng đã được xóa thành công.'
                ]);
            } else {
                throw new Exception('Không thể xóa giỏ hàng.');
            }
            break;
            
        default:
            throw new Exception('Hành động không hợp lệ.');
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
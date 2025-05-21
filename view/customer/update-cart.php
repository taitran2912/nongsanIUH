<?php
session_start();
include_once '../../model/connect.php';

// Đặt header JSON
header('Content-Type: application/json');

// Kiểm tra đăng nhập
if (!isset($_SESSION["id"])) {
    echo json_encode([
        'success' => false, 
        'message' => 'Vui lòng đăng nhập để tiếp tục.'
    ]);
    exit;
}

$customerId = $_SESSION["id"];
$action = isset($_POST['action']) ? $_POST['action'] : '';
$productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

// Kết nối CSDL
$db = new clsketnoi();
$conn = $db->moKetNoi();
$conn->set_charset('utf8');

try {
    // Xử lý các hành động
    switch ($action) {
        case 'update':
            // Kiểm tra dữ liệu đầu vào
            if ($productId <= 0) {
                throw new Exception('ID sản phẩm không hợp lệ.');
            }
            
            if ($quantity <= 0) {
                throw new Exception('Số lượng phải lớn hơn 0.');
            }
            
            // Kiểm tra sản phẩm có tồn tại trong giỏ hàng không
            $checkSql = "SELECT COUNT(*) as count FROM cart WHERE customer_id = ? AND product_id = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("ii", $customerId, $productId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            $row = $checkResult->fetch_assoc();
            
            if ($row['count'] > 0) {
                // Cập nhật số lượng sản phẩm
                $sql = "UPDATE cart SET quantity = ? WHERE customer_id = ? AND product_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $quantity, $customerId, $productId);
            } else {
                // Thêm sản phẩm mới vào giỏ hàng
                $sql = "INSERT INTO cart (customer_id, product_id, quantity) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $customerId, $productId, $quantity);
            }
            
            if ($stmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Giỏ hàng đã được cập nhật thành công.',
                    'quantity' => $quantity
                ]);
            } else {
                throw new Exception('Không thể cập nhật giỏ hàng: ' . $conn->error);
            }
            break;
            
        case 'remove':
            // Kiểm tra dữ liệu đầu vào
            if ($productId <= 0) {
                throw new Exception('ID sản phẩm không hợp lệ.');
            }
            
            // Xóa sản phẩm khỏi giỏ hàng
            $sql = "DELETE FROM cart WHERE customer_id = ? AND product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $customerId, $productId);
            
            if ($stmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.'
                ]);
            } else {
                throw new Exception('Không thể xóa sản phẩm: ' . $conn->error);
            }
            break;
            
        case 'clear':
            // Xóa toàn bộ giỏ hàng
            $sql = "DELETE FROM cart WHERE customer_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $customerId);
            
            if ($stmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Giỏ hàng đã được xóa thành công.'
                ]);
            } else {
                throw new Exception('Không thể xóa giỏ hàng: ' . $conn->error);
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
} finally {
    // Đóng kết nối
    $db->dongKetNoi($conn);
}
?>
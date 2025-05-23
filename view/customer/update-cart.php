<?php
session_start();
include_once("../../model/connect.php");
include_once("../../controller/cCart.php");

// Kiểm tra đăng nhập
if (!isset($_SESSION["id"])) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để thực hiện chức năng này']);
    exit;
}

$customerId = $_SESSION["id"];
$response = ['success' => false, 'message' => 'Không có hành động được chỉ định'];

// Kiểm tra xem có dữ liệu POST không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    // Khởi tạo đối tượng giỏ hàng
    $cart = new cCart();
    
    switch ($action) {
        case 'update':
            // Cập nhật số lượng sản phẩm
            $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
            
            if ($productId <= 0 || $quantity <= 0) {
                $response = ['success' => false, 'message' => 'Dữ liệu không hợp lệ'];
                break;
            }
            
            $result = $cart->updateCartQuantity($customerId, $productId, $quantity);
            
            if ($result) {
                $response = ['success' => true, 'message' => 'Cập nhật số lượng thành công'];
            } else {
                $response = ['success' => false, 'message' => 'Không thể cập nhật số lượng'];
            }
            break;
            
        case 'remove':
            // Xóa sản phẩm khỏi giỏ hàng
            $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            
            if ($productId <= 0) {
                $response = ['success' => false, 'message' => 'Dữ liệu không hợp lệ'];
                break;
            }
            
            // Kết nối CSDL
            $db = new clsketnoi();
            $conn = $db->moKetNoi();
            $conn->set_charset('utf8');
            
            // Xóa sản phẩm khỏi giỏ hàng
            $sql = "DELETE FROM cart WHERE customer_id = ? AND product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $customerId, $productId);
            $result = $stmt->execute();
            
            // Đóng kết nối
            $db->dongKetNoi($conn);
            
            if ($result) {
                $response = ['success' => true, 'message' => 'Đã xóa sản phẩm khỏi giỏ hàng'];
            } else {
                $response = ['success' => false, 'message' => 'Không thể xóa sản phẩm'];
            }
            break;
            
        case 'clear':
            // Xóa toàn bộ giỏ hàng
            $db = new clsketnoi();
            $conn = $db->moKetNoi();
            $conn->set_charset('utf8');
            
            // Xóa tất cả sản phẩm trong giỏ hàng của người dùng
            $sql = "DELETE FROM cart WHERE customer_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $customerId);
            $result = $stmt->execute();
            
            // Đóng kết nối
            $db->dongKetNoi($conn);
            
            if ($result) {
                $response = ['success' => true, 'message' => 'Đã xóa toàn bộ giỏ hàng'];
            } else {
                $response = ['success' => false, 'message' => 'Không thể xóa giỏ hàng'];
            }
            break;
            
        case 'add':
            // Thêm sản phẩm vào giỏ hàng
            $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
            
            if ($productId <= 0 || $quantity <= 0) {
                $response = ['success' => false, 'message' => 'Dữ liệu không hợp lệ'];
                break;
            }
            
            // Kết nối CSDL
            $db = new clsketnoi();
            $conn = $db->moKetNoi();
            $conn->set_charset('utf8');
            
            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $checkSql = "SELECT quantity FROM cart WHERE customer_id = ? AND product_id = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("ii", $customerId, $productId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            
            if ($checkResult->num_rows > 0) {
                // Sản phẩm đã có trong giỏ hàng, cập nhật số lượng
                $row = $checkResult->fetch_assoc();
                $newQuantity = $row['quantity'] + $quantity;
                
                $updateSql = "UPDATE cart SET quantity = ? WHERE customer_id = ? AND product_id = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("iii", $newQuantity, $customerId, $productId);
                $result = $updateStmt->execute();
                
                if ($result) {
                    $response = ['success' => true, 'message' => 'Đã cập nhật số lượng sản phẩm trong giỏ hàng'];
                } else {
                    $response = ['success' => false, 'message' => 'Không thể cập nhật giỏ hàng'];
                }
            } else {
                // Sản phẩm chưa có trong giỏ hàng, thêm mới
                $insertSql = "INSERT INTO cart (customer_id, product_id, quantity) VALUES (?, ?, ?)";
                $insertStmt = $conn->prepare($insertSql);
                $insertStmt->bind_param("iii", $customerId, $productId, $quantity);
                $result = $insertStmt->execute();
                
                if ($result) {
                    $response = ['success' => true, 'message' => 'Đã thêm sản phẩm vào giỏ hàng'];
                } else {
                    $response = ['success' => false, 'message' => 'Không thể thêm sản phẩm vào giỏ hàng'];
                }
            }
            
            // Đóng kết nối
            $db->dongKetNoi($conn);
            break;
            
        default:
            $response = ['success' => false, 'message' => 'Hành động không hợp lệ'];
            break;
    }
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

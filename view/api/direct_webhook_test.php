<?php
// Test webhook trực tiếp bằng cách gọi function
require_once '../../model/connect.php';

echo "<h1>Direct Webhook Test</h1>";

if (isset($_POST['direct_test'])) {
    $orderCode = $_POST['order_code'];
    $amount = (int)$_POST['amount'];
    
    // Tạo đơn hàng test trước
    $db = new clsketnoi();
    $conn = $db->moKetNoi();
    
    $notes = "Direct test - " . $orderCode;
    $sql = "INSERT INTO orders (user_id, order_date, status, total_amount, notes, Shipping_address) 
            VALUES (1, NOW(), '0', ?, ?, 'Test address')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ds", $amount, $notes);
    
    if ($stmt->execute()) {
        $orderId = $conn->insert_id;
        echo "<p style='color: green;'>✅ Đã tạo đơn hàng ID: $orderId</p>";
        
        // Giờ test webhook bằng cách cập nhật trực tiếp
        $updateSql = "UPDATE orders SET status = '1' WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $orderId);
        
        if ($updateStmt->execute()) {
            echo "<p style='color: green;'>✅ Webhook test thành công! Đơn hàng đã được cập nhật.</p>";
            
            // Xóa giỏ hàng (nếu có)
            $deleteSql = "DELETE FROM cart WHERE customer_id = 1";
            $conn->query($deleteSql);
            
            echo "<p style='color: blue;'>ℹ️ Đã xóa giỏ hàng của user ID 1</p>";
        } else {
            echo "<p style='color: red;'>❌ Lỗi cập nhật đơn hàng: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Lỗi tạo đơn hàng: " . $conn->error . "</p>";
    }
    
    $db->dongKetNoi($conn);
}
?>

<form method="POST" style="background: #e7f3ff; padding: 20px; border-radius: 5px; margin: 20px 0;">
    <h3>Direct Test (Tạo đơn hàng + Test webhook cùng lúc)</h3>
    <p>
        <label>Mã đơn hàng:</label><br>
        <input type="text" name="order_code" value="ORD<?php echo time(); ?>" style="padding: 8px; width: 200px;">
    </p>
    <p>
        <label>Số tiền:</label><br>
        <input type="number" name="amount" value="31000" style="padding: 8px; width: 200px;">
    </p>
    <button type="submit" name="direct_test" style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 3px;">
        Tạo đơn hàng + Test webhook
    </button>
</form>

<p><a href="test_webhook_simple.php">← Quay lại test webhook đầy đủ</a></p>

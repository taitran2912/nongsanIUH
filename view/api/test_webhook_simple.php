<?php
// File test đơn giản để kiểm tra webhook
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Test Webhook SePay - Phiên bản đơn giản</h1>";

// Kết nối database
try {
    require_once '../../model/connect.php';
    $db = new clsketnoi();
    $conn = $db->moKetNoi();
    
    if (!$conn) {
        die("Không thể kết nối database");
    }
    
    echo "<p style='color: green;'>✓ Kết nối database thành công</p>";
} catch (Exception $e) {
    die("Lỗi database: " . $e->getMessage());
}

// Xử lý tạo đơn hàng test
if (isset($_POST['create_order'])) {
    $orderCode = $_POST['order_code'];
    $amount = (int)$_POST['amount'];
    $notes = "Test order - " . $orderCode;
    
    $sql = "INSERT INTO orders (user_id, order_date, status, total_amount, notes, Shipping_address) 
            VALUES (1, NOW(), '0', ?, ?, 'Test address')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ds", $amount, $notes);
    
    if ($stmt->execute()) {
        $orderId = $conn->insert_id;
        echo "<div style='background: #d4edda; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
        echo "✅ Tạo đơn hàng thành công! ID: $orderId, Mã: $orderCode";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
        echo "❌ Lỗi tạo đơn hàng: " . $conn->error;
        echo "</div>";
    }
}

// Xử lý test webhook
if (isset($_POST['test_webhook'])) {
    $orderCode = $_POST['test_order_code'];
    $amount = (int)$_POST['test_amount'];
    
    // Kiểm tra đơn hàng có tồn tại không
    $checkSql = "SELECT id, status FROM orders WHERE notes LIKE ?";
    $checkStmt = $conn->prepare($checkSql);
    $searchPattern = '%' . $orderCode . '%';
    $checkStmt->bind_param("s", $searchPattern);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows === 0) {
        echo "<div style='background: #f8d7da; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
        echo "❌ Đơn hàng $orderCode không tồn tại! Hãy tạo đơn hàng trước.";
        echo "</div>";
    } else {
        // Gửi data đến webhook
        $testData = [
            'gateway' => 'TPBank',
            'transactionDate' => date('Y-m-d H:i:s'),
            'accountNumber' => '91902203843',
            'content' => $orderCode,
            'transferType' => 'in',
            'description' => 'Test payment ' . $orderCode,
            'transferAmount' => $amount,
            'referenceCode' => 'TEST' . time(),
            'id' => rand(10000000, 99999999)
        ];
        
        // Gọi webhook trực tiếp
        $webhookFile = __DIR__ . '/sepay_webhook.php';
        
        // Mô phỏng POST request
        $_POST_backup = $_POST;
        $_SERVER_backup = $_SERVER;
        
        // Set up environment cho webhook
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['CONTENT_TYPE'] = 'application/json';
        
        // Capture output
        ob_start();
        
        // Mô phỏng input stream
        $json_data = json_encode($testData);
        file_put_contents('php://temp', $json_data);
        
        // Include webhook file
        try {
            // Tạo file tạm thời với dữ liệu JSON
            $tempFile = tempnam(sys_get_temp_dir(), 'webhook_test');
            file_put_contents($tempFile, $json_data);
            
            // Gọi webhook qua HTTP
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://localhost' . str_replace($_SERVER['DOCUMENT_ROOT'], '', $webhookFile));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            
            unlink($tempFile);
            
            echo "<h3>Kết quả test webhook:</h3>";
            echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
            echo "<p><strong>HTTP Code:</strong> $httpCode</p>";
            
            if ($error) {
                echo "<p style='color: red;'><strong>Error:</strong> $error</p>";
            } else {
                echo "<p><strong>Response:</strong> $response</p>";
                
                // Kiểm tra trạng thái đơn hàng sau khi test
                $checkStmt->execute();
                $newResult = $checkStmt->get_result();
                $orderData = $newResult->fetch_assoc();
                
                if ($orderData['status'] == '1') {
                    echo "<p style='color: green;'><strong>✅ Thành công!</strong> Đơn hàng đã được cập nhật thành 'Đã thanh toán'</p>";
                } else {
                    echo "<p style='color: orange;'><strong>⚠️ Cảnh báo:</strong> Đơn hàng vẫn ở trạng thái 'Chờ thanh toán'</p>";
                }
            }
            echo "</div>";
            
        } catch (Exception $e) {
            echo "<div style='background: #f8d7da; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
            echo "❌ Lỗi test webhook: " . $e->getMessage();
            echo "</div>";
        }
        
        // Restore environment
        $_POST = $_POST_backup;
        $_SERVER = $_SERVER_backup;
    }
}

// Hiển thị đơn hàng hiện có
echo "<h3>Đơn hàng trong hệ thống:</h3>";
$result = $conn->query("SELECT id, notes, total_amount, status, order_date FROM orders ORDER BY id DESC LIMIT 5");

if ($result && $result->num_rows > 0) {
    echo "<table style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
    echo "<tr style='background: #f8f9fa;'>";
    echo "<th style='border: 1px solid #ddd; padding: 8px;'>ID</th>";
    echo "<th style='border: 1px solid #ddd; padding: 8px;'>Mã đơn hàng</th>";
    echo "<th style='border: 1px solid #ddd; padding: 8px;'>Số tiền</th>";
    echo "<th style='border: 1px solid #ddd; padding: 8px;'>Trạng thái</th>";
    echo "</tr>";
    
    while ($row = $result->fetch_assoc()) {
        $orderCode = '';
        if (preg_match('/ORD\d+/', $row['notes'], $matches)) {
            $orderCode = $matches[0];
        }
        
        $statusText = $row['status'] == '1' ? 'Đã thanh toán' : 'Chờ thanh toán';
        $statusColor = $row['status'] == '1' ? 'green' : 'orange';
        
        echo "<tr>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>{$row['id']}</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; font-family: monospace;'>$orderCode</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . number_format($row['total_amount']) . "đ</td>";
        echo "<td style='border: 1px solid #ddd; padding: 8px; color: $statusColor;'>$statusText</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Chưa có đơn hàng nào.</p>";
}

$db->dongKetNoi($conn);
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #333; }
.form-section { 
    background: #f8f9fa; 
    padding: 20px; 
    margin: 20px 0; 
    border-radius: 5px; 
    border: 1px solid #dee2e6;
}
input, button { 
    padding: 8px; 
    margin: 5px; 
    border: 1px solid #ccc; 
    border-radius: 3px;
}
button { 
    background: #007cba; 
    color: white; 
    cursor: pointer;
    border: none;
}
button:hover { opacity: 0.9; }
</style>

<!-- Form tạo đơn hàng -->
<div class="form-section">
    <h3>🆕 Bước 1: Tạo đơn hàng test</h3>
    <form method="POST">
        <p>
            <label>Mã đơn hàng:</label><br>
            <input type="text" name="order_code" value="ORD<?php echo time(); ?>" style="width: 200px;">
        </p>
        <p>
            <label>Số tiền:</label><br>
            <input type="number" name="amount" value="31000" style="width: 200px;">
        </p>
        <button type="submit" name="create_order">Tạo đơn hàng</button>
    </form>
</div>

<!-- Form test webhook -->
<div class="form-section">
    <h3>🧪 Bước 2: Test webhook</h3>
    <form method="POST">
        <p>
            <label>Mã đơn hàng (sử dụng mã từ bảng trên):</label><br>
            <input type="text" name="test_order_code" value="" placeholder="VD: ORD1748001867" style="width: 200px;">
        </p>
        <p>
            <label>Số tiền:</label><br>
            <input type="number" name="test_amount" value="31000" style="width: 200px;">
        </p>
        <button type="submit" name="test_webhook">Test Webhook</button>
    </form>
</div>

<!-- Hướng dẫn -->
<div style="background: #fff3cd; padding: 15px; border-radius: 5px; border: 1px solid #ffeaa7;">
    <h3>📋 Hướng dẫn:</h3>
    <ol>
        <li><strong>Tạo đơn hàng:</strong> Sử dụng form "Bước 1" để tạo đơn hàng test</li>
        <li><strong>Sao chép mã:</strong> Lấy mã đơn hàng từ bảng "Đơn hàng trong hệ thống"</li>
        <li><strong>Test webhook:</strong> Dán mã đơn hàng vào form "Bước 2" và nhấn "Test Webhook"</li>
        <li><strong>Kiểm tra:</strong> Xem trạng thái đơn hàng thay đổi từ "Chờ thanh toán" → "Đã thanh toán"</li>
    </ol>
</div>

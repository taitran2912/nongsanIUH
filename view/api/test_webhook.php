<?php
// Bắt lỗi và hiển thị
error_reporting(E_ALL);
ini_set('display_errors', 1);

// File test để kiểm tra webhook hoạt động
echo "<h1>Test Webhook SePay</h1>";

// Kiểm tra file webhook có tồn tại không
$webhookFile = __DIR__ . '/sepay_webhook.php';
if (file_exists($webhookFile)) {
    echo "<p style='color: green;'>✓ File sepay_webhook.php tồn tại</p>";
} else {
    echo "<p style='color: red;'>✗ File sepay_webhook.php KHÔNG tồn tại</p>";
}

// Kiểm tra quyền ghi file
if (is_writable(__DIR__)) {
    echo "<p style='color: green;'>✓ Thư mục có quyền ghi</p>";
} else {
    echo "<p style='color: red;'>✗ Thư mục KHÔNG có quyền ghi</p>";
    echo "<p style='color: orange;'>⚠️ Sẽ sử dụng thư mục tạm thời để ghi log</p>";
}

// Kiểm tra kết nối database
$dbConnected = false;
$db = null;
$conn = null;

try {
    require_once '../../model/connect.php';
    $db = new clsketnoi();
    $conn = $db->moKetNoi();
    if ($conn) {
        echo "<p style='color: green;'>✓ Kết nối database thành công</p>";
        $dbConnected = true;
        
        // Kiểm tra bảng orders
        $result = $conn->query("SHOW TABLES LIKE 'orders'");
        if ($result && $result->num_rows > 0) {
            echo "<p style='color: green;'>✓ Bảng orders tồn tại</p>";
            
            // Đếm số đơn hàng
            $countResult = $conn->query("SELECT COUNT(*) as total FROM orders");
            if ($countResult) {
                $count = $countResult->fetch_assoc()['total'];
                echo "<p style='color: blue;'>📊 Tổng số đơn hàng: $count</p>";
            }
        } else {
            echo "<p style='color: red;'>✗ Bảng orders KHÔNG tồn tại</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Không thể kết nối database</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Lỗi kết nối database: " . $e->getMessage() . "</p>";
}

// Xử lý tạo đơn hàng test
if (isset($_POST['create_test_order']) && $dbConnected) {
    try {
        $orderCode = $_POST['order_code'];
        $amount = (int)$_POST['amount'];
        $notes = "Đơn hàng test cho webhook. Mã đơn hàng: " . $orderCode;
        
        // Tạo đơn hàng test
        $sql = "INSERT INTO orders (user_id, order_date, status, total_amount, notes, Shipping_address) 
                VALUES (1, NOW(), '0', ?, ?, 'Địa chỉ test')";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ds", $amount, $notes);
            
            if ($stmt->execute()) {
                $orderId = $conn->insert_id;
                echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
                echo "✓ Đã tạo đơn hàng test thành công!<br>";
                echo "ID: $orderId<br>";
                echo "Mã đơn hàng: $orderCode<br>";
                echo "Số tiền: " . number_format($amount) . "đ";
                echo "</div>";
            } else {
                echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
                echo "✗ Lỗi tạo đơn hàng: " . $conn->error;
                echo "</div>";
            }
        } else {
            echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
            echo "✗ Lỗi prepare statement: " . $conn->error;
            echo "</div>";
        }
    } catch (Exception $e) {
        echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
        echo "✗ Lỗi: " . $e->getMessage();
        echo "</div>";
    }
}

// Xử lý test webhook
if (isset($_POST['test_webhook'])) {
    $testData = [
        'gateway' => 'TPBank',
        'transactionDate' => date('Y-m-d H:i:s'),
        'accountNumber' => '91902203843',
        'subAccount' => null,
        'code' => null,
        'content' => $_POST['order_code'],
        'transferType' => 'in',
        'description' => 'BankAPINotify ' . $_POST['order_code'],
        'transferAmount' => (int)$_POST['amount'],
        'referenceCode' => 'TEST' . time(),
        'accumulated' => (int)$_POST['amount'],
        'id' => rand(10000000, 99999999)
    ];
    
    // Gửi POST request đến webhook
    $webhookUrl = 'http://localhost' . str_replace($_SERVER['DOCUMENT_ROOT'], '', $webhookFile);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $webhookUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($testData))
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    echo "<h3>Kết quả test webhook:</h3>";
    echo "<div style='background: #f8f9fa; padding: 15px; border: 1px solid #dee2e6; border-radius: 5px; margin: 10px 0;'>";
    echo "<p><strong>URL:</strong> $webhookUrl</p>";
    echo "<p><strong>HTTP Code:</strong> $httpCode</p>";
    
    if ($error) {
        echo "<p style='color: red;'><strong>cURL Error:</strong> $error</p>";
    }
    
    echo "<p><strong>Response:</strong> $response</p>";
    echo "</div>";
    
    // Hiển thị dữ liệu gửi đi
    echo "<h4>Dữ liệu gửi đến webhook:</h4>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd; border-radius: 3px; overflow-x: auto;'>";
    echo json_encode($testData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo "</pre>";
    
    // Hiển thị log
    $logFiles = [
        __DIR__ . '/sepay_webhook_log.txt',
        sys_get_temp_dir() . '/sepay_webhook_log.txt',
        '/tmp/sepay_webhook_log.txt'
    ];
    
    foreach ($logFiles as $logFile) {
        if (file_exists($logFile)) {
            $logContent = file_get_contents($logFile);
            echo "<h4>Log webhook ($logFile):</h4>";
            echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd; max-height: 300px; overflow-y: auto; border-radius: 3px;'>";
            echo htmlspecialchars($logContent);
            echo "</pre>";
            break;
        }
    }
}

// Hiển thị danh sách đơn hàng gần đây
if ($dbConnected) {
    try {
        $result = $conn->query("SELECT id, notes, total_amount, status, order_date FROM orders ORDER BY id DESC LIMIT 10");
        if ($result && $result->num_rows > 0) {
            echo "<h3>Đơn hàng gần đây:</h3>";
            echo "<div style='overflow-x: auto;'>";
            echo "<table style='border-collapse: collapse; width: 100%; margin: 10px 0; min-width: 600px;'>";
            echo "<tr style='background: #f8f9fa;'>";
            echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>ID</th>";
            echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Mã đơn hàng</th>";
            echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: right;'>Số tiền</th>";
            echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: center;'>Trạng thái</th>";
            echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: center;'>Ngày tạo</th>";
            echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: center;'>Hành động</th>";
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
                echo "<td style='border: 1px solid #ddd; padding: 8px; text-align: right;'>" . number_format($row['total_amount']) . "đ</td>";
                echo "<td style='border: 1px solid #ddd; padding: 8px; text-align: center; color: $statusColor; font-weight: bold;'>$statusText</td>";
                echo "<td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>{$row['order_date']}</td>";
                echo "<td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>";
                if ($orderCode && $row['status'] == '0') {
                    echo "<button onclick=\"document.getElementById('order_code').value='$orderCode'; document.getElementById('amount').value='{$row['total_amount']}';\" style='padding: 4px 8px; background: #007cba; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 12px;'>Sử dụng</button>";
                }
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p style='color: #666;'>Chưa có đơn hàng nào trong hệ thống.</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>Lỗi lấy danh sách đơn hàng: " . $e->getMessage() . "</p>";
    }
}

// Đóng kết nối database
if ($conn && $db) {
    $db->dongKetNoi($conn);
}
?>

<!-- Form tạo đơn hàng test -->
<form method="POST" style="margin-top: 20px; padding: 20px; border: 1px solid #28a745; background: #d4edda; border-radius: 5px;">
    <h3 style="color: #155724;">🆕 Tạo đơn hàng test</h3>
    <p style="color: #155724; margin-bottom: 15px;">Tạo đơn hàng mới trong database để test webhook</p>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Mã đơn hàng:</label>
        <input type="text" name="order_code" value="ORD<?php echo time(); ?>" style="width: 250px; padding: 8px; border: 1px solid #ccc; border-radius: 3px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Số tiền:</label>
        <input type="number" name="amount" value="31000" style="width: 250px; padding: 8px; border: 1px solid #ccc; border-radius: 3px;">
    </div>
    
    <button type="submit" name="create_test_order" style="padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer; border-radius: 3px; font-weight: bold;">
        ➕ Tạo đơn hàng test
    </button>
</form>

<!-- Form test webhook -->
<form method="POST" style="margin-top: 20px; padding: 20px; border: 1px solid #007cba; background: #e7f3ff; border-radius: 5px;">
    <h3 style="color: #004085;">🧪 Test Webhook</h3>
    <p style="color: #004085; margin-bottom: 15px;">Mô phỏng SePay gửi thông báo thanh toán đến webhook</p>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Mã đơn hàng:</label>
        <input type="text" id="order_code" name="order_code" value="ORD<?php echo time(); ?>" style="width: 250px; padding: 8px; border: 1px solid #ccc; border-radius: 3px;">
        <small style="color: #666; display: block; margin-top: 5px;">💡 Sử dụng mã đơn hàng từ bảng trên hoặc tạo đơn hàng test trước</small>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Số tiền:</label>
        <input type="number" id="amount" name="amount" value="31000" style="width: 250px; padding: 8px; border: 1px solid #ccc; border-radius: 3px;">
    </div>
    
    <button type="submit" name="test_webhook" style="padding: 10px 20px; background: #007cba; color: white; border: none; cursor: pointer; border-radius: 3px; font-weight: bold;">
        🚀 Test Webhook
    </button>
</form>

<!-- Hướng dẫn sử dụng -->
<div style="margin-top: 20px; padding: 20px; border: 1px solid #ffc107; background: #fff3cd; border-radius: 5px;">
    <h3 style="color: #856404;">📋 Hướng dẫn sử dụng</h3>
    <ol style="color: #856404;">
        <li><strong>Tạo đơn hàng test:</strong> Sử dụng form "Tạo đơn hàng test" để tạo đơn hàng mới trong database</li>
        <li><strong>Sao chép mã đơn hàng:</strong> Từ bảng "Đơn hàng gần đây", nhấn nút "Sử dụng" để tự động điền mã đơn hàng</li>
        <li><strong>Test webhook:</strong> Sử dụng form "Test Webhook" với mã đơn hàng vừa tạo</li>
        <li><strong>Kiểm tra kết quả:</strong> Xem HTTP Code (200 = thành công) và response từ webhook</li>
        <li><strong>Xác minh:</strong> Kiểm tra bảng đơn hàng để thấy trạng thái đã chuyển từ "Chờ thanh toán" sang "Đã thanh toán"</li>
    </ol>
</div>

<style>
body { 
    font-family: Arial, sans-serif; 
    margin: 20px; 
    line-height: 1.6;
}
h1 { 
    color: #333; 
    border-bottom: 2px solid #007cba;
    padding-bottom: 10px;
}
h3 {
    margin-top: 0;
}
p { 
    margin: 10px 0; 
}
button:hover {
    opacity: 0.9;
}
input:focus {
    outline: none;
    border-color: #007cba;
    box-shadow: 0 0 5px rgba(0, 124, 186, 0.3);
}
</style>

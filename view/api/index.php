

<?php
// File index để bảo vệ thư mục api
echo "<h1>API Directory</h1>";
echo "<p>Đây là thư mục API của hệ thống thanh toán SePay.</p>";

echo "<h2>Các endpoint có sẵn:</h2>";
echo "<ul>";
echo "<li><a href='sepay_webhook.php'>sepay_webhook.php</a> - Webhook xử lý thông báo thanh toán từ SePay</li>";
echo "<li><a href='check_sepay_payment.php'>check_sepay_payment.php</a> - API kiểm tra trạng thái thanh toán</li>";
echo "<li><a href='test_webhook.php'>test_webhook.php</a> - Công cụ test webhook</li>";
echo "</ul>";

echo "<h2>Kiểm tra hệ thống:</h2>";

// Kiểm tra các file cần thiết
$files = [
    'sepay_webhook.php' => 'Webhook xử lý thanh toán',
    'check_sepay_payment.php' => 'API kiểm tra thanh toán',
    'test_webhook.php' => 'Công cụ test'
];

foreach ($files as $file => $description) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "<p style='color: green;'>✓ $file - $description</p>";
    } else {
        echo "<p style='color: red;'>✗ $file - $description (THIẾU)</p>";
    }
}

// Kiểm tra quyền ghi
if (is_writable(__DIR__)) {
    echo "<p style='color: green;'>✓ Thư mục có quyền ghi file log</p>";
} else {
    echo "<p style='color: red;'>✗ Thư mục KHÔNG có quyền ghi file log</p>";
}

// Kiểm tra kết nối database
try {
    require_once '../../model/connect.php';
    $db = new clsketnoi();
    $conn = $db->moKetNoi();
    if ($conn) {
        echo "<p style='color: green;'>✓ Kết nối database thành công</p>";
        $db->dongKetNoi($conn);
    } else {
        echo "<p style='color: red;'>✗ Không thể kết nối database</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Lỗi kết nối database: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><small>Thời gian kiểm tra: " . date('Y-m-d H:i:s') . "</small></p>";
?>

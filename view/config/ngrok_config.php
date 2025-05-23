<?php
/**
 * Cấu hình ngrok cho webhook SePay
 * File này giúp tự động lấy URL ngrok và cấu hình webhook
 */

// Lấy URL ngrok từ API hoặc file cấu hình
function getNgrokUrl() {
    // Kiểm tra xem có file lưu URL ngrok không
    $ngrokUrlFile = __DIR__ . '/ngrok_url.txt';
    
    if (file_exists($ngrokUrlFile)) {
        $ngrokUrl = trim(file_get_contents($ngrokUrlFile));
        if (!empty($ngrokUrl)) {
            return $ngrokUrl;
        }
    }
    
    // Nếu không có file hoặc file rỗng, thử lấy từ API ngrok
    try {
        $ngrokApiResponse = @file_get_contents('http://127.0.0.1:4040/api/tunnels');
        if ($ngrokApiResponse) {
            $ngrokData = json_decode($ngrokApiResponse, true);
            if (isset($ngrokData['tunnels']) && count($ngrokData['tunnels']) > 0) {
                foreach ($ngrokData['tunnels'] as $tunnel) {
                    if ($tunnel['proto'] === 'https') {
                        // Lưu URL vào file để sử dụng sau này
                        file_put_contents($ngrokUrlFile, $tunnel['public_url']);
                        return $tunnel['public_url'];
                    }
                }
            }
        }
    } catch (Exception $e) {
        // Xử lý lỗi khi không thể kết nối đến API ngrok
        error_log('Không thể lấy URL ngrok: ' . $e->getMessage());
    }
    
    // Trả về giá trị mặc định nếu không thể lấy URL ngrok
    return 'https://your-ngrok-url.ngrok.io';
}

// Lấy URL ngrok
$ngrokBaseUrl = getNgrokUrl();

// Cấu hình SePay với URL ngrok
$sepayConfig = [
    'account_number' => '91902203843', // Số tài khoản ngân hàng liên kết với SePay
    'account_name' => 'TranTanTai', // Tên chủ tài khoản
    'bank_code' => 'TPBank', // Mã ngân hàng (VCB, TCB, MB, etc.)
    'template' => 'compact', // Template QR code
    'webhook_url' => $ngrokBaseUrl . '/DuAn_CNM/view/api/sepay_webhook.php', // URL webhook qua ngrok
    'return_url' => $ngrokBaseUrl . '/DuAn_CNM/view/customer/ind?action=thank_you' // URL trả về sau khi thanh toán
];

// Ghi log URL webhook để debug
$logFile = __DIR__ . '/webhook_url.log';
file_put_contents($logFile, date('Y-m-d H:i:s') . ' - Webhook URL: ' . $sepayConfig['webhook_url'] . PHP_EOL, FILE_APPEND);

// Hiển thị thông tin cấu hình nếu được gọi trực tiếp
if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    echo "<h1>Cấu hình Ngrok cho SePay</h1>";
    echo "<p><strong>Ngrok URL:</strong> " . $ngrokBaseUrl . "</p>";
    echo "<p><strong>Webhook URL:</strong> " . $sepayConfig['webhook_url'] . "</p>";
    echo "<p><strong>Return URL:</strong> " . $sepayConfig['return_url'] . "</p>";
    echo "<p>Thông tin này đã được lưu vào file log: " . $logFile . "</p>";
}

return $sepayConfig;
?>

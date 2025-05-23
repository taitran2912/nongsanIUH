<?php
// File này chỉ dùng để test thanh toán trong môi trường phát triển
// KHÔNG sử dụng trong môi trường production

// Kiểm tra tham số
if (!isset($_GET['order_code']) || !isset($_GET['amount'])) {
    die('Thiếu tham số: cần order_code và amount');
}

$orderCode = $_GET['order_code'];
$amount = $_GET['amount'];

// Tạo dữ liệu mô phỏng thanh toán
$paymentData = [
    'gateway' => 'TPBank',
    'transactionDate' => date('Y-m-d H:i:s'),
    'accountNumber' => '91902203843',
    'subAccount' => null,
    'code' => null,
    'content' => $orderCode,
    'transferType' => 'in',
    'description' => 'BankAPINotify ' . $orderCode,
    'transferAmount' => (float)$amount,
    'referenceCode' => 'SIM' . time() . rand(1000, 9999),
    'accumulated' => (float)$amount,
    'id' => rand(10000, 99999)
];

// Ghi log
$logFile = __DIR__ . '/simulate_payment_log.txt';
$logMessage = date('Y-m-d H:i:s') . ' - Simulating payment: ' . json_encode($paymentData) . PHP_EOL;
file_put_contents($logFile, $logMessage, FILE_APPEND);

// Hiển thị form để gửi dữ liệu
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mô phỏng thanh toán SePay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="card mx-auto" style="max-width: 800px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Mô phỏng thanh toán SePay</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <strong>Lưu ý:</strong> Công cụ này chỉ dùng để test trong môi trường phát triển.
                </div>
                
                <h5 class="mb-3">Thông tin thanh toán</h5>
                <div class="mb-3">
                    <p><strong>Mã đơn hàng:</strong> <?php echo $orderCode; ?></p>
                    <p><strong>Số tiền:</strong> <?php echo number_format($amount, 0, ',', '.'); ?>đ</p>
                    <p><strong>Mã giao dịch:</strong> <?php echo $paymentData['referenceCode']; ?></p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Dữ liệu JSON sẽ gửi đến webhook:</label>
                    <textarea class="form-control font-monospace" rows="10" readonly><?php echo json_encode($paymentData, JSON_PRETTY_PRINT); ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Webhook URL:</label>
                    <input type="text" class="form-control" id="webhookUrl" value="https://5395-2402-800-63b3-eafc-db9-75c9-4717-1392.ngrok-free.app/DuAn_CNM/view/api/sepay_webhook.php">
                </div>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-success" id="sendPayment">
                        <i class="fas fa-paper-plane me-2"></i>Mô phỏng thanh toán thành công
                    </button>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">Quay lại</a>
                </div>
                
                <div class="mt-4" id="resultContainer" style="display: none;">
                    <h5>Kết quả:</h5>
                    <div class="alert" id="resultAlert">
                        <pre id="resultContent" class="mb-0"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('sendPayment').addEventListener('click', function() {
            const webhookUrl = document.getElementById('webhookUrl').value;
            const paymentData = <?php echo json_encode($paymentData); ?>;
            const resultContainer = document.getElementById('resultContainer');
            const resultAlert = document.getElementById('resultAlert');
            const resultContent = document.getElementById('resultContent');
            
            // Hiển thị đang xử lý
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang xử lý...';
            
            // Gửi dữ liệu đến webhook
            fetch(webhookUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(paymentData)
            })
            .then(response => {
                const status = response.status;
                return response.json().then(data => {
                    return {
                        status: status,
                        data: data
                    };
                });
            })
            .then(result => {
                // Hiển thị kết quả
                resultContainer.style.display = 'block';
                
                if (result.status >= 200 && result.status < 300) {
                    resultAlert.className = 'alert alert-success';
                    if (result.data.success) {
                        resultContent.textContent = 'Thanh toán thành công!\n\n' + JSON.stringify(result.data, null, 2);
                    } else {
                        resultContent.textContent = 'Webhook xử lý không thành công:\n\n' + JSON.stringify(result.data, null, 2);
                    }
                } else {
                    resultAlert.className = 'alert alert-danger';
                    resultContent.textContent = 'Lỗi ' + result.status + ':\n\n' + JSON.stringify(result.data, null, 2);
                }
                
                // Khôi phục nút
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Mô phỏng thanh toán thành công';
            })
            .catch(error => {
                // Hiển thị lỗi
                resultContainer.style.display = 'block';
                resultAlert.className = 'alert alert-danger';
                resultContent.textContent = 'Lỗi kết nối: ' + error.message;
                
                // Khôi phục nút
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Mô phỏng thanh toán thành công';
            });
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>

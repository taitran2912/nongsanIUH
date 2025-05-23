<?php
// Trang test thanh toán - chỉ dùng để kiểm tra hệ thống
if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href = '?action=login';</script>";
    exit;
}

// Lấy order code từ session hoặc URL
$orderCode = $_SESSION['sepay_payment']['order_code'] ?? $_GET['order_code'] ?? '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Thanh Toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .test-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }
        .alert-warning {
            border-left: 4px solid #ffc107;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="test-container">
            <div class="alert alert-warning">
                <h5><i class="fas fa-exclamation-triangle"></i> Trang Test Thanh Toán</h5>
                <p>Trang này chỉ dùng để kiểm tra hệ thống thanh toán trong môi trường phát triển.</p>
            </div>
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Mô Phỏng Thanh Toán</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($orderCode)): ?>
                        <p><strong>Mã đơn hàng:</strong> <span class="text-primary"><?php echo $orderCode; ?></span></p>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <button id="completePayment" class="btn btn-success w-100">
                                    <i class="fas fa-check"></i> Mô phỏng thanh toán thành công
                                </button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <button id="cancelPayment" class="btn btn-danger w-100">
                                    <i class="fas fa-times"></i> Mô phỏng hủy thanh toán
                                </button>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <button id="checkStatus" class="btn btn-info w-100">
                                <i class="fas fa-search"></i> Kiểm tra trạng thái đơn hàng
                            </button>
                        </div>
                        
                        <div id="result" class="mt-3"></div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <p>Không tìm thấy mã đơn hàng. Vui lòng tạo đơn hàng trước khi test.</p>
                            <a href="?action=cart" class="btn btn-primary">Đi đến giỏ hàng</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="mt-3 text-center">
                <a href="?action=sepay_checkout" class="btn btn-outline-secondary">Quay lại trang thanh toán</a>
                <a href="?action=cart" class="btn btn-outline-primary">Giỏ hàng</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderCode = '<?php echo $orderCode; ?>';
            const resultDiv = document.getElementById('result');
            
            // Mô phỏng thanh toán thành công
            document.getElementById('completePayment')?.addEventListener('click', function() {
                simulatePayment('complete');
            });
            
            // Mô phỏng hủy thanh toán
            document.getElementById('cancelPayment')?.addEventListener('click', function() {
                simulatePayment('cancel');
            });
            
            // Kiểm tra trạng thái
            document.getElementById('checkStatus')?.addEventListener('click', function() {
                checkPaymentStatus();
            });
            
            function simulatePayment(action) {
                resultDiv.innerHTML = '<div class="alert alert-info">Đang xử lý...</div>';
                
                fetch('../api/simulate_payment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        order_code: orderCode,
                        action: action
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const alertClass = action === 'complete' ? 'alert-success' : 'alert-warning';
                        resultDiv.innerHTML = `<div class="alert ${alertClass}">${data.message}</div>`;
                        
                        if (action === 'complete') {
                            setTimeout(() => {
                                window.location.href = `?action=thank_you&order_id=${data.order_id}`;
                            }, 2000);
                        }
                    } else {
                        resultDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                    }
                })
                .catch(error => {
                    resultDiv.innerHTML = '<div class="alert alert-danger">Có lỗi xảy ra khi xử lý yêu cầu.</div>';
                    console.error('Error:', error);
                });
            }
            
            function checkPaymentStatus() {
                resultDiv.innerHTML = '<div class="alert alert-info">Đang kiểm tra trạng thái...</div>';
                
                fetch('../api/check_sepay_payment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        order_code: orderCode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const alertClass = data.success ? 'alert-success' : 'alert-warning';
                    resultDiv.innerHTML = `<div class="alert ${alertClass}">${data.message}</div>`;
                })
                .catch(error => {
                    resultDiv.innerHTML = '<div class="alert alert-danger">Có lỗi xảy ra khi kiểm tra trạng thái.</div>';
                    console.error('Error:', error);
                });
            }
        });
    </script>
</body>
</html>

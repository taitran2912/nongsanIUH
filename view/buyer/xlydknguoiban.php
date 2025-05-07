<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "nongsan_db";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thiết lập charset
$conn->set_charset("utf8mb4");

// Kiểm tra nếu form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $fullName = sanitizeInput($_POST["fullName"]);
    $email = sanitizeInput($_POST["email"]);
    $password = $_POST["password"];
    $phone = sanitizeInput($_POST["phone"]);
    $alternatePhone = isset($_POST["alternatePhone"]) ? sanitizeInput($_POST["alternatePhone"]) : "";
    $address = sanitizeInput($_POST["address"]);
    $province = sanitizeInput($_POST["province"]);
    $district = sanitizeInput($_POST["district"]);
    $ward = sanitizeInput($_POST["ward"]);
    $businessName = sanitizeInput($_POST["businessName"]);
    $businessType = sanitizeInput($_POST["businessType"]);
    $taxCode = isset($_POST["taxCode"]) ? sanitizeInput($_POST["taxCode"]) : "";
    $productCategory = sanitizeInput($_POST["productCategory"]);
    $businessDescription = isset($_POST["businessDescription"]) ? sanitizeInput($_POST["businessDescription"]) : "";
    
    // Kiểm tra email đã tồn tại chưa
    $checkEmailSql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmailSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Email đã tồn tại
        header("Location: register.php?error=email_exists");
        exit();
    }
    
    // Mã hóa mật khẩu
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Bắt đầu transaction
    $conn->begin_transaction();
    
    try {
        // Thêm thông tin người dùng vào bảng users
        $insertUserSql = "INSERT INTO users (full_name, email, password, phone, role, created_at) 
                          VALUES (?, ?, ?, ?, 'seller', NOW())";
        $stmt = $conn->prepare($insertUserSql);
        $role = "seller";
        $stmt->bind_param("ssss", $fullName, $email, $hashedPassword, $phone);
        $stmt->execute();
        
        // Lấy ID của người dùng vừa thêm
        $userId = $conn->insert_id;
        
        // Thêm thông tin người bán vào bảng sellers
        $insertSellerSql = "INSERT INTO sellers (user_id, business_name, business_type, tax_code, 
                            address, province, district, ward, alternate_phone, product_category, 
                            business_description, status, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";
        $stmt = $conn->prepare($insertSellerSql);
        $status = "pending";
        $stmt->bind_param("issssssssss", $userId, $businessName, $businessType, $taxCode, 
                         $address, $province, $district, $ward, $alternatePhone, 
                         $productCategory, $businessDescription);
        $stmt->execute();
        
        // Commit transaction
        $conn->commit();
        
        // Gửi email thông báo
        sendConfirmationEmail($email, $fullName);
        
        // Chuyển hướng đến trang thành công
        header("Location: registration_success.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaction nếu có lỗi
        $conn->rollback();
        header("Location: register.php?error=db_error");
        exit();
    }
}

// Hàm làm sạch dữ liệu đầu vào
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Hàm gửi email xác nhận
function sendConfirmationEmail($email, $name) {
    $subject = "Đăng ký tài khoản người bán thành công";
    
    $message = "
    <html>
    <head>
        <title>Đăng ký tài khoản người bán thành công</title>
    </head>
    <body>
        <div style='max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;'>
            <div style='background-color: #1e88e5; padding: 20px; color: white; text-align: center;'>
                <h1>Chào mừng bạn đến với Sàn Giao Dịch Nông Sản</h1>
            </div>
            <div style='padding: 20px; background-color: #f9f9f9;'>
                <p>Xin chào <strong>$name</strong>,</p>
                <p>Cảm ơn bạn đã đăng ký trở thành người bán trên sàn giao dịch nông sản của chúng tôi.</p>
                <p>Đơn đăng ký của bạn đang được xem xét. Chúng tôi sẽ liên hệ với bạn trong vòng 24-48 giờ để xác nhận thông tin.</p>
                <p>Trong thời gian chờ đợi, bạn có thể đăng nhập vào tài khoản để cập nhật thông tin cá nhân và chuẩn bị các thông tin sản phẩm của bạn.</p>
                <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua email: <a href='mailto:hotro@nongsan.vn'>hotro@nongsan.vn</a> hoặc số điện thoại: 1900 xxxx.</p>
                <div style='text-align: center; margin-top: 30px;'>
                    <a href='https://nongsan.vn/login' style='background-color: #1e88e5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Đăng nhập ngay</a>
                </div>
                <p style='margin-top: 30px;'>Trân trọng,<br>Đội ngũ Sàn Giao Dịch Nông Sản</p>
            </div>
            <div style='text-align: center; padding: 20px; font-size: 12px; color: #666;'>
                <p>© 2025 Sàn Giao Dịch Nông Sản. Tất cả các quyền được bảo lưu.</p>
                <p>Địa chỉ: 123 Đường ABC, Quận XYZ, Thành phố HCM</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Headers cho email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Sàn Giao Dịch Nông Sản <no-reply@nongsan.vn>" . "\r\n";
    
    // Gửi email
    mail($email, $subject, $message, $headers);
}

$conn->close();
?>
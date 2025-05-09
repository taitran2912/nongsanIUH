<?php
include_once("controller/CUser.php");

$CUser = new CUser();

$errors = [];
$success = false;

// Process registration form
if (isset($_POST["btnRegister"])) {
    // Get form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    
    // Validate inputs
    if (empty($name)) {
        $errors[] = "Tên không được để trống";
    }
    
    if (empty($email)) {
        $errors[] = "Email không được để trống";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ";
    } 
    // else {
    //     // Check if email already exists
    //     $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    //     $stmt->bind_param("s", $email);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     if ($result->num_rows > 0) {
    //         $errors[] = "Email đã được sử dụng";
    //     }
    //     $stmt->close();
    // }
    
    if (empty($password)) {
        $errors[] = "Mật khẩu không được để trống";
    } elseif (strlen($password) < 6) {
        $errors[] = "Mật khẩu phải có ít nhất 6 ký tự";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Mật khẩu xác nhận không khớp";
    }
    
    if (empty($phone)) {
        $errors[] = "Số điện thoại không được để trống";
    }
    
    if (empty($address)) {
        $errors[] = "Địa chỉ không được để trống";
    }
    
    // If no errors, insert user into database
    if (empty($errors)) {
        // Hash password
        $hashed_password = md5($password);
        
        // Default role is 0 (regular user)
        $role = 1;
        
        $status = $CUser->register($name, $email, $hashed_password, $phone, $address, $role);
        
        if ($status) {
            $success = true;
        } else {
            $errors[] = "Đăng ký thất bại: ";
        }
    }
}
?>
<?php if ($success): ?>
    <div class="alert alert-success">
        Đăng ký thành công! <a href="log.php?login" class="link">Đăng nhập ngay</a>
    </div>
<?php else: ?>
    <h2 class="text-center">Đăng ký tài khoản</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Họ và tên" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
        </div>
        
        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        </div>
        
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
        </div>
        
        <div class="form-group">
            <input type="password" name="confirm_password" class="form-control" placeholder="Xác nhận mật khẩu">
        </div>
        
        <div class="form-group">
            <input type="tel" name="phone" class="form-control" placeholder="Số điện thoại" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
        </div>
        
        <div class="form-group">
            <textarea name="address" class="form-control" placeholder="Địa chỉ" rows="3"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
        </div>
        
        <div class="form-group">
            <button type="submit" name="btnRegister" class="btn">Đăng ký</button>
        </div>
        
        <p class="text-center">Đã có tài khoản? <a href="?login" class="link">Đăng nhập</a></p>
    </form>
<?php endif; ?>


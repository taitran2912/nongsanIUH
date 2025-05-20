<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION["id"])) {
    echo "<script>
            alert('Vui lòng đăng nhập để tiếp tục');
            window.location.href = '../customer/login.php';
          </script>";
    exit();
}

// Get user ID from session
$id = intval($_SESSION["id"]);

// Include controller
include_once '../../controller/cBuyer.php';
$p = new cBuyer();

// Check if user has a shop
$r = $p->checkShop($id);
if($r && $r->num_rows > 0){
    $row = $r->fetch_assoc();
    $countShop = $row['count'];
    if($countShop == 0){
        echo "<script>
                alert('Bạn không có quyền truy cập');
                window.location.href = '../customer/index.php';
              </script>";
        exit();
    }
}

// Get farm ID and name
$storeId = 0;
$storeName = "";
$r = $p->getFarm($id);
if($r && $r->num_rows > 0){
    $row = $r->fetch_assoc();
    $storeId = $row['id'];
    $storeName = $row['shopname'];
}else {
    echo "<script>
            alert('Bạn không có quyền truy cập');
            window.location.href = '../customer/index.php';
          </script>";
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nongsan";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set
mysqli_set_charset($conn, "utf8mb4");

// Get categories for dropdown
$sql_categories = "SELECT * FROM categories";
$result_categories = $conn->query($sql_categories);

// Process form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $id_categories = $_POST['id_categories'];
    $status = 4; // Default status as requested
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Insert product data
        $sql = "INSERT INTO products (name, description, price, quantity, farm_id, id_categories, unit, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $conn->prepare($sql);
        // Correct parameter binding: s=string, d=double, i=integer
        $stmt->bind_param("ssdiiisi", $name, $description, $price, $quantity, $storeId, $id_categories, $unit, $status);
        
        if ($stmt->execute()) {
            $product_id = $conn->insert_id; // Get the ID of the newly inserted product
            
            // Handle image upload
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
                // Define allowed file types
                $allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp');
                
                // Get file info
                $filename = $_FILES['product_image']['name'];
                $temp_name = $_FILES['product_image']['tmp_name'];
                $file_size = $_FILES['product_image']['size'];
                $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                // Check if file type is allowed
                if (in_array($file_ext, $allowed)) {
                    // Check file size - 5MB maximum
                    if ($file_size <= 5000000) {
                        // Create upload directory if it doesn't exist
                        $upload_dir = __DIR__ . '/../../image/';
                        $upload_path = $upload_dir . $new_filename;
                        if (!file_exists($upload_dir)) {
                            mkdir($upload_dir, 0755, true);
                        }
                        
                        // Generate unique filename to prevent overwriting
                        $new_filename = uniqid() . '.' . $file_ext;
                        $upload_path = $upload_dir . $new_filename;
                        
                        // Move uploaded file to destination
                        if (move_uploaded_file($temp_name, $upload_path)) {
                            // Insert image info into product_images table
                            $sql_image = "INSERT INTO product_images (product_id, img) VALUES (?, ?)";
                            $stmt_image = $conn->prepare($sql_image);
                            $stmt_image->bind_param("is", $product_id, $new_filename);
                            
                            if (!$stmt_image->execute()) {
                                throw new Exception("Lỗi khi lưu thông tin hình ảnh: " . $stmt_image->error);
                            }
                            $stmt_image->close();
                        } else {
                            $error = error_get_last();
                            throw new Exception("Lỗi khi tải lên hình ảnh: " . ($error ? $error['message'] : 'Không xác định'));
                        }
                    } else {
                        throw new Exception("Kích thước file quá lớn. Tối đa 5MB");
                    }
                } else {
                    throw new Exception("Loại file không được hỗ trợ. Chỉ chấp nhận: " . implode(', ', $allowed));
                }
            }
            
            // Commit transaction
            $conn->commit();
            $message = '<div class="alert alert-success">Sản phẩm đã được thêm thành công!</div>';
        } else {
            throw new Exception("Lỗi khi thêm sản phẩm: " . $stmt->error);
        }
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $message = '<div class="alert alert-danger">Lỗi: ' . $e->getMessage() . '</div>';
    }
    
    $stmt->close();
}
?>

<div class="content-header d-flex justify-content-between align-items-center">
    <h2>Thêm sản phẩm</h2>
    <a href="?action=product" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
</div>

<div class="container mt-4">
    <?php echo $message; ?>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Giá bán <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
                            <span class="input-group-text">VNĐ</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="quantity" class="form-label">Số lượng <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="0" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="unit" class="form-label">Đơn vị <span class="text-danger">*</span></label>
                        <select class="form-select" id="unit" name="unit" required>
                            <option value="kg">kg</option>
                            <option value="g">g</option>
                            <option value="cái">cái</option>
                            <option value="hộp">hộp</option>
                            <option value="bó">bó</option>
                            <option value="túi">túi</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="id_categories" class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select" id="id_categories" name="id_categories" required>
                            <?php
                            if ($result_categories->num_rows > 0) {
                                while($row = $result_categories->fetch_assoc()) {
                                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="product_image" class="form-label">Hình ảnh sản phẩm <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*" required onchange="previewImage(this)">
                    <small class="text-muted">Hỗ trợ các định dạng: JPG, JPEG, PNG, GIF, WEBP. Kích thước tối đa: 5MB</small>
                    <div class="image-preview mt-2" id="imagePreview" style="max-width: 300px; display: none;">
                        <img src="#" alt="Xem trước hình ảnh" id="preview" class="img-fluid border rounded">
                    </div>
                </div>
                
                <!-- Hidden field for status -->
                <input type="hidden" name="status" value="4">
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-outline-secondary me-md-2" onclick="resetImagePreview()">Làm mới</button>
                    <button type="submit" class="btn btn-success">Lưu sản phẩm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for image preview -->
<script>
    function previewImage(input) {
        var preview = document.getElementById('preview');
        var previewDiv = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewDiv.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            previewDiv.style.display = 'none';
        }
    }
    
    function resetImagePreview() {
        var preview = document.getElementById('preview');
        var previewDiv = document.getElementById('imagePreview');
        
        preview.src = '#';
        previewDiv.style.display = 'none';
        document.getElementById('product_image').value = '';
    }
</script>
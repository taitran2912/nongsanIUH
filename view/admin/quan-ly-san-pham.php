<?php  

    // Thêm kết nối đến cơ sở dữ liệu và truy vấn dữ liệu
    try {
        // Kết nối đến cơ sở dữ liệu
        $host = "localhost";
        $dbname = "nongsan"; // Thay đổi tên database nếu cần
        $username = "root";
        $password = "";
        
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Xử lý xóa sản phẩm nếu có yêu cầu
        if(isset($_POST['delete_product']) && isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
            
            // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
            $conn->beginTransaction();
            
            try {
                // Xóa hình ảnh sản phẩm trước (để tránh lỗi khóa ngoại)
                $delete_images = "DELETE FROM product_images WHERE product_id = :product_id";
                $stmt_images = $conn->prepare($delete_images);
                $stmt_images->bindParam(':product_id', $product_id);
                $stmt_images->execute();
                
                // Xóa sản phẩm
                $delete_product = "DELETE FROM products WHERE id = :product_id";
                $stmt_product = $conn->prepare($delete_product);
                $stmt_product->bindParam(':product_id', $product_id);
                $stmt_product->execute();
                
                // Commit transaction
                $conn->commit();
                
                // Thông báo thành công
                echo "<div class='alert alert-success'>Xóa sản phẩm thành công!</div>";
                
            } catch(Exception $e) {
                // Rollback transaction nếu có lỗi
                $conn->rollBack();
                echo "<div class='alert alert-danger'>Lỗi khi xóa sản phẩm: " . $e->getMessage() . "</div>";
            }
        }
        
        // Truy vấn dữ liệu sản phẩm
        $query = "SELECT products.*, product_images.img FROM products LEFT JOIN product_images ON 
        products.id = product_images.product_id ORDER BY products.id ASC;";
        $result = $conn->prepare($query);
        $result->execute();
        
    } catch(PDOException $e) {
        echo "Lỗi kết nối: " . $e->getMessage();
        $result = null; // Đảm bảo $result được định nghĩa ngay cả khi có lỗi
    }
?>

<h1>Quản lý sản phẩm</h1>
<table class="product-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Hình ảnh</th>
            <th>Tên</th>
            <th>Mô tả</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tùy chọn</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($result && $result->rowCount() > 0) {
            while($row = $result->fetch(PDO::FETCH_ASSOC)): 
        ?>
        <tr style="height: 80px">
            <td><?php echo $row['id']; ?></td>
            <td><img src="../../image/<?php echo $row['img']; ?>" alt="" style="width:50px;"></td>
            <td><?php echo $row['name']; ?></td>
            <td class="product-truncate"><?php echo $row['description']; ?></td>
            <td><?php echo number_format($row['price'], 0, ',', '.') . ' VNĐ'; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>
                <button class="product-btn" onclick="openProductModal(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)">Xem chi tiết</button>
                <button class="product-btn delete-btn" onclick="confirmDelete(<?php echo $row['id']; ?>, '<?php echo addslashes($row['name']); ?>')">Xóa</button>
            </td>
        </tr>
        <?php 
            endwhile; 
        } else {
            echo "<tr><td colspan='7' style='text-align:center'>Không có sản phẩm nào</td></tr>";
        }
        ?>
    </tbody>
</table> 

<!-- Modal Chi tiết sản phẩm -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeProductModal()">&times;</span>
        <h2 id="modalTitle">Chi tiết sản phẩm</h2>
        <div class="product-detail">
            <div class="product-image">
                <img id="modalImage" src="../../image/" alt="Hình ảnh sản phẩm">
            </div>
            <div class="product-info">
                <h3 id="modalName" class="product-title"></h3>
                <div id="modalPrice" class="product-price"></div>
                <div id="modalQuantity" class="product-quantity"></div>
                <div class="product-description">
                    <h4>Mô tả:</h4>
                    <p id="modalDescription"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xác nhận xóa sản phẩm -->
<div id="deleteModal" class="modal">
    <div class="modal-content" style="max-width: 500px;">
        <span class="close" onclick="closeDeleteModal()">&times;</span>
        <h2>Xác nhận xóa sản phẩm</h2>
        <p id="deleteMessage"></p>
        <div style="margin-top: 20px; text-align: right;">
            <form method="POST" id="deleteForm">
                <input type="hidden" name="delete_product" value="1">
                <input type="hidden" name="product_id" id="deleteProductId">
                <button type="button" class="product-btn" onclick="closeDeleteModal()">Hủy</button>
                <button type="submit" class="product-btn delete-btn">Xác nhận xóa</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Lấy modal
    var productModal = document.getElementById("productModal");
    var deleteModal = document.getElementById("deleteModal");
    
    // Hàm mở modal và hiển thị thông tin sản phẩm
    function openProductModal(product) {
        // Cập nhật thông tin sản phẩm trong modal
        document.getElementById("modalName").textContent = product.name;
        document.getElementById("modalPrice").textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price);
        document.getElementById("modalQuantity").textContent = "Số lượng: " + product.quantity;
        document.getElementById("modalDescription").textContent = product.description;
        
        // Cập nhật hình ảnh
        var imagePath = "../../image/" + product.img; // Điều chỉnh đường dẫn thư mục hình ảnh nếu cần
        document.getElementById("modalImage").src = imagePath;
        
        // Hiển thị modal
        productModal.style.display = "block";
    }
    
    // Hàm đóng modal chi tiết sản phẩm
    function closeProductModal() {
        productModal.style.display = "none";
    }
    
    // Hàm xác nhận xóa sản phẩm
    function confirmDelete(productId, productName) {
        document.getElementById("deleteMessage").textContent = "Bạn có chắc chắn muốn xóa sản phẩm '" + productName + "' không?";
        document.getElementById("deleteProductId").value = productId;
        deleteModal.style.display = "block";
    }
    
    // Hàm đóng modal xác nhận xóa
    function closeDeleteModal() {
        deleteModal.style.display = "none";
    }
    
    // Đóng modal khi nhấp vào bên ngoài modal
    window.onclick = function(event) {
        if (event.target == productModal) {
            closeProductModal();
        }
        if (event.target == deleteModal) {
            closeDeleteModal();
        }
    }
</script>
<?php  
// Kết nối đến cơ sở dữ liệu
try {
    $host = "localhost";
    $dbname = "nongsan";
    $username = "root";
    $password = "";
    
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Xử lý xóa sản phẩm nếu có yêu cầu
    if(isset($_POST['delete_product']) && isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        $conn->beginTransaction();

        try {
            $conn->prepare("DELETE FROM product_images WHERE product_id = :product_id")
                ->execute([':product_id' => $product_id]);

            $conn->prepare("DELETE FROM products WHERE id = :product_id")
                ->execute([':product_id' => $product_id]);

            $conn->commit();
            echo "<div class='alert alert-success'>Xóa sản phẩm thành công!</div>";
        } catch(Exception $e) {
            $conn->rollBack();
            echo "<div class='alert alert-danger'>Lỗi khi xóa sản phẩm: " . $e->getMessage() . "</div>";
        }
    }

    // Truy vấn dữ liệu sản phẩm
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : "";
    $sql = "SELECT products.*, product_images.img, farms.name AS farm_name, farms.address AS
    farm_address, farms.description AS farm_description FROM products 
    LEFT JOIN product_images ON products.id = product_images.product_id 
    LEFT JOIN farms ON products.farm_id = farms.id";

    if ($searchTerm !== "") {
        $sql .= " WHERE products.name LIKE :search OR products.description LIKE :search OR farms.name LIKE :search";
    }

    $sql .= " ORDER BY products.id ASC";
    $stmt = $conn->prepare($sql);

    if ($searchTerm !== "") {
        $stmt->execute([':search' => "%$searchTerm%"]);
    } else {
        $stmt->execute();
    }

} catch(PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
    $stmt = null;
}
?>

<!-- Giao diện HTML -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1 style="margin: 0;">Quản lý sản phẩm</h1>
    <form method="GET" style="display: flex; gap: 10px;">
        <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." 
               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
               style="padding: 5px; width: 250px;">
        <button type="submit" style="padding: 5px 10px;">Tìm kiếm</button>
    </form>
</div>

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
        if ($stmt && $stmt->rowCount() > 0):
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
        ?>
        <tr style="height: 80px">
            <td><?= $row['id']; ?></td>
            <td><img src="../../image/<?= $row['img']; ?>" style="width:50px;"></td>
            <td><?= $row['name']; ?></td>
            <td class="product-truncate"><?= $row['description']; ?></td>
            <td><?= number_format($row['price'], 0, ',', '.') . ' VNĐ'; ?></td>
            <td><?= $row['quantity']; ?></td>
            <td>
                <button class="product-btn" onclick="openProductModal(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)">Xem chi tiết</button>
                <button class="product-btn delete-btn" onclick="confirmDelete(<?= $row['id']; ?>, '<?= addslashes($row['name']); ?>')">Xóa</button>
            </td>
        </tr>
        <?php 
            endwhile;
        else:
            echo "<tr><td colspan='7' style='text-align:center'>Không có sản phẩm nào</td></tr>";
        endif;
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
                <div class="farm-info" style="margin-top: 20px;">
                    <h4>Thông tin nông trại:</h4>
                    <p><strong>Tên nông trại:</strong> <span id="modalFarmName"></span></p>
                    <p><strong>Địa chỉ:</strong> <span id="modalFarmAddress"></span></p>
                    <p><strong>Mô tả:</strong> <span id="modalFarmDescription"></span></p>
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

<!-- JavaScript -->
<script>
    var productModal = document.getElementById("productModal");
    var deleteModal = document.getElementById("deleteModal");

    function openProductModal(product) {
        document.getElementById("modalName").textContent = product.name;
        document.getElementById("modalPrice").textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price);
        document.getElementById("modalQuantity").textContent = "Số lượng: " + product.quantity;
        document.getElementById("modalDescription").textContent = product.description;
        document.getElementById("modalFarmName").textContent = product.farm_name || "Chưa cập nhật";
        document.getElementById("modalFarmAddress").textContent = product.farm_address || "Chưa cập nhật";
        document.getElementById("modalFarmDescription").textContent = product.farm_description || "Chưa cập nhật";
        document.getElementById("modalImage").src = "../../image/" + product.img;
        productModal.style.display = "block";
    }

    function closeProductModal() {
        productModal.style.display = "none";
    }

    function confirmDelete(productId, productName) {
        document.getElementById("deleteMessage").textContent = "Bạn có chắc chắn muốn xóa sản phẩm '" + productName + "' không?";
        document.getElementById("deleteProductId").value = productId;
        deleteModal.style.display = "block";
    }

    function closeDeleteModal() {
        deleteModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == productModal) closeProductModal();
        if (event.target == deleteModal) closeDeleteModal();
    }
</script>

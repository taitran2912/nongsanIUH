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
        
        // Truy vấn dữ liệu sản phẩm
        $query = "SELECT * FROM products ORDER BY id ASC";
        $result = $conn->prepare($query);
        $result->execute();
        
    } catch(PDOException $e) {
        echo "Lỗi kết nối: " . $e->getMessage();
        $result = null; // Đảm bảo $result được định nghĩa ngay cả khi có lỗi
    }
?>
      
<table class="product-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Mô tả</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($result && $result->rowCount() > 0) {
            while($row = $result->fetch(PDO::FETCH_ASSOC)): 
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td class="product-truncate"><?php echo $row['description']; ?></td>
            <td><?php echo number_format($row['price'], 0, ',', '.') . ' VNĐ'; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>
                <a href="index.php?action=xem-san-pham&id=<?php echo $row['id']; ?>" class="product-btn">Xem chi tiết</a>
            </td>
        </tr>
        <?php 
            endwhile; 
        } else {
            echo "<tr><td colspan='6' style='text-align:center'>Không có sản phẩm nào</td></tr>";
        }
        ?>
    </tbody>
</table>



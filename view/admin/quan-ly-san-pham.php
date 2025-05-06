<?php
    echo"<h1> Quản lý sản phẩm</h1>";
    
    // Thêm kết nối đến cơ sở dữ liệu và truy vấn dữ liệu
    try {
        // Kết nối đến cơ sở dữ liệu
        $host = "localhost";
        $dbname = "nongsan"; // Thay đổi tên database nếu cần
        $username = "root";
        $password = "123456";
        
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
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 235px;
            background-color: #2c3e50;
            color: white;
            padding-top: 20px;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li {
            padding: 10px 20px;
        }
        .sidebar-menu li.active {
            background-color: #34495e;
        }
        .sidebar-menu li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar-menu li a i {
            margin-right: 10px;
        }
        .sidebar-submenu {
            list-style: none;
            padding-left: 30px;
            margin: 10px 0;
        }
        .sidebar-submenu li {
            padding: 8px 0;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #ecf0f1;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .content {
            margin-top: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #20c997;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .btn {
            display: inline-block;
            padding: 8px 12px;
            background-color: #20c997;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #16a085;
        }
        .truncate {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .add-btn {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        
        <!-- Main Content -->
        <div class="main-content">
            

            <div class="content">
                
                
                <table>
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
                            <td class="truncate"><?php echo $row['description']; ?></td>
                            <td><?php echo number_format($row['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td>
                                <a href="index.php?action=xem-san-pham&id=<?php echo $row['id']; ?>" class="btn">Xem chi tiết</a>
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
            </div>
        </div>
    </div>
</body>
</html>
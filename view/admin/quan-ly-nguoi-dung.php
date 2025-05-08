<?php
include_once("../../controller/cSearchUser.php");
$p = new cSearch();
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <form class="form-inline" method="POST" >
        <!-- Thanh tìm kiếm + nút Tìm -->
        <div class="form-group">
          <div class="input-group">
            <input class="form-control" type="search" placeholder="Nhập từ khóa..." name="txtSearch" id="searchInput">
            <span class="input-group-btn">
              <button class="btn btn-primary" name="btnSearch" type="submit">Tìm</button>
            </span>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<?php
    if (isset($_POST["btnSearch"])) {
        $kw = $_POST["txtSearch"];
        $kq = $p->search($kw); // dùng chung biến $kq cho dễ quản lý
    } else {
        $kq = $p->list(); // mặc định hiển thị tất cả
    }

    if ($kq) {
        if ($kq->num_rows > 0) {
            echo "<table class='table table-bordered table-hover'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th scope='col'>STT</th>";
            echo "<th scope='col'>Tên người dùng</th>";
            echo "<th scope='col'>Số điện thoại</th>";
            echo "<th scope='col'>Email</th>";
            echo "<th scope='col'>Địa chỉ</th>";
            echo "<th scope='col'>Thao tác</th>";

            echo "</tr>";
            echo "</thead><tbody>";
            $i =1;
            while ($row = $kq->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $i++ . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo '<td>
                    <form method="post">
                        <input type="hidden" name="idUser" value="'.$row['id'].'">
                        <input type="submit" name="delete" class="btn btn-danger" value="Xóa">
                    </form>
                </td>';

                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "Không có dữ liệu";
        }
    } else {
        echo "Kết nối thất bại hoặc lỗi truy vấn";
    }

    if (isset($_POST['delete'])) {     
        $id = $_POST['idUser'];
        if ($p->delete($id)) {         
            echo '<script language="javascript">             
                    alert("Xóa thành công!");             
                    window.location.href = "index.php?action=quan-ly-nguoi-dung";             
                </script>';     
        } else {         
            echo "<p>Đã xảy ra lỗi khi gửi yêu cầu.</p>";     
        } 
    }
?>

</div>
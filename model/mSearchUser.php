<?php
include_once("connect.php");
class mSearch{
    
    public function msearch($kw){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $kw = $conn->real_escape_string($kw); // tránh SQL injection
            $str = "SELECT * FROM users WHERE name LIKE '%$kw%' && role = 1";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        } else {
            return false;
        }
    }
    
    public function mList(){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $str = "SELECT * FROM users WHERE role = 1";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        }else{
            return false;
        }
    }
    
    public function mDelete($id){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');

        if ($conn) {
            // Kiểm tra xem user có farm có status = 0 hoặc 2 không
            $checkFarm = "SELECT COUNT(*) AS total FROM farms WHERE owner_id = $id && (status = 0 || status = 2);";
            $result = $conn->query($checkFarm);
        
            if ($result) {
                $row = $result->fetch_assoc();
                if ($row['total']  > 0) {
                    $p->dongKetNoi($conn);
                    echo "<script>alert('User đang sở hữu farm. Vui lòng xoá farm trước khi xoá user.');</script>";
                    return false;
                } else {
                    // User không có farm, tiến hành xoá
                    $deleteUser = "DELETE FROM users WHERE id = $id;";
                    $tbl = $conn->query($deleteUser);
                    $p->dongKetNoi($conn);
                    return $tbl;
                }
            } else {
                // Lỗi truy vấn
                echo "<script>alert('Lỗi khi kiểm tra farm.'); window.history.back();</script>";
                $p->dongKetNoi($conn);
                return false;
            }
        } else {
            echo "<script>alert('Không thể kết nối cơ sở dữ liệu.'); window.history.back();</script>";
            return false;
        }

    }

    
}
?>

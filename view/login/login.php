<form name="fmLogin" class="m-t" role="form" method="POST" action="">
    <div class="form-group">
        <input type="email" name="txtEmail" class="form-control" placeholder="Email" required="">
    </div>
    <div class="form-group">
        <input type="password" name="txtPass" class="form-control" placeholder="Password" required="">
    </div>
    <button type="submit" name="btnDN" class="btn btn-primary block full-width m-b">Đăng nhập</button>  
</form>
<?php
    if (isset($_POST["btnDN"])) {
        include_once("controller/CUser.php");
        $p = new CUser();
        $kq = $p->login($_POST["txtEmail"], $_POST["txtPass"]);
    }
?>
<div class="container-fluid">
<div class="seach">
    <form class="form-inline">
        <div class="row">
            <div class="form-group">
                <input class="form-control" type="search" placeholder="Nhập từ khóa..." name="txtSearch" aria-label="Search" id="searchInput">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" name="btnSearch" type="submit">Tìm</button>
            </div>
        </div>    
    </form>`
</div>
<?php
    if (isset($_POST["btnSearch"])) {
        include_once("controller/cSearch.php");
        $p = new cSearch();
        $kq = $p->search($_POST["txtSearch"]);
    }
?>
</div>
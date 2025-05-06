<?php
include_once("model/mSearch.php");
class cSearch{
    public function search($kw){
        $p = new mSearch();
        $ketqua = $p->searchWithKeyWord($kw);

    }
}
?>
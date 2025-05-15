<?php
include_once '../../controller/cProduct.php';
$p = new cProduct();
$idCate = isset($_GET['idCate']) ? $_GET['idCate'] : 0; 
?>
<!-- Products Section -->
<section class="products-page py-5">
    <div class="container">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-lg-3">
                <!-- Categories -->
                <div class="sidebar-widget mb-4">
                    <h4 class="widget-title">Danh mục sản phẩm</h4>
                    <div class="widget-content">
                        <ul class="category-list">
                            <li>
                                <a href="?action=product" class="active">
                                    <span>Tất cả sản phẩm</span>
                                </a>
                            </li>
                            <?php
                                $cat = $p->getAllCategorie();
                                if($cat)
                                    if($cat->num_rows > 0){
                                        while($row = $cat->fetch_assoc()){
                                            echo'
                                                <li>
                                                    <a href="?action=product&idCate='.$row['id'].'" class="category-link">
                                                        <span>'.ucwords($row['name']).'</span>
                                                    </a>
                                                </li>
                                            ';
                                        }
                                    }
                            ?>
                        </ul>
                    </div>
                </div>

                <!-- Filter by Price -->
                <div class="sidebar-widget mb-4">
                    <h4 class="widget-title">Lọc theo giá</h4>
                    <div class="widget-content">
                        <div class="price-range-slider">
                            <div class="price-input d-flex align-items-center mb-3">
                                <input type="number" class="form-control me-2" value="0" min="0" max="500000">
                                <span class="mx-2">-</span>
                                <input type="number" class="form-control ms-2" value="500000" min="0" max="500000">
                            </div>
                            <input type="range" class="form-range" min="0" max="500000" step="10000">
                            <button class="btn btn-success btn-sm mt-3 w-100">Áp dụng</button>
                        </div>
                    </div>
                </div>

                


            </div>

            <!-- Products -->
            <div class="col-lg-9">
                <!-- Toolbar -->
                <div class="products-toolbar mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="sort-by d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
                                <label class="me-2">Sắp xếp theo:</label>
                                <select class="form-select">
                                    <option selected>Mặc định</option>
                                    <option>Giá: Thấp đến cao</option>
                                    <option>Giá: Cao đến thấp</option>
                                    <option>Tên: A-Z</option>
                                    <option>Tên: Z-A</option>
                                    <option>Mới nhất</option>
                                    <option>Bán chạy nhất</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="products-grid">
                    <div class="row g-4">
                <!-- Product 1 -->  
                    <?php
                        if($idCate != 0){
                            $pd = $p->getProductByCategory($idCate);
                        }else{
                            $pd = $p->getAllProduct();
                        }
                        if($pd)
                            if($pd->num_rows > 0){
                                while($row = $pd->fetch_assoc()){
                                    echo'
                                        <div class="col-md-4">
                                            <div class="product-card">
                                                    <div class="product-thumb">
                                                        <img src="../../image/'.$row['img'].'" class="img-fluid" alt="'.$row['name'].'">
                                                        <div class="product-action">
                                                        <a href="#" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>
                                                        <a href="#" class="btn btn-light btn-sm"><i class="fas fa-heart"></i></a>
                                                        <a href="#" class="btn btn-success btn-sm"><i class="fas fa-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product-info p-3">
                                                    <span class="product-category">Rau củ</span>
                                                    <h5><a href="#" class="product-title">'.$row['name'].'</a></h5>
                                                    <div class="product-price">
                                                        <span class="new-price">'.$row['price'].'đ/kg</span>
                                                    </div>
                                                    <div class="product-rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star-half-alt"></i>
                                                        <span>(4.5)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ';
                                }
                            }    
                    ?>
                    

                        <!-- Pagination -->
                        <div class="pagination-container mt-5 text-center">
                            <button class="btn btn-outline-primary" id="loadMoreBtn">
                                Xem thêm</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="newsletter py-5 bg-success text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h3>Đăng ký nhận tin</h3>
                <p class="mb-0">Nhận thông tin về sản phẩm mới và khuyến mãi hấp dẫn</p>
            </div>
            <div class="col-lg-6">
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Nhập email của bạn">
                        <button class="btn btn-light" type="submit">Đăng ký</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>



<!-- Back to Top -->
<a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="../../asset/js/script.js"></script>
<!-- Products JS -->
<script src="../../asset/js/products.js"></script>

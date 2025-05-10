

    <!-- Breadcrumb -->
    <div class="bg-light py-2">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
                </ol>
            </nav>
        </div>
    </div>

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
                                    <a href="#" class="active">
                                        <span>Tất cả sản phẩm</span>
                                        <span class="count">120</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span>Rau củ</span>
                                        <span class="count">45</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span>Trái cây</span>
                                        <span class="count">38</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span>Gạo & Ngũ cốc</span>
                                        <span class="count">22</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span>Thực phẩm chế biến</span>
                                        <span class="count">15</span>
                                    </a>
                                </li>
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

                    <!-- Filter by Rating -->
                    <div class="sidebar-widget mb-4">
                        <h4 class="widget-title">Đánh giá</h4>
                        <div class="widget-content">
                            <div class="rating-filter">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="rating5">
                                    <label class="form-check-label" for="rating5">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="ms-2">(5)</span>
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="rating4">
                                    <label class="form-check-label" for="rating4">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <span class="ms-2">(4)</span>
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="rating3">
                                    <label class="form-check-label" for="rating3">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <span class="ms-2">(3)</span>
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="rating2">
                                    <label class="form-check-label" for="rating2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <span class="ms-2">(2)</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rating1">
                                    <label class="form-check-label" for="rating1">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <span class="ms-2">(1)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter by Origin -->
                    <div class="sidebar-widget mb-4">
                        <h4 class="widget-title">Xuất xứ</h4>
                        <div class="widget-content">
                            <div class="origin-filter">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="originVietnam">
                                    <label class="form-check-label" for="originVietnam">
                                        Việt Nam
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="originDalat">
                                    <label class="form-check-label" for="originDalat">
                                        Đà Lạt
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="originMekong">
                                    <label class="form-check-label" for="originMekong">
                                        Đồng bằng sông Cửu Long
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="originImported">
                                    <label class="form-check-label" for="originImported">
                                        Nhập khẩu
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Products -->
                    <div class="sidebar-widget">
                        <h4 class="widget-title">Sản phẩm nổi bật</h4>
                        <div class="widget-content">
                            <div class="featured-product d-flex mb-3">
                                <div class="featured-product-img me-3">
                                    <img src="../../image/bapcaitraitim.jpg" class="img-fluid rounded" alt="Bắp cải trái tim">
                                </div>
                                <div class="featured-product-info">
                                    <h6><a href="#">Bắp cải trái tim</a></h6>
                                    <div class="product-rating mb-1">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                    <div class="product-price">
                                        <span class="new-price">20.000đ/kg</span>
                                    </div>
                                </div>
                            </div>
                            <div class="featured-product d-flex mb-3">
                                <div class="featured-product-img me-3">
                                    <img src="../../image/bidonon.jpg" class="img-fluid rounded" alt="Bí đỏ non">
                                </div>
                                <div class="featured-product-info">
                                    <h6><a href="#">Bí đỏ non</a></h6>
                                    <div class="product-rating mb-1">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                    </div>
                                    <div class="product-price">
                                        <span class="new-price">25.000đ/kg</span>
                                    </div>
                                </div>
                            </div>
                            <div class="featured-product d-flex">
                                <div class="featured-product-img me-3">
                                    <img src="../../image/boxoi.jpg" class="img-fluid rounded" alt="Bó Xôi">
                                </div>
                                <div class="featured-product-info">
                                    <h6><a href="#">Bó xôi</a></h6>
                                    <div class="product-rating mb-1">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    </div>
                                    <div class="product-price">
                                        <span class="old-price">35.000đ</span>
                                        <span class="new-price">29.000đ/kg</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products -->
                <div class="col-lg-9">
                    <!-- Toolbar -->
                    <div class="products-toolbar mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <div class="view-mode me-4">
                                        <a href="#" class="grid-view active"><i class="fas fa-th"></i></a>
                                        <a href="#" class="list-view ms-2"><i class="fas fa-list"></i></a>
                                    </div>
                                    <div class="showing-results">
                                        Hiển thị 1-12 của 120 sản phẩm
                                    </div>
                                </div>
                            </div>
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
    <div class="col-md-4">
        <div class="product-card">
            <div class="product-badge bg-success">-15%</div>
                <div class="product-thumb">
                    <img src="../../image/bapcaitraitim.jpg" class="img-fluid" alt="Bắp cải trái tim">
                    <div class="product-action">
                    <a href="#" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>
                    <a href="#" class="btn btn-light btn-sm"><i class="fas fa-heart"></i></a>
                    <a href="#" class="btn btn-success btn-sm"><i class="fas fa-shopping-cart"></i></a>
                </div>
            </div>
    <div class="product-info p-3">
    <span class="product-category">Rau củ</span>
    <h5><a href="#" class="product-title">Bắp cải trái tim</a></h5>
    <div class="product-price">
        <span class="old-price">35.000đ</span>
        <span class="new-price">20.000đ/kg</span>
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

<!-- Product 2 -->
<div class="col-md-4">
    <div class="product-card">
        <div class="product-thumb">
            <img src="../../image/bidonon.jpg" class="img-fluid" alt="Bí đỏ non">
            <div class="product-action">
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-heart"></i></a>
                <a href="#" class="btn btn-success btn-sm"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
        <div class="product-info p-3">
            <span class="product-category">Rau củ</span>
            <h5><a href="#" class="product-title">Bí đỏ non</a></h5>
            <div class="product-price">
                <span class="new-price">20.000đ/kg</span>
            </div>
            <div class="product-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <span>(5.0)</span>
            </div>
        </div>
    </div>
</div>

<!-- Product 3 -->
<div class="col-md-4">
    <div class="product-card">
        <div class="product-badge bg-danger">Hot</div>
        <div class="product-thumb">
            <img src="../../image/gaonepcamDSTB.webp" class="img-fluid" alt="Gạo nếp cẩm ĐSTB">
            <div class="product-action">
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-heart"></i></a>
                <a href="#" class="btn btn-success btn-sm"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
        <div class="product-info p-3">
            <span class="product-category">Gạo & Ngũ cốc</span>
            <h5><a href="#" class="product-title">Gạo nếp cẩm ĐS Tây Bắc</a></h5>
            <div class="product-price">
                <span class="new-price">45.000đ/kg</span>
            </div>
            <div class="product-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <span>(4.0)</span>
            </div>
        </div>
    </div>
</div>

<!-- Product 4 -->
<div class="col-md-4">
    <div class="product-card">
        <div class="product-thumb">
            <img src="../../image/bungao.jpg" class="img-fluid" alt="Bún gạo">
            <div class="product-action">
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-heart"></i></a>
                <a href="#" class="btn btn-success btn-sm"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
        <div class="product-info p-3">
            <span class="product-category">Ngũ cốc</span>
            <h5><a href="#" class="product-title">Bún gạo</a></h5>
            <div class="product-price">
                <span class="new-price">22.000đ/kg</span>
            </div>
            <div class="product-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <i class="far fa-star"></i>
                <span>(3.5)</span>
            </div>
        </div>
    </div>
</div>

<!-- Product 5 -->
<div class="col-md-4">
    <div class="product-card">
        <div class="product-thumb">
            <img src="../../image/buoihoanglaunam.webp" class="img-fluid" alt="Bưởi hoàng lâu năm">
            <div class="product-action">
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-heart"></i></a>
                <a href="#" class="btn btn-success btn-sm"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
        <div class="product-info p-3">
            <span class="product-category">Trái cây</span>
            <h5><a href="#" class="product-title">Bưởi hoàng lâu năm</a></h5>
            <div class="product-price">
                <span class="new-price">72.000đ/kg</span>
            </div>
            <div class="product-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <span>(5.0)</span>
            </div>
        </div>
    </div>
</div>

<!-- Product 6 -->
<div class="col-md-4">
    <div class="product-card">
        <div class="product-badge bg-success">-10%</div>
        <div class="product-thumb">
            <img src="../../image/cachuabeef.jpg" class="img-fluid" alt="Cà chua beef">
            <div class="product-action">
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-heart"></i></a>
                <a href="#" class="btn btn-success btn-sm"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
        <div class="product-info p-3">
            <span class="product-category">Rau củ</span>
            <h5><a href="#" class="product-title">Cà chua beef</a></h5>
            <div class="product-price">
                <span class="old-price">30.000đ</span>
                <span class="new-price">27.000đ/kg</span>
            </div>
            <div class="product-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <span>(4.0)</span>
            </div>
        </div>
    </div>
</div>

<!-- Product 7 -->
<div class="col-md-4">
    <div class="product-card">
        <div class="product-thumb">
            <img src="../../image/cachuacherry.jpeg" class="img-fluid" alt="Cà chua cherry">
            <div class="product-action">
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-heart"></i></a>
                <a href="#" class="btn btn-success btn-sm"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
        <div class="product-info p-3">
            <span class="product-category">Rau củ</span>
            <h5><a href="#" class="product-title">Cà chua cherry</a></h5>
            <div class="product-price">
                <span class="new-price">18.000đ/kg</span>
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

<!-- Product 8 -->
<div class="col-md-4">
    <div class="product-card">
        <div class="product-badge bg-info">Mới</div>
        <div class="product-thumb">
            <img src="../../image/caicauvong.jpg" class="img-fluid" alt="Cải cầu vồng">
            <div class="product-action">
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-heart"></i></a>
                <a href="#" class="btn btn-success btn-sm"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
        <div class="product-info p-3">
            <span class="product-category">Rau củ</span>
            <h5><a href="#" class="product-title">Cải cầu vồng</a></h5>
            <div class="product-price">
                <span class="new-price">30.000đ/kg</span>
            </div>
            <div class="product-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <span>(4.0)</span>
            </div>
        </div>
    </div>
</div>

<!-- Product 9 -->
<div class="col-md-4">
    <div class="product-card">
        <div class="product-thumb">
            <img src="../../image/caikale.jpeg" class="img-fluid" alt="Cải Kale">
            <div class="product-action">
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>
                <a href="#" class="btn btn-light btn-sm"><i class="fas fa-heart"></i></a>
                <a href="#" class="btn btn-success btn-sm"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
        <div class="product-info p-3">
            <span class="product-category">Rau củ</span>
            <h5><a href="#" class="product-title">Cải Kale</a></h5>
            <div class="product-price">
                <span class="new-price">30.000đ/kg</span>
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


                    <!-- Pagination -->
                    <div class="pagination-container mt-5 text-center">
                        <button class="btn btn-outline-primary" id="loadMoreBtn">
                            Xem thêm</button>
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
</body>
</html>
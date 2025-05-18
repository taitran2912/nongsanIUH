<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModalLabel">Chi tiết sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div id="productImageCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://via.placeholder.com/400" class="d-block w-100 rounded" alt="Product Image">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://via.placeholder.com/400" class="d-block w-100 rounded" alt="Product Image">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://via.placeholder.com/400" class="d-block w-100 rounded" alt="Product Image">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <div class="d-flex mt-2">
                            <div class="me-2">
                                <img src="https://via.placeholder.com/80" class="img-thumbnail" alt="Thumbnail">
                            </div>
                            <div class="me-2">
                                <img src="https://via.placeholder.com/80" class="img-thumbnail" alt="Thumbnail">
                            </div>
                            <div>
                                <img src="https://via.placeholder.com/80" class="img-thumbnail" alt="Thumbnail">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h4 id="viewProductName">Rau cải ngọt hữu cơ</h4>
                        <div class="mb-3">
                            <span class="badge bg-success me-2">Đang bán</span>
                            <span class="badge bg-danger">Sắp hết hàng</span>
                        </div>
                        <div class="mb-3">
                            <h5 class="text-success">25,000 đ</h5>
                        </div>
                        <div class="mb-3">
                            <p><strong>Danh mục:</strong> <span id="viewProductCategory">Rau củ</span></p>
                            <p><strong>Tồn kho:</strong> <span id="viewProductStock">5 kg</span></p>
                            <p><strong>Đã bán:</strong> <span id="viewProductSold">120 kg</span></p>
                            <p><strong>Đơn vị:</strong> <span id="viewProductUnit">kg</span></p>
                            <p><strong>Ngày tạo:</strong> <span id="viewProductCreated">01/05/2023</span></p>
                            <p><strong>Cập nhật lần cuối:</strong> <span id="viewProductUpdated">15/05/2023</span></p>
                        </div>
                        <div class="mb-3">
                            <h6>Mô tả sản phẩm:</h6>
                            <p id="viewProductDescription">Rau cải ngọt hữu cơ được trồng theo tiêu chuẩn hữu cơ quốc tế, không sử dụng thuốc trừ sâu và phân bón hóa học. Rau tươi ngon, giàu vitamin và khoáng chất, an toàn cho sức khỏe người tiêu dùng.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="1">Chỉnh sửa</button>
            </div>
        </div>
    </div>
</div>
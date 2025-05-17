<div class="product-management">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Quản lý sản phẩm</h2>
        <div>
            <button class="btn btn-outline-success me-2" id="exportProductsBtn">
                <i class="fas fa-file-export me-2"></i>Xuất Excel
            </button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fas fa-plus me-2"></i>Thêm sản phẩm
            </button>
        </div>
    </div>

    <!-- Product Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form id="productFilterForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-0 bg-light" id="searchProduct" placeholder="Tìm kiếm sản phẩm...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="categoryFilter">
                            <option value="">Tất cả danh mục</option>
                            <option value="vegetables">Rau củ</option>
                            <option value="fruits">Trái cây</option>
                            <option value="rice">Gạo & Ngũ cốc</option>
                            <option value="processed">Thực phẩm chế biến</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="statusFilter">
                            <option value="">Tất cả trạng thái</option>
                            <option value="active">Đang bán</option>
                            <option value="low-stock">Sắp hết hàng</option>
                            <option value="out-of-stock">Hết hàng</option>
                            <option value="draft">Bản nháp</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="sortFilter">
                            <option value="newest">Mới nhất</option>
                            <option value="oldest">Cũ nhất</option>
                            <option value="price-asc">Giá tăng dần</option>
                            <option value="price-desc">Giá giảm dần</option>
                            <option value="name-asc">Tên A-Z</option>
                            <option value="name-desc">Tên Z-A</option>
                            <option value="stock-asc">Tồn kho thấp nhất</option>
                            <option value="stock-desc">Tồn kho cao nhất</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="productsTable">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAllProducts">
                                </div>
                            </th>
                            <th>Sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Đã bán</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sản phẩm 1 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input product-checkbox" type="checkbox" value="1">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Product">
                                    <div>Rau cải ngọt hữu cơ</div>
                                </div>
                            </td>
                            <td>Rau củ</td>
                            <td>25,000 đ</td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-danger" style="width: 10%"></div>
                                </div>
                                <small class="text-muted">5 kg</small>
                            </td>
                            <td>120 kg</td>
                            <td><span class="badge bg-danger">Sắp hết</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewProductModal" data-product-id="1"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="1"><i class="fas fa-edit me-2"></i>Chỉnh sửa</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#restockModal" onclick="document.getElementById('productId').value='1'"><i class="fas fa-plus-circle me-2"></i>Nhập thêm</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-product-id="1"><i class="fas fa-trash-alt me-2"></i>Xóa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Sản phẩm 2 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input product-checkbox" type="checkbox" value="2">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Product">
                                    <div>Cà chua hữu cơ</div>
                                </div>
                            </td>
                            <td>Rau củ</td>
                            <td>30,000 đ</td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-warning" style="width: 20%"></div>
                                </div>
                                <small class="text-muted">8 kg</small>
                            </td>
                            <td>95 kg</td>
                            <td><span class="badge bg-warning text-dark">Sắp hết</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewProductModal" data-product-id="2"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="2"><i class="fas fa-edit me-2"></i>Chỉnh sửa</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#restockModal" onclick="document.getElementById('productId').value='2'"><i class="fas fa-plus-circle me-2"></i>Nhập thêm</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-product-id="2"><i class="fas fa-trash-alt me-2"></i>Xóa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Sản phẩm 3 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input product-checkbox" type="checkbox" value="3">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Product">
                                    <div>Táo hữu cơ</div>
                                </div>
                            </td>
                            <td>Trái cây</td>
                            <td>45,000 đ</td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: 60%"></div>
                                </div>
                                <small class="text-muted">25 kg</small>
                            </td>
                            <td>78 kg</td>
                            <td><span class="badge bg-success">Còn hàng</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewProductModal" data-product-id="3"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="3"><i class="fas fa-edit me-2"></i>Chỉnh sửa</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#restockModal" onclick="document.getElementById('productId').value='3'"><i class="fas fa-plus-circle me-2"></i>Nhập thêm</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-product-id="3"><i class="fas fa-trash-alt me-2"></i>Xóa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Sản phẩm 4 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input product-checkbox" type="checkbox" value="4">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Product">
                                    <div>Gạo lứt hữu cơ</div>
                                </div>
                            </td>
                            <td>Gạo & Ngũ cốc</td>
                            <td>60,000 đ</td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-warning" style="width: 25%"></div>
                                </div>
                                <small class="text-muted">12 kg</small>
                            </td>
                            <td>150 kg</td>
                            <td><span class="badge bg-warning text-dark">Sắp hết</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewProductModal" data-product-id="4"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="4"><i class="fas fa-edit me-2"></i>Chỉnh sửa</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#restockModal" onclick="document.getElementById('productId').value='4'"><i class="fas fa-plus-circle me-2"></i>Nhập thêm</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-product-id="4"><i class="fas fa-trash-alt me-2"></i>Xóa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Sản phẩm 5 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input product-checkbox" type="checkbox" value="5">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Product">
                                    <div>Dưa hấu không hạt</div>
                                </div>
                            </td>
                            <td>Trái cây</td>
                            <td>35,000 đ</td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: 70%"></div>
                                </div>
                                <small class="text-muted">30 kg</small>
                            </td>
                            <td>85 kg</td>
                            <td><span class="badge bg-success">Còn hàng</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewProductModal" data-product-id="5"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="5"><i class="fas fa-edit me-2"></i>Chỉnh sửa</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#restockModal" onclick="document.getElementById('productId').value='5'"><i class="fas fa-plus-circle me-2"></i>Nhập thêm</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-product-id="5"><i class="fas fa-trash-alt me-2"></i>Xóa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Sản phẩm 6 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input product-checkbox" type="checkbox" value="6">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Product">
                                    <div>Mật ong rừng nguyên chất</div>
                                </div>
                            </td>
                            <td>Thực phẩm chế biến</td>
                            <td>120,000 đ</td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: 50%"></div>
                                </div>
                                <small class="text-muted">15 chai</small>
                            </td>
                            <td>42 chai</td>
                            <td><span class="badge bg-success">Còn hàng</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewProductModal" data-product-id="6"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="6"><i class="fas fa-edit me-2"></i>Chỉnh sửa</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#restockModal" onclick="document.getElementById('productId').value='6'"><i class="fas fa-plus-circle me-2"></i>Nhập thêm</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-product-id="6"><i class="fas fa-trash-alt me-2"></i>Xóa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Sản phẩm 7 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input product-checkbox" type="checkbox" value="7">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Product">
                                    <div>Bắp cải tím</div>
                                </div>
                            </td>
                            <td>Rau củ</td>
                            <td>28,000 đ</td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-secondary" style="width: 0%"></div>
                                </div>
                                <small class="text-muted">0 kg</small>
                            </td>
                            <td>65 kg</td>
                            <td><span class="badge bg-secondary">Hết hàng</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewProductModal" data-product-id="7"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="7"><i class="fas fa-edit me-2"></i>Chỉnh sửa</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#restockModal" onclick="document.getElementById('productId').value='7'"><i class="fas fa-plus-circle me-2"></i>Nhập thêm</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-product-id="7"><i class="fas fa-trash-alt me-2"></i>Xóa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="bulk-actions d-flex align-items-center">
                    <select class="form-select form-select-sm me-2" id="bulkActionSelect" style="width: auto;">
                        <option value="">Thao tác hàng loạt</option>
                        <option value="active">Đánh dấu đang bán</option>
                        <option value="out-of-stock">Đánh dấu hết hàng</option>
                        <option value="draft">Đánh dấu bản nháp</option>
                        <option value="delete">Xóa sản phẩm</option>
                    </select>
                    <button class="btn btn-sm btn-outline-secondary" id="applyBulkAction" disabled>Áp dụng</button>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-3">Hiển thị 1-7 của 65 sản phẩm</div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Thêm sản phẩm Modal -->
<?php include_once 'includes/modals/add-product-modal.php'; ?>

<!-- Xem chi tiết sản phẩm Modal -->
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

<!-- Chỉnh sửa sản phẩm Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Chỉnh sửa sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" method="POST" action="process/edit-product.php" enctype="multipart/form-data">
                    <input type="hidden" id="editProductId" name="product_id" value="1">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editProductName" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="editProductName" name="product_name" value="Rau cải ngọt hữu cơ" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editProductCategory" class="form-label">Danh mục</label>
                            <select class="form-select" id="editProductCategory" name="product_category" required>
                                <option value="">Chọn danh mục</option>
                                <option value="vegetables" selected>Rau củ</option>
                                <option value="fruits">Trái cây</option>
                                <option value="rice">Gạo & Ngũ cốc</option>
                                <option value="processed">Thực phẩm chế biến</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editProductPrice" class="form-label">Giá (đ)</label>
                            <input type="number" class="form-control" id="editProductPrice" name="product_price" value="25000" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editProductStock" class="form-label">Số lượng</label>
                            <input type="number" class="form-control" id="editProductStock" name="product_stock" value="5" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editProductDescription" class="form-label">Mô tả sản phẩm</label>
                        <textarea class="form-control" id="editProductDescription" name="product_description" rows="4">Rau cải ngọt hữu cơ được trồng theo tiêu chuẩn hữu cơ quốc tế, không sử dụng thuốc trừ sâu và phân bón hóa học. Rau tươi ngon, giàu vitamin và khoáng chất, an toàn cho sức khỏe người tiêu dùng.</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh hiện tại</label>
                        <div class="d-flex mb-2">
                            <div class="position-relative me-2">
                                <img src="https://via.placeholder.com/100" class="img-thumbnail" alt="Product Image">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" style="padding: 0 5px;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="position-relative me-2">
                                <img src="https://via.placeholder.com/100" class="img-thumbnail" alt="Product Image">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" style="padding: 0 5px;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="position-relative">
                                <img src="https://via.placeholder.com/100" class="img-thumbnail" alt="Product Image">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" style="padding: 0 5px;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <label for="editProductImage" class="form-label">Thêm hình ảnh mới</label>
                        <input type="file" class="form-control" id="editProductImage" name="product_image[]" multiple>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editProductUnit" class="form-label">Đơn vị</label>
                            <select class="form-select" id="editProductUnit" name="product_unit">
                                <option value="kg" selected>Kilogram (kg)</option>
                                <option value="g">Gram (g)</option>
                                <option value="piece">Cái</option>
                                <option value="pack">Gói</option>
                                <option value="bottle">Chai</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="editProductStatus" class="form-label">Trạng thái</label>
                            <select class="form-select" id="editProductStatus" name="product_status">
                                <option value="active" selected>Đang bán</option>
                                <option value="draft">Bản nháp</option>
                                <option value="out-of-stock">Hết hàng</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="editProductForm" class="btn btn-success">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>

<!-- Xóa sản phẩm Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">Xác nhận xóa sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa sản phẩm <strong id="deleteProductName">Rau cải ngọt hữu cơ</strong>?</p>
                <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác.</p>
                <form id="deleteProductForm" method="POST" action="process/delete-product.php">
                    <input type="hidden" id="deleteProductId" name="product_id" value="1">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="deleteProductForm" class="btn btn-danger">Xóa sản phẩm</button>
            </div>
        </div>
    </div>
</div>

<!-- Nhập thêm sản phẩm Modal -->
<div class="modal fade" id="restockModal" tabindex="-1" aria-labelledby="restockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restockModalLabel">Nhập thêm sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="restockForm" method="POST" action="process/restock-product.php">
                    <input type="hidden" id="productId" name="product_id" value="">
                    <input type="hidden" id="productUnit" name="product_unit" value="kg">
                    
                    <div class="mb-3">
                        <label for="restockQuantity" class="form-label">Số lượng nhập thêm</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-secondary" id="decreaseQuantity" onclick="decreaseValue()">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="form-control text-center" id="restockQuantity" name="restock_quantity" value="1" min="1">
                            <span class="input-group-text">kg</span>
                            <button type="button" class="btn btn-outline-secondary" id="increaseQuantity" onclick="increaseValue()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="restockForm" class="btn btn-success">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<!-- Xác nhận xóa hàng loạt Modal -->
<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkDeleteModalLabel">Xác nhận xóa sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa <strong id="bulkDeleteCount">0</strong> sản phẩm đã chọn?</p>
                <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác.</p>
                <form id="bulkDeleteForm" method="POST" action="process/bulk-delete-products.php">
                    <input type="hidden" id="bulkDeleteIds" name="product_ids" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="bulkDeleteForm" class="btn btn-danger">Xóa sản phẩm</button>
            </div>
        </div>
    </div>
</div>
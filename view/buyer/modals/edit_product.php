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

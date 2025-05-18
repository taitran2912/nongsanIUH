<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Chỉnh sửa sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" method="POST" action="?action=product" enctype="multipart/form-data">
                    <input type="hidden" id="editProductId" name="product_id">
                    <input type="hidden" name="action_type" value="update">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editProductName" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="editProductName" name="product_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editProductCategory" class="form-label">Danh mục</label>
                            <select class="form-select" id="editProductCategory" name="product_category" required>
                                <option value="">Chọn danh mục</option>
                                <!-- Danh mục sẽ được tải bằng JavaScript -->
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editProductPrice" class="form-label">Giá (đ)</label>
                            <input type="number" class="form-control" id="editProductPrice" name="product_price" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editProductStock" class="form-label">Số lượng</label>
                            <input type="number" class="form-control" id="editProductStock" name="product_stock" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editProductDescription" class="form-label">Mô tả sản phẩm</label>
                        <textarea class="form-control" id="editProductDescription" name="product_description" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh hiện tại</label>
                        <div class="d-flex mb-2" id="currentProductImages">
                            <!-- Hình ảnh hiện tại sẽ được tải bằng JavaScript -->
                        </div>
                        <label for="editProductImage" class="form-label">Thêm hình ảnh mới</label>
                        <input type="file" class="form-control" id="editProductImage" name="product_image[]" multiple>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editProductUnit" class="form-label">Đơn vị</label>
                            <select class="form-select" id="editProductUnit" name="product_unit">
                                <option value="kg">Kilogram (kg)</option>
                                <option value="g">Gram (g)</option>
                                <option value="piece">Cái</option>
                                <option value="pack">Gói</option>
                                <option value="bottle">Chai</option>
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
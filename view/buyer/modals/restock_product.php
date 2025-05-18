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
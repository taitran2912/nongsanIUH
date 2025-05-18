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
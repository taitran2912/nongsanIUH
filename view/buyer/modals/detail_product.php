<!-- Modal Chi tiết sản phẩm -->
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewProductModalLabel">Chi tiết sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>

      <div class="modal-body">
        <h4 id="productName" class="mb-3"></h4>
        <p><strong>Mô tả:</strong> <span id="productDescription"></span></p>
        <p><strong>Giá:</strong> <span id="productPrice"></span> đ</p>
        <p><strong>Số lượng còn:</strong> <span id="productQuantity"></span></p>
        <p><strong>Đơn vị:</strong> <span id="productUnit"></span></p>
        <p><strong>Ngày tạo:</strong> <span id="productCreatedAt"></span></p>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>


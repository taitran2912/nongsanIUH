<div class="order-management">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Quản lý đơn hàng</h2>
        <div>
            <button class="btn btn-outline-success me-2" id="exportOrdersBtn">
                <i class="fas fa-file-export me-2"></i>Xuất Excel
            </button>
            <button class="btn btn-success" id="printOrdersBtn">
                <i class="fas fa-print me-2"></i>In đơn hàng
            </button>
        </div>
    </div>

    <!-- Order Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form id="orderFilterForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-0 bg-light" id="searchOrder" placeholder="Tìm kiếm đơn hàng...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="statusFilter">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending">Chờ xác nhận</option>
                            <option value="processing">Đang xử lý</option>
                            <option value="shipping">Đang giao hàng</option>
                            <option value="completed">Đã hoàn thành</option>
                            <option value="cancelled">Đã hủy</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="paymentFilter">
                            <option value="">Tất cả phương thức</option>
                            <option value="cod">Thanh toán khi nhận hàng</option>
                            <option value="bank">Chuyển khoản ngân hàng</option>
                            <option value="momo">Ví MoMo</option>
                            <option value="zalopay">ZaloPay</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="dateFilter">
                            <option value="all">Tất cả thời gian</option>
                            <option value="today">Hôm nay</option>
                            <option value="yesterday">Hôm qua</option>
                            <option value="week">7 ngày qua</option>
                            <option value="month">30 ngày qua</option>
                            <option value="custom">Tùy chỉnh...</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3 date-range-container" style="display: none;">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light">Từ ngày</span>
                            <input type="date" class="form-control" id="dateFrom">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light">Đến ngày</span>
                            <input type="date" class="form-control" id="dateTo">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="ordersTable">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAllOrders">
                                </div>
                            </th>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Đơn hàng 1 -->
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input order-checkbox" type="checkbox" value="ORD001">
                                </div>
                            </td>
                            <td><a href="#" class="fw-medium text-decoration-none" data-bs-toggle="modal" data-bs-target="#viewOrderModal" data-order-id="ORD001">#ORD001</a></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2 bg-success-light rounded-circle text-center">
                                        <span class="avatar-text">NT</span>
                                    </div>
                                    <div>
                                        <div class="fw-medium">Nguyễn Văn Tuấn</div>
                                        <div class="small text-muted">0912345678</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>15/05/2023</div>
                                <div class="small text-muted">10:30 AM</div>
                            </td>
                            <td>
                                <div class="fw-medium">320,000 đ</div>
                                <div class="small text-muted">5 sản phẩm</div>
                            </td>
                            <td><span class="badge bg-warning text-dark">COD</span></td>
                            <td><span class="badge bg-info">Đang giao hàng</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewOrderModal" data-order-id="ORD001"><i class="fas fa-eye me-2"></i>Xem chi tiết</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateStatusModal" data-order-id="ORD001"><i class="fas fa-edit me-2"></i>Cập nhật trạng thái</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#printInvoiceModal" data-order-id="ORD001"><i class="fas fa-print me-2"></i>In hóa đơn</a></li>
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
                
                <div class="d-flex align-items-center">
                    <div class="me-3">Hiển thị 1-7 của 42 đơn hàng</div>
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
<!-- Xem chi tiết đơn hàng Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewOrderModalLabel">Chi tiết đơn hàng #ORD001</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-uppercase text-muted mb-3">Thông tin đơn hàng</h6>
                        <p class="mb-1"><strong>Mã đơn hàng:</strong> <span id="orderIdDetail">#ORD001</span></p>
                        <p class="mb-1"><strong>Ngày đặt hàng:</strong> <span id="orderDateDetail">15/05/2023 10:30 AM</span></p>
                        <p class="mb-1"><strong>Phương thức thanh toán:</strong> <span id="orderPaymentDetail">Thanh toán khi nhận hàng (COD)</span></p>
                        <p class="mb-1"><strong>Trạng thái đơn hàng:</strong> <span class="badge bg-info" id="orderStatusDetail">Đang giao hàng</span></p>
                        <p class="mb-1"><strong>Ghi chú:</strong> <span id="orderNoteDetail">Giao hàng trong giờ hành chính</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-uppercase text-muted mb-3">Thông tin khách hàng</h6>
                        <p class="mb-1"><strong>Tên khách hàng:</strong> <span id="customerNameDetail">Nguyễn Văn Tuấn</span></p>
                        <p class="mb-1"><strong>Số điện thoại:</strong> <span id="customerPhoneDetail">0912345678</span></p>
                        <p class="mb-1"><strong>Email:</strong> <span id="customerEmailDetail">nguyenvantuan@example.com</span></p>
                        <p class="mb-1"><strong>Địa chỉ giao hàng:</strong> <span id="customerAddressDetail">123 Đường Lê Lợi, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh</span></p>
                    </div>
                </div>
                
                <h6 class="text-uppercase text-muted mb-3">Sản phẩm đã đặt</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-center">Đơn giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody id="orderItemsDetail">
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40" class="rounded me-2" alt="Product">
                                        <div>Rau cải ngọt hữu cơ</div>
                                    </div>
                                </td>
                                <td class="text-center">25,000 đ</td>
                                <td class="text-center">2 kg</td>
                                <td class="text-end">50,000 đ</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40" class="rounded me-2" alt="Product">
                                        <div>Cà chua hữu cơ</div>
                                    </div>
                                </td>
                                <td class="text-center">30,000 đ</td>
                                <td class="text-center">1 kg</td>
                                <td class="text-end">30,000 đ</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40" class="rounded me-2" alt="Product">
                                        <div>Táo hữu cơ</div>
                                    </div>
                                </td>
                                <td class="text-center">45,000 đ</td>
                                <td class="text-center">2 kg</td>
                                <td class="text-end">90,000 đ</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40" class="rounded me-2" alt="Product">
                                        <div>Gạo lứt hữu cơ</div>
                                    </div>
                                </td>
                                <td class="text-center">60,000 đ</td>
                                <td class="text-center">2 kg</td>
                                <td class="text-end">120,000 đ</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40" class="rounded me-2" alt="Product">
                                        <div>Dưa hấu không hạt</div>
                                    </div>
                                </td>
                                <td class="text-center">30,000 đ</td>
                                <td class="text-center">1 kg</td>
                                <td class="text-end">30,000 đ</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Tổng tiền hàng:</strong></td>
                                <td class="text-end" id="orderSubtotalDetail">320,000 đ</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                <td class="text-end" id="orderShippingDetail">30,000 đ</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Giảm giá:</strong></td>
                                <td class="text-end" id="orderDiscountDetail">-30,000 đ</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Tổng thanh toán:</strong></td>
                                <td class="text-end fw-bold" id="orderTotalDetail">320,000 đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <h6 class="text-uppercase text-muted mb-3">Lịch sử đơn hàng</h6>
                <div class="timeline mb-0">
                    <div class="timeline-item">
                        <div class="timeline-item-marker">
                            <div class="timeline-item-marker-indicator bg-success"></div>
                        </div>
                        <div class="timeline-item-content">
                            <span class="text-success fw-bold">Đơn hàng đã được tạo</span>
                            <p class="mb-0 text-muted small">15/05/2023 10:30 AM - Hệ thống</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-item-marker">
                            <div class="timeline-item-marker-indicator bg-primary"></div>
                        </div>
                        <div class="timeline-item-content">
                            <span class="text-primary fw-bold">Đơn hàng đã được xác nhận</span>
                            <p class="mb-0 text-muted small">15/05/2023 11:15 AM - Nhân viên: Trần Thị Hương</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-item-marker">
                            <div class="timeline-item-marker-indicator bg-warning"></div>
                        </div>
                        <div class="timeline-item-content">
                            <span class="text-warning fw-bold">Đơn hàng đang được xử lý</span>
                            <p class="mb-0 text-muted small">15/05/2023 13:45 PM - Nhân viên: Lê Văn Hòa</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-item-marker">
                            <div class="timeline-item-marker-indicator bg-info"></div>
                        </div>
                        <div class="timeline-item-content">
                            <span class="text-info fw-bold">Đơn hàng đang được giao</span>
                            <p class="mb-0 text-muted small">15/05/2023 15:30 PM - Đơn vị vận chuyển: Giao Hàng Nhanh</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal" data-order-id="ORD001">Cập nhật trạng thái</button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#printInvoiceModal" data-order-id="ORD001">In hóa đơn</button>
            </div>
        </div>
    </div>
</div>

<!-- Cập nhật trạng thái đơn hàng Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Cập nhật trạng thái đơn hàng #ORD001</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateStatusForm" method="POST" action="process/update-order-status.php">
                    <input type="hidden" id="updateOrderId" name="order_id" value="ORD001">
                    
                    <div class="mb-3">
                        <label for="orderStatus" class="form-label">Trạng thái đơn hàng</label>
                        <select class="form-select" id="orderStatus" name="order_status" required>
                            <option value="">Chọn trạng thái</option>
                            <option value="pending">Chờ xác nhận</option>
                            <option value="processing">Đang xử lý</option>
                            <option value="shipping" selected>Đang giao hàng</option>
                            <option value="completed">Đã hoàn thành</option>
                            <option value="cancelled">Đã hủy</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="statusNote" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="statusNote" name="status_note" rows="3" placeholder="Nhập ghi chú về việc thay đổi trạng thái (nếu có)"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notifyCustomer" class="form-check-label">
                            <input type="checkbox" class="form-check-input" id="notifyCustomer" name="notify_customer" checked>
                            Thông báo cho khách hàng về việc thay đổi trạng thái
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="updateStatusForm" class="btn btn-success">Cập nhật</button>
            </div>
        </div>
    </div>
</div>

<!-- In hóa đơn Modal -->
<div class="modal fade" id="printInvoiceModal" tabindex="-1" aria-labelledby="printInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printInvoiceModalLabel">In hóa đơn #ORD001</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="invoice-container p-4" id="invoicePrint">
                    <div class="row mb-4">
                        <div class="col-6">
                            <h4 class="text-uppercase">Hóa đơn</h4>
                            <p class="text-muted mb-1">Mã đơn hàng: <strong>#ORD001</strong></p>
                            <p class="text-muted mb-1">Ngày: <strong>15/05/2023</strong></p>
                        </div>
                        <div class="col-6 text-end">
                            <h4 class="text-uppercase">Nông Sản Sạch</h4>
                            <p class="text-muted mb-1">123 Đường Nguyễn Huệ</p>
                            <p class="text-muted mb-1">Quận 1, TP. Hồ Chí Minh</p>
                            <p class="text-muted mb-1">Email: contact@nongsansach.com</p>
                            <p class="text-muted mb-1">Điện thoại: 028 1234 5678</p>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-6">
                            <h6 class="text-uppercase text-muted">Thông tin khách hàng</h6>
                            <p class="mb-1"><strong>Nguyễn Văn Tuấn</strong></p>
                            <p class="mb-1">123 Đường Lê Lợi, Phường Bến Nghé</p>
                            <p class="mb-1">Quận 1, TP. Hồ Chí Minh</p>
                            <p class="mb-1">Điện thoại: 0912345678</p>
                            <p class="mb-1">Email: nguyenvantuan@example.com</p>
                        </div>
                        <div class="col-6 text-end">
                            <h6 class="text-uppercase text-muted">Thông tin thanh toán</h6>
                            <p class="mb-1"><strong>Phương thức thanh toán:</strong> Thanh toán khi nhận hàng (COD)</p>
                            <p class="mb-1"><strong>Trạng thái thanh toán:</strong> Chưa thanh toán</p>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Đơn giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Rau cải ngọt hữu cơ</td>
                                    <td class="text-center">25,000 đ</td>
                                    <td class="text-center">2 kg</td>
                                    <td class="text-end">50,000 đ</td>
                                </tr>
                                <tr>
                                    <td>Cà chua hữu cơ</td>
                                    <td class="text-center">30,000 đ</td>
                                    <td class="text-center">1 kg</td>
                                    <td class="text-end">30,000 đ</td>
                                </tr>
                                <tr>
                                    <td>Táo hữu cơ</td>
                                    <td class="text-center">45,000 đ</td>
                                    <td class="text-center">2 kg</td>
                                    <td class="text-end">90,000 đ</td>
                                </tr>
                                <tr>
                                    <td>Gạo lứt hữu cơ</td>
                                    <td class="text-center">60,000 đ</td>
                                    <td class="text-center">2 kg</td>
                                    <td class="text-end">120,000 đ</td>
                                </tr>
                                <tr>
                                    <td>Dưa hấu không hạt</td>
                                    <td class="text-center">30,000 đ</td>
                                    <td class="text-center">1 kg</td>
                                    <td class="text-end">30,000 đ</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Tổng tiền hàng:</strong></td>
                                    <td class="text-end">320,000 đ</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                    <td class="text-end">30,000 đ</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Giảm giá:</strong></td>
                                    <td class="text-end">-30,000 đ</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Tổng thanh toán:</strong></td>
                                    <td class="text-end fw-bold">320,000 đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <p class="text-muted mb-1"><strong>Ghi chú:</strong> Giao hàng trong giờ hành chính</p>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-6">
                            <p class="mb-1">Người nhận hàng</p>
                            <p class="text-muted">(Ký, ghi rõ họ tên)</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-1">Người bán hàng</p>
                            <p class="text-muted">(Ký, ghi rõ họ tên)</p>
                        </div>
                    </div>
                    
                    <div class="row mt-5">
                        <div class="col-12 text-center">
                            <p class="mb-0">Cảm ơn quý khách đã mua hàng tại Nông Sản Sạch!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="printInvoiceBtn">In hóa đơn</button>
            </div>
        </div>
    </div>
</div>
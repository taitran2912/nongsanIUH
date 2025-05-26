<?php
// statis.php - Statistics dashboard for buyers (Updated UI)

// Kiểm tra đăng nhập và quyền truy cập
if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href = '../customer/index.php';</script>";
    exit;
}

// Kết nối database
include_once '../../model/connect.php';
$db = new clsketnoi();
$conn = $db->moKetNoi();
$conn->set_charset('utf8');

// Lấy thông tin farm của user hiện tại
$farmId = $storeId; // Từ index.php

// Xử lý filter ngày tháng
$dateFrom = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-01'); // Đầu tháng hiện tại
$dateTo = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d'); // Hôm nay
$period = isset($_GET['period']) ? $_GET['period'] : 'month';

// Validate dates
if (!$dateFrom) $dateFrom = date('Y-m-01');
if (!$dateTo) $dateTo = date('Y-m-d');

// Tính toán kỳ trước để so sánh
$fromDate = new DateTime($dateFrom);
$toDate = new DateTime($dateTo);
$interval = $fromDate->diff($toDate);
$daysDiff = $interval->days + 1;

$prevFromDate = clone $fromDate;
$prevFromDate->sub(new DateInterval("P{$daysDiff}D"));
$prevToDate = clone $toDate;
$prevToDate->sub(new DateInterval("P{$daysDiff}D"));

$prevDateFrom = $prevFromDate->format('Y-m-d');
$prevDateTo = $prevToDate->format('Y-m-d');

// 1. TỔNG DOANH THU
$revenueSql = "SELECT 
    COALESCE(SUM(o.total_amount), 0) as current_revenue,
    COUNT(o.id) as current_orders
    FROM orders o 
    JOIN order_details od ON o.id = od.order_id 
    JOIN products p ON od.product_id = p.id 
    WHERE p.farm_id = ? 
    AND o.status = '1' 
    AND DATE(o.order_date) BETWEEN ? AND ?";

$revenueStmt = $conn->prepare($revenueSql);
$revenueStmt->bind_param("iss", $farmId, $dateFrom, $dateTo);
$revenueStmt->execute();
$revenueResult = $revenueStmt->get_result()->fetch_assoc();

// Doanh thu kỳ trước
$prevRevenueStmt = $conn->prepare($revenueSql);
$prevRevenueStmt->bind_param("iss", $farmId, $prevDateFrom, $prevDateTo);
$prevRevenueStmt->execute();
$prevRevenueResult = $prevRevenueStmt->get_result()->fetch_assoc();

$currentRevenue = $revenueResult['current_revenue'];
$currentOrders = $revenueResult['current_orders'];
$prevRevenue = $prevRevenueResult['current_revenue'];
$prevOrders = $prevRevenueResult['current_orders'];

// Tính phần trăm thay đổi
$revenueChange = $prevRevenue > 0 ? (($currentRevenue - $prevRevenue) / $prevRevenue) * 100 : 0;
$ordersChange = $prevOrders > 0 ? (($currentOrders - $prevOrders) / $prevOrders) * 100 : 0;

// 2. SỐ LƯỢNG SẢN PHẨM ĐÃ BÁN
$soldItemsSql = "SELECT 
    COALESCE(SUM(od.quantity), 0) as current_sold
    FROM orders o 
    JOIN order_details od ON o.id = od.order_id 
    JOIN products p ON od.product_id = p.id 
    WHERE p.farm_id = ? 
    AND o.status = '1' 
    AND DATE(o.order_date) BETWEEN ? AND ?";

$soldItemsStmt = $conn->prepare($soldItemsSql);
$soldItemsStmt->bind_param("iss", $farmId, $dateFrom, $dateTo);
$soldItemsStmt->execute();
$soldItemsResult = $soldItemsStmt->get_result()->fetch_assoc();

$prevSoldItemsStmt = $conn->prepare($soldItemsSql);
$prevSoldItemsStmt->bind_param("iss", $farmId, $prevDateFrom, $prevDateTo);
$prevSoldItemsStmt->execute();
$prevSoldItemsResult = $prevSoldItemsStmt->get_result()->fetch_assoc();

$currentSoldItems = $soldItemsResult['current_sold'];
$prevSoldItems = $prevSoldItemsResult['current_sold'];
$soldItemsChange = $prevSoldItems > 0 ? (($currentSoldItems - $prevSoldItems) / $prevSoldItems) * 100 : 0;

// 3. KHÁCH HÀNG MỚI
$newCustomersSql = "SELECT COUNT(DISTINCT o.user_id) as new_customers
    FROM orders o 
    JOIN order_details od ON o.id = od.order_id 
    JOIN products p ON od.product_id = p.id 
    WHERE p.farm_id = ? 
    AND o.status = '1' 
    AND DATE(o.order_date) BETWEEN ? AND ?
    AND o.user_id NOT IN (
        SELECT DISTINCT o2.user_id 
        FROM orders o2 
        JOIN order_details od2 ON o2.id = od2.order_id 
        JOIN products p2 ON od2.product_id = p2.id 
        WHERE p2.farm_id = ? 
        AND o2.status = '1' 
        AND DATE(o2.order_date) < ?
    )";

$newCustomersStmt = $conn->prepare($newCustomersSql);
$newCustomersStmt->bind_param("issis", $farmId, $dateFrom, $dateTo, $farmId, $dateFrom);
$newCustomersStmt->execute();
$newCustomersResult = $newCustomersStmt->get_result()->fetch_assoc();

$prevNewCustomersStmt = $conn->prepare($newCustomersSql);
$prevNewCustomersStmt->bind_param("issis", $farmId, $prevDateFrom, $prevDateTo, $farmId, $prevDateFrom);
$prevNewCustomersStmt->execute();
$prevNewCustomersResult = $prevNewCustomersStmt->get_result()->fetch_assoc();

$currentNewCustomers = $newCustomersResult['new_customers'];
$prevNewCustomers = $prevNewCustomersResult['new_customers'];
$newCustomersChange = $prevNewCustomers > 0 ? (($currentNewCustomers - $prevNewCustomers) / $prevNewCustomers) * 100 : 0;

// 4. DOANH THU THEO NGÀY (cho biểu đồ)
$dailyRevenueSql = "SELECT 
    DATE(o.order_date) as order_date,
    SUM(o.total_amount) as daily_revenue,
    COUNT(o.id) as daily_orders
    FROM orders o
    JOIN order_details od ON o.id = od.order_id
    JOIN products p ON od.product_id = p.id
    WHERE p.farm_id = ? 
    AND o.status = '1'
    AND DATE(o.order_date) BETWEEN ? AND ?
    GROUP BY DATE(o.order_date)
    ORDER BY order_date ASC";

$dailyRevenueStmt = $conn->prepare($dailyRevenueSql);
$dailyRevenueStmt->bind_param("iss", $farmId, $dateFrom, $dateTo);
$dailyRevenueStmt->execute();
$dailyRevenueResult = $dailyRevenueStmt->get_result();

$chartLabels = [];
$chartRevenue = [];
$chartOrders = [];

while ($row = $dailyRevenueResult->fetch_assoc()) {
    $chartLabels[] = date('d/m', strtotime($row['order_date']));
    $chartRevenue[] = $row['daily_revenue'];
    $chartOrders[] = $row['daily_orders'];
}

// 5. ĐƠN HÀNG GẦN ĐÂY
$recentOrdersSql = "SELECT 
    o.id,
    o.order_date,
    o.total_amount,
    o.status,
    o.notes,
    u.name as customer_name
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN order_details od ON o.id = od.order_id
    JOIN products p ON od.product_id = p.id
    WHERE p.farm_id = ? 
    AND DATE(o.order_date) BETWEEN ? AND ?
    GROUP BY o.id, o.order_date, o.total_amount, o.status, o.notes, u.name
    ORDER BY o.order_date DESC
    LIMIT 15";

$recentOrdersStmt = $conn->prepare($recentOrdersSql);
$recentOrdersStmt->bind_param("iss", $farmId, $dateFrom, $dateTo);
$recentOrdersStmt->execute();
$recentOrdersResult = $recentOrdersStmt->get_result();

$db->dongKetNoi($conn);

// Helper functions
function formatCurrency($amount) {
    return number_format($amount, 0, ',', '.') . ' đ';
}

function getChangeClass($change) {
    if ($change > 0) return 'success';
    if ($change < 0) return 'danger';
    return 'secondary';
}

function getChangeIcon($change) {
    if ($change > 0) return 'fa-arrow-up';
    if ($change < 0) return 'fa-arrow-down';
    return 'fa-minus';
}

function getOrderStatusBadge($status) {
    switch ($status) {
        case '0': return '<span class="badge bg-warning text-dark">Chờ thanh toán</span>';
        case '1': return '<span class="badge bg-success">Đã thanh toán</span>';
        default: return '<span class="badge bg-secondary">Khác</span>';
    }
}

function extractOrderCode($notes) {
    if (preg_match('/ORD\d+/', $notes, $matches)) {
        return $matches[0];
    }
    return 'N/A';
}
?>

<div class="statistics-dashboard">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title mb-1">Thống kê & Báo cáo</h2>
                <p class="page-subtitle text-muted mb-0">Theo dõi hiệu suất kinh doanh của bạn</p>
            </div>
            <div class="header-actions">
                <div class="btn-group me-2" role="group">
                    <button type="button" class="btn btn-outline-primary <?php echo $period == 'day' ? 'active' : ''; ?>" onclick="setPeriod('day')">
                        <i class="fas fa-calendar-day me-1"></i>Ngày
                    </button>
                    <button type="button" class="btn btn-outline-primary <?php echo $period == 'week' ? 'active' : ''; ?>" onclick="setPeriod('week')">
                        <i class="fas fa-calendar-week me-1"></i>Tuần
                    </button>
                    <button type="button" class="btn btn-outline-primary <?php echo $period == 'month' ? 'active' : ''; ?>" onclick="setPeriod('month')">
                        <i class="fas fa-calendar-alt me-1"></i>Tháng
                    </button>
                    <button type="button" class="btn btn-outline-primary <?php echo $period == 'year' ? 'active' : ''; ?>" onclick="setPeriod('year')">
                        <i class="fas fa-calendar me-1"></i>Năm
                    </button>
                </div>
                <button class="btn btn-success" onclick="exportStats()">
                    <i class="fas fa-download me-2"></i>Xuất báo cáo
                </button>
            </div>
        </div>
    </div>

    <!-- Date Filter -->
    <div class="filter-card mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-3">
                <form method="GET" class="row align-items-center">
                    <input type="hidden" name="action" value="statis">
                    <input type="hidden" name="period" value="<?php echo $period; ?>">
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <label class="form-label me-3 mb-0 fw-medium">Thời gian:</label>
                            <div class="input-group input-group-sm me-2">
                                <span class="input-group-text border-0 bg-light">
                                    <i class="fas fa-calendar text-muted"></i>
                                </span>
                                <input type="date" class="form-control border-0 bg-light" name="date_from" value="<?php echo $dateFrom; ?>">
                            </div>
                            <span class="mx-2 text-muted">đến</span>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text border-0 bg-light">
                                    <i class="fas fa-calendar text-muted"></i>
                                </span>
                                <input type="date" class="form-control border-0 bg-light" name="date_to" value="<?php echo $dateTo; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-2 mt-md-0">
                        <div class="quick-filters">
                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="setDateRange('today')">Hôm nay</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="setDateRange('7days')">7 ngày</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="setDateRange('30days')">30 ngày</button>
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-search me-1"></i>Áp dụng
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="metrics-grid mb-4">
        <div class="row g-3">
            <div class="col-xl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-icon bg-success">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-label">Tổng doanh thu</div>
                        <div class="metric-value"><?php echo formatCurrency($currentRevenue); ?></div>
                        <div class="metric-change">
                            <span class="badge bg-<?php echo getChangeClass($revenueChange); ?>">
                                <i class="fas <?php echo getChangeIcon($revenueChange); ?> me-1"></i>
                                <?php echo abs(round($revenueChange, 1)); ?>%
                            </span>
                            <span class="text-muted ms-1">so với kỳ trước</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-icon bg-primary">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-label">Tổng đơn hàng</div>
                        <div class="metric-value"><?php echo number_format($currentOrders); ?></div>
                        <div class="metric-change">
                            <span class="badge bg-<?php echo getChangeClass($ordersChange); ?>">
                                <i class="fas <?php echo getChangeIcon($ordersChange); ?> me-1"></i>
                                <?php echo abs(round($ordersChange, 1)); ?>%
                            </span>
                            <span class="text-muted ms-1">so với kỳ trước</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-icon bg-warning">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-label">Sản phẩm đã bán</div>
                        <div class="metric-value"><?php echo number_format($currentSoldItems); ?></div>
                        <div class="metric-change">
                            <span class="badge bg-<?php echo getChangeClass($soldItemsChange); ?>">
                                <i class="fas <?php echo getChangeIcon($soldItemsChange); ?> me-1"></i>
                                <?php echo abs(round($soldItemsChange, 1)); ?>%
                            </span>
                            <span class="text-muted ms-1">so với kỳ trước</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-icon bg-info">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-label">Khách hàng mới</div>
                        <div class="metric-value"><?php echo number_format($currentNewCustomers); ?></div>
                        <div class="metric-change">
                            <span class="badge bg-<?php echo getChangeClass($newCustomersChange); ?>">
                                <i class="fas <?php echo getChangeIcon($newCustomersChange); ?> me-1"></i>
                                <?php echo abs(round($newCustomersChange, 1)); ?>%
                            </span>
                            <span class="text-muted ms-1">so với kỳ trước</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row g-4">
        <!-- Chart Section -->
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">
                        <h5 class="mb-1">Doanh thu theo thời gian</h5>
                        <p class="text-muted mb-0">Biểu đồ doanh thu và đơn hàng</p>
                    </div>
                    <div class="chart-controls">
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary active" onclick="toggleChartView('revenue')">
                                <i class="fas fa-money-bill-wave me-1"></i>Doanh thu
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="toggleChartView('orders')">
                                <i class="fas fa-shopping-cart me-1"></i>Đơn hàng
                            </button>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="downloadChart('sales')">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
                <div class="chart-body">
                    <canvas id="salesChart" height="350"></canvas>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="col-lg-4">
            <div class="orders-card">
                <div class="orders-header">
                    <h5 class="mb-1">Đơn hàng gần đây</h5>
                    <p class="text-muted mb-0">Danh sách đơn hàng mới nhất</p>
                </div>
                <div class="orders-body">
                    <div class="orders-list">
                        <?php if ($recentOrdersResult->num_rows > 0): ?>
                            <?php while ($order = $recentOrdersResult->fetch_assoc()): ?>
                            <div class="order-item">
                                <div class="order-info">
                                    <div class="order-code">
                                        <a href="?action=order&view=<?php echo $order['id']; ?>" class="text-decoration-none fw-medium">
                                            #<?php echo extractOrderCode($order['notes']); ?>
                                        </a>
                                    </div>
                                    <div class="order-customer text-muted"><?php echo htmlspecialchars($order['customer_name']); ?></div>
                                    <div class="order-date text-muted small"><?php echo date('d/m/Y', strtotime($order['order_date'])); ?></div>
                                </div>
                                <div class="order-meta">
                                    <div class="order-amount fw-medium"><?php echo formatCurrency($order['total_amount']); ?></div>
                                    <div class="order-status"><?php echo getOrderStatusBadge($order['status']); ?></div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="no-orders">
                                <div class="text-center py-4">
                                    <i class="fas fa-shopping-cart text-muted mb-2" style="font-size: 2rem;"></i>
                                    <p class="text-muted mb-0">Không có đơn hàng nào</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="orders-footer">
                        <a href="?action=order" class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-eye me-1"></i>Xem tất cả đơn hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Statistics Dashboard Styles */
.statistics-dashboard {
    padding: 0;
}

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    margin: -1.5rem -1.5rem 0 -1.5rem;
    padding: 2rem 1.5rem;
    color: white;
    border-radius: 0 0 1rem 1rem;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 600;
    margin: 0;
}

.page-subtitle {
    opacity: 0.9;
    font-size: 0.95rem;
}

.header-actions .btn {
    border-radius: 0.5rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
}

.header-actions .btn-outline-primary {
    border-color: rgba(255,255,255,0.3);
    color: white;
}

.header-actions .btn-outline-primary:hover,
.header-actions .btn-outline-primary.active {
    background-color: rgba(255,255,255,0.2);
    border-color: rgba(255,255,255,0.5);
    color: white;
}

.header-actions .btn-success {
    background-color: rgba(255,255,255,0.2);
    border-color: rgba(255,255,255,0.3);
    color: white;
}

.filter-card .card {
    border-radius: 1rem;
    background: #f8f9fa;
}

.filter-card .form-label {
    color: #495057;
    font-size: 0.9rem;
}

.filter-card .input-group-text {
    border-radius: 0.5rem 0 0 0.5rem;
}

.filter-card .form-control {
    border-radius: 0 0.5rem 0.5rem 0;
    font-size: 0.9rem;
}

.quick-filters .btn {
    border-radius: 0.5rem;
    font-size: 0.85rem;
}

/* Metrics Grid */
.metrics-grid .metric-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.metrics-grid .metric-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}

.metric-icon {
    width: 60px;
    height: 60px;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.metric-content {
    flex: 1;
    min-width: 0;
}

.metric-label {
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
    font-weight: 500;
}

.metric-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #212529;
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.metric-change {
    display: flex;
    align-items: center;
    font-size: 0.8rem;
}

.metric-change .badge {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

/* Chart Card */
.chart-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
    overflow: hidden;
}

.chart-header {
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: between;
    align-items: flex-start;
    gap: 1rem;
}

.chart-title h5 {
    font-weight: 600;
    color: #212529;
}

.chart-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.chart-controls .btn-group .btn {
    border-radius: 0.5rem;
    font-size: 0.85rem;
    padding: 0.4rem 0.8rem;
}

.chart-body {
    padding: 1rem 1.5rem 1.5rem 1.5rem;
    height: 400px;
}

/* Orders Card */
.orders-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
    height: fit-content;
}

.orders-header {
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.orders-header h5 {
    font-weight: 600;
    color: #212529;
}

.orders-body {
    max-height: 400px;
    overflow-y: auto;
}

.orders-list {
    padding: 0.5rem 0;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #f8f9fa;
    transition: background-color 0.2s ease;
}

.order-item:hover {
    background-color: #f8f9fa;
}

.order-item:last-child {
    border-bottom: none;
}

.order-info {
    flex: 1;
    min-width: 0;
}

.order-code a {
    color: #0d6efd;
    font-size: 0.9rem;
}

.order-customer {
    font-size: 0.85rem;
    margin: 0.25rem 0;
}

.order-date {
    font-size: 0.8rem;
}

.order-meta {
    text-align: right;
    flex-shrink: 0;
    margin-left: 1rem;
}

.order-amount {
    font-size: 0.9rem;
    color: #212529;
    margin-bottom: 0.25rem;
}

.order-status .badge {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

.orders-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e9ecef;
}

.no-orders {
    padding: 2rem 1.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        margin: -1rem -1rem 0 -1rem;
        padding: 1.5rem 1rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .header-actions {
        margin-top: 1rem;
    }
    
    .header-actions .btn-group {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .header-actions .btn-group .btn {
        flex: 1;
        font-size: 0.8rem;
        padding: 0.4rem 0.5rem;
    }
    
    .metric-card {
        padding: 1rem !important;
    }
    
    .metric-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
    
    .metric-value {
        font-size: 1.25rem;
    }
    
    .chart-header {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .chart-controls {
        justify-content: center;
    }
    
    .filter-card .row {
        flex-direction: column;
    }
    
    .filter-card .col-md-6:first-child {
        margin-bottom: 1rem;
    }
    
    .quick-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: center;
    }
}

/* Custom Scrollbar */
.orders-body::-webkit-scrollbar {
    width: 4px;
}

.orders-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 2px;
}

.orders-body::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

.orders-body::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>

<script>
// Chart data from PHP
const chartLabels = <?php echo json_encode($chartLabels); ?>;
const chartRevenue = <?php echo json_encode($chartRevenue); ?>;
const chartOrders = <?php echo json_encode($chartOrders); ?>;

let salesChart;
let currentChartView = 'revenue';

document.addEventListener('DOMContentLoaded', function() {
    initCharts();
});

function initCharts() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Doanh thu (đ)',
                data: chartRevenue,
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#28a745',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#28a745',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            if (currentChartView === 'revenue') {
                                return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(context.parsed.y) + 'đ';
                            } else {
                                return 'Đơn hàng: ' + context.parsed.y;
                            }
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6c757d',
                        font: {
                            size: 12
                        },
                        callback: function(value) {
                            if (currentChartView === 'revenue') {
                                return new Intl.NumberFormat('vi-VN', {
                                    notation: 'compact',
                                    compactDisplay: 'short'
                                }).format(value) + 'đ';
                            } else {
                                return value;
                            }
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6c757d',
                        font: {
                            size: 12
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}

function toggleChartView(view) {
    if (view === currentChartView) return;
    
    currentChartView = view;
    
    // Update button states
    document.querySelectorAll('.chart-controls .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    if (view === 'revenue') {
        salesChart.data.datasets[0] = {
            label: 'Doanh thu (đ)',
            data: chartRevenue,
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#28a745',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        };
    } else {
        salesChart.data.datasets[0] = {
            label: 'Số đơn hàng',
            data: chartOrders,
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#007bff',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        };
    }
    
    salesChart.update('active');
}

function setPeriod(period) {
    const today = new Date();
    let fromDate, toDate;
    
    switch(period) {
        case 'day':
            fromDate = toDate = today.toISOString().split('T')[0];
            break;
        case 'week':
            const weekStart = new Date(today.setDate(today.getDate() - today.getDay()));
            fromDate = weekStart.toISOString().split('T')[0];
            toDate = new Date().toISOString().split('T')[0];
            break;
        case 'month':
            fromDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
            toDate = new Date().toISOString().split('T')[0];
            break;
        case 'year':
            fromDate = new Date(today.getFullYear(), 0, 1).toISOString().split('T')[0];
            toDate = new Date().toISOString().split('T')[0];
            break;
    }
    
    window.location.href = `?action=statis&period=${period}&date_from=${fromDate}&date_to=${toDate}`;
}

function setDateRange(range) {
    const today = new Date();
    let fromDate, toDate;
    
    switch(range) {
        case 'today':
            fromDate = toDate = today.toISOString().split('T')[0];
            break;
        case '7days':
            const week = new Date(today);
            week.setDate(week.getDate() - 7);
            fromDate = week.toISOString().split('T')[0];
            toDate = today.toISOString().split('T')[0];
            break;
        case '30days':
            const month = new Date(today);
            month.setDate(month.getDate() - 30);
            fromDate = month.toISOString().split('T')[0];
            toDate = today.toISOString().split('T')[0];
            break;
    }
    
    document.querySelector('input[name="date_from"]').value = fromDate;
    document.querySelector('input[name="date_to"]').value = toDate;
}

function exportStats() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'excel');
    window.open('export_stats.php?' + params.toString(), '_blank');
}

function downloadChart(chartType) {
    if (salesChart) {
        const url = salesChart.toBase64Image();
        const link = document.createElement('a');
        link.download = 'sales_chart.png';
        link.href = url;
        link.click();
    }
}
</script>
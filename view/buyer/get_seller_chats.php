<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION["id"])) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để tiếp tục.']);
    exit;
}

// Database connection
include_once("../../model/connect.php");
$kn = new clsketnoi();
$conn = $kn->moKetNoi();
$conn->set_charset('utf8');

$user_id = $_SESSION["id"];
$farm_id = isset($_GET['farm_id']) ? (int)$_GET['farm_id'] : 0;

if ($farm_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID cửa hàng không hợp lệ.']);
    exit;
}

// Get all chats for this farm
$sql = "SELECT c.*, 
        u_buyer.name as display_name,
        (SELECT COUNT(*) FROM messages m WHERE m.chat_id = c.id AND m.sender_id = c.buyer_id AND m.status = 'sent') as unread_count
        FROM chats c
        JOIN users u_buyer ON c.buyer_id = u_buyer.id
        JOIN users u_farmer ON c.farmer_id = u_farmer.id
        JOIN farms f ON u_farmer.id = f.owner_id
        WHERE f.id = ?
        ORDER BY c.last_sent_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $farm_id);
$stmt->execute();
$result = $stmt->get_result();

$chats = [];
$total_unread = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Calculate time ago
        $time_ago = getTimeAgo($row['last_sent_at']);
        
        $chats[] = [
            'id' => $row['id'],
            'display_name' => $row['display_name'],
            'last_message' => $row['last_message'] ?? 'Bắt đầu cuộc trò chuyện',
            'time_ago' => $time_ago,
            'unread_count' => (int)$row['unread_count']
        ];
        
        $total_unread += (int)$row['unread_count'];
    }
}

echo json_encode([
    'success' => true,
    'chats' => $chats,
    'unread_count' => $total_unread
]);

// Close connection
$conn->close();

// Helper function to calculate time ago
function getTimeAgo($timestamp) {
    if (empty($timestamp)) return 'Vừa xong';
    
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    
    if ($time_difference < 60) {
        return 'Vừa xong';
    } elseif ($time_difference < 3600) {
        $minutes = round($time_difference / 60);
        return $minutes . ' phút trước';
    } elseif ($time_difference < 86400) {
        $hours = round($time_difference / 3600);
        return $hours . ' giờ trước';
    } elseif ($time_difference < 604800) {
        $days = round($time_difference / 86400);
        return $days . ' ngày trước';
    } else {
        return date('d/m/Y', $time_ago);
    }
}
?>
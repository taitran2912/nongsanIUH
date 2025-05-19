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

// Get all chats for current user
$sql = "SELECT c.*, 
        CASE 
            WHEN c.buyer_id = ? THEN u_farmer.name
            ELSE u_buyer.name
        END as other_name,
        CASE 
            WHEN c.buyer_id = ? THEN f.shopname
            ELSE NULL
        END as farm_name,
        (SELECT COUNT(*) FROM messages m WHERE m.chat_id = c.id AND m.sender_id != ? AND m.status = 'sent') as unread_count
        FROM chats c
        JOIN users u_buyer ON c.buyer_id = u_buyer.id
        JOIN users u_farmer ON c.farmer_id = u_farmer.id
        LEFT JOIN farms f ON u_farmer.id = f.owner_id
        WHERE c.buyer_id = ? OR c.farmer_id = ?
        ORDER BY c.last_sent_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiii", $user_id, $user_id, $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$chats = [];
$total_unread = 0;

while ($row = $result->fetch_assoc()) {
    // Calculate time ago
    $time_ago = getTimeAgo($row['last_sent_at']);
    
    // Use farm name if available, otherwise use user name
    $display_name = !empty($row['farm_name']) ? $row['farm_name'] : $row['other_name'];
    
    $chats[] = [
        'id' => $row['id'],
        'display_name' => $display_name,
        'last_message' => $row['last_message'],
        'time_ago' => $time_ago,
        'unread_count' => $row['unread_count']
    ];
    
    $total_unread += $row['unread_count'];
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
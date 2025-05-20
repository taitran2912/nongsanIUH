<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
include_once("../../model/connect.php");
$kn = new clsketnoi();
$conn = $kn->moKetNoi();
$conn->set_charset('utf8');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Bạn cần đăng nhập để gửi tin nhắn'
    ]);
    exit;
}

// Get POST data
$chat_id = isset($_POST['chat_id']) ? (int)$_POST['chat_id'] : 0;
$sender_id = $_SESSION['id'];
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate input
if (empty($chat_id) || empty($message)) {
    echo json_encode([
        'success' => false,
        'message' => 'Thiếu thông tin cần thiết'
    ]);
    exit;
}

// Check if chat exists and user is a participant
$sql_check = "SELECT c.* FROM chats c 
              WHERE c.id = ? AND (c.buyer_id = ? OR c.farmer_id = ?)";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("iii", $chat_id, $sender_id, $sender_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows === 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Cuộc trò chuyện không tồn tại hoặc bạn không có quyền truy cập'
    ]);
    exit;
}

// Insert message into database
$sql_insert = "INSERT INTO messages (chat_id, sender_id, message, sent_at, status) 
               VALUES (?, ?, ?, NOW(), 'sent')";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("iis", $chat_id, $sender_id, $message);

if ($stmt_insert->execute()) {
    // Get the inserted message ID
    $message_id = $stmt_insert->insert_id;
    
    // Update the last_message and last_sent_at fields in the chats table
    $sql_update = "UPDATE chats SET last_message = ?, last_sent_at = NOW() WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $message, $chat_id);
    $stmt_update->execute();
    
    // Format the timestamp for display
    $current_time = date('H:i');
    
    echo json_encode([
        'success' => true,
        'message' => 'Tin nhắn đã được gửi',
        'message_id' => $message_id,
        'time' => $current_time
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Không thể gửi tin nhắn: ' . $stmt_insert->error
    ]);
}

// Close database connection
$stmt_insert->close();
if (isset($stmt_update)) $stmt_update->close();
$stmt_check->close();
$conn->close();
?>
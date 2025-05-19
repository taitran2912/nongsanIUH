<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Vui lòng đăng nhập để tiếp tục.']);
    exit;
}

// Database connection
include_once("../../model/connect.php");
$kn = new clsketnoi();
$conn = $kn->moKetNoi();
$conn->set_charset('utf8');

// Get parameters
$chat_id = isset($_GET['chat_id']) ? (int)$_GET['chat_id'] : 0;
$last_message_id = isset($_GET['last_id']) ? (int)$_GET['last_id'] : 0;
$current_user_id = $_SESSION['id'];

if ($chat_id <= 0) {
    echo json_encode(['error' => 'Thông tin không hợp lệ.']);
    exit;
}

// Check if user is part of this chat
$sql_check_user = "SELECT * FROM chats WHERE id = ? AND (buyer_id = ? OR farmer_id = ?)";
$stmt_check_user = $conn->prepare($sql_check_user);
$stmt_check_user->bind_param("iii", $chat_id, $current_user_id, $current_user_id);
$stmt_check_user->execute();
$chat_result = $stmt_check_user->get_result();

if ($chat_result->num_rows == 0) {
    echo json_encode(['error' => 'Bạn không có quyền truy cập cuộc trò chuyện này.']);
    exit;
}

// Get new messages
$sql_new_messages = "SELECT m.*, u.name as sender_name 
                    FROM messages m
                    JOIN users u ON m.sender_id = u.id
                    WHERE m.chat_id = ? AND m.id > ?
                    ORDER BY m.sent_at ASC";
$stmt_new_messages = $conn->prepare($sql_new_messages);
$stmt_new_messages->bind_param("ii", $chat_id, $last_message_id);
$stmt_new_messages->execute();
$new_messages_result = $stmt_new_messages->get_result();

$messages = [];
$last_id = $last_message_id;

if ($new_messages_result->num_rows > 0) {
    while ($message = $new_messages_result->fetch_assoc()) {
        $is_sender = ($message['sender_id'] == $current_user_id);
        
        $messages[] = [
            'id' => $message['id'],
            'message' => $message['message'],
            'sender_name' => $message['sender_name'],
            'sent_at' => date('H:i', strtotime($message['sent_at'])),
            'date' => date('Y-m-d', strtotime($message['sent_at'])),
            'is_sender' => $is_sender
        ];
        
        $last_id = max($last_id, $message['id']);
        
        // Update message status to 'read' if not sent by current user
        if (!$is_sender) {
            $sql_update_status = "UPDATE messages SET status = 'read' WHERE id = ?";
            $stmt_update_status = $conn->prepare($sql_update_status);
            $stmt_update_status->bind_param("i", $message['id']);
            $stmt_update_status->execute();
        }
    }
}

echo json_encode([
    'success' => true,
    'messages' => $messages,
    'last_id' => $last_id
]);

// Close connection
$conn->close();
?>
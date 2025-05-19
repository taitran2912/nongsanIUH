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
$chat_id = isset($_GET['chat_id']) ? (int)$_GET['chat_id'] : 0;
$last_id = isset($_GET['last_id']) ? (int)$_GET['last_id'] : 0;

if ($chat_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID cuộc trò chuyện không hợp lệ.']);
    exit;
}

// Check if user is part of this chat
$sql_check = "SELECT * FROM chats WHERE id = ? AND (buyer_id = ? OR farmer_id = ?)";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("iii", $chat_id, $user_id, $user_id);
$stmt_check->execute();
$check_result = $stmt_check->get_result();

if ($check_result->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'Bạn không có quyền truy cập cuộc trò chuyện này.']);
    exit;
}

// Get new messages
$sql = "SELECT m.*, u.name as sender_name 
        FROM messages m
        JOIN users u ON m.sender_id = u.id
        WHERE m.chat_id = ? AND m.id > ?
        ORDER BY m.sent_at ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $chat_id, $last_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
$new_last_id = $last_id;

while ($row = $result->fetch_assoc()) {
    $messages[] = [
        'id' => $row['id'],
        'message' => $row['message'],
        'sender_name' => $row['sender_name'],
        'is_sender' => ($row['sender_id'] == $user_id),
        'time' => date('H:i', strtotime($row['sent_at'])),
        'date' => date('Y-m-d', strtotime($row['sent_at']))
    ];
    
    $new_last_id = max($new_last_id, $row['id']);
    
    // Update message status to 'read' if not sent by current user
    if ($row['sender_id'] != $user_id && $row['status'] == 'sent') {
        $sql_update = "UPDATE messages SET status = 'read' WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $row['id']);
        $stmt_update->execute();
    }
}

echo json_encode([
    'success' => true,
    'messages' => $messages,
    'last_id' => $new_last_id
]);

// Close connection
$conn->close();
?>
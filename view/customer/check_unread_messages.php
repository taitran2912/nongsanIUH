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

// Count unread messages
$sql = "SELECT COUNT(*) as unread_count 
        FROM messages m 
        JOIN chats c ON m.chat_id = c.id 
        WHERE (c.buyer_id = ? OR c.farmer_id = ?) 
        AND m.sender_id != ? 
        AND m.status = 'sent'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode([
    'success' => true,
    'unread_count' => $row['unread_count']
]);

// Close connection
$conn->close();
?>
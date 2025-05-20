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

// Count unread messages for this farm
$sql = "SELECT COUNT(*) as unread_count 
        FROM messages m 
        JOIN chats c ON m.chat_id = c.id 
        JOIN users u ON c.farmer_id = u.id
        JOIN farms f ON u.id = f.owner_id
        WHERE f.id = ? 
        AND m.sender_id = c.buyer_id 
        AND m.status = 'sent'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $farm_id);
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
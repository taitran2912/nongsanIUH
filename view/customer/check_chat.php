<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection
include_once("../../model/connect.php");
$kn = new clsketnoi();
$conn = $kn->moKetNoi();
$conn->set_charset('utf8');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Vui lòng đăng nhập để tiếp tục.']);
    exit;
}

// Get parameters
$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$farm_id = isset($_POST['farm_id']) ? (int)$_POST['farm_id'] : 0;

if ($user_id <= 0 || $farm_id <= 0) {
    echo json_encode(['error' => 'Thông tin không hợp lệ.']);
    exit;
}

// Get farm owner ID
$sql_farm = "SELECT owner_id FROM farms WHERE id = ?";
$stmt_farm = $conn->prepare($sql_farm);
$stmt_farm->bind_param("i", $farm_id);
$stmt_farm->execute();
$farm_result = $stmt_farm->get_result();

if ($farm_result->num_rows == 0) {
    echo json_encode(['error' => 'Không tìm thấy thông tin cửa hàng.']);
    exit;
}

$farm_data = $farm_result->fetch_assoc();
$farmer_id = $farm_data['owner_id'];

// Check if chat already exists
$sql_check_chat = "SELECT id FROM chats WHERE (buyer_id = ? AND farmer_id = ?) OR (buyer_id = ? AND farmer_id = ?)";
$stmt_check_chat = $conn->prepare($sql_check_chat);
$stmt_check_chat->bind_param("iiii", $user_id, $farmer_id, $farmer_id, $user_id);
$stmt_check_chat->execute();
$chat_result = $stmt_check_chat->get_result();

if ($chat_result->num_rows > 0) {
    // Chat exists
    $chat_data = $chat_result->fetch_assoc();
    echo json_encode([
        'exists' => true,
        'chat_id' => $chat_data['id']
    ]);
} else {
    // Chat doesn't exist
    echo json_encode([
        'exists' => false
    ]);
}

// Close connection
$conn->close();
?>
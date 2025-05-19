<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Database connection
include_once("../../model/connect.php");
$kn = new clsketnoi();
$conn = $kn->moKetNoi();
$conn->set_charset('utf8');

// Get chat ID from URL
$chat_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($chat_id <= 0) {
    header("Location: index.php");
    exit;
}

// Get current user ID
$current_user_id = $_SESSION['id'];

// Check if user is part of this chat
$sql_check_user = "SELECT c.*, 
                    u_buyer.name as buyer_name, u_buyer.id as buyer_id,
                    u_farmer.name as farmer_name, u_farmer.id as farmer_id,
                    f.shopname as farm_name, f.id as farm_id
                   FROM chats c
                   JOIN users u_buyer ON c.buyer_id = u_buyer.id
                   JOIN users u_farmer ON c.farmer_id = u_farmer.id
                   JOIN farms f ON u_farmer.id = f.owner_id
                   WHERE c.id = ? AND (c.buyer_id = ? OR c.farmer_id = ?)";
$stmt_check_user = $conn->prepare($sql_check_user);
$stmt_check_user->bind_param("iii", $chat_id, $current_user_id, $current_user_id);
$stmt_check_user->execute();
$chat_result = $stmt_check_user->get_result();

if ($chat_result->num_rows == 0) {
    // User is not part of this chat
    header("Location: index.php");
    exit;
}

$chat_data = $chat_result->fetch_assoc();

// Determine if current user is buyer or farmer
$is_buyer = ($current_user_id == $chat_data['buyer_id']);
$other_user_id = $is_buyer ? $chat_data['farmer_id'] : $chat_data['buyer_id'];
$other_user_name = $is_buyer ? $chat_data['farm_name'] : $chat_data['buyer_name'];

// Get messages for this chat
$sql_messages = "SELECT m.*, u.name as sender_name 
                FROM messages m
                JOIN users u ON m.sender_id = u.id
                WHERE m.chat_id = ?
                ORDER BY m.sent_at ASC";
$stmt_messages = $conn->prepare($sql_messages);
$stmt_messages->bind_param("i", $chat_id);
$stmt_messages->execute();
$messages_result = $stmt_messages->get_result();

// Update message status to 'read' for messages sent to current user
$sql_update_status = "UPDATE messages 
                     SET status = 'read' 
                     WHERE chat_id = ? AND sender_id = ? AND status = 'sent'";
$stmt_update_status = $conn->prepare($sql_update_status);
$stmt_update_status->bind_param("ii", $chat_id, $other_user_id);
$stmt_update_status->execute();

// Handle new message submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && !empty($_POST['message'])) {
    $message = trim($_POST['message']);
    
    // Insert new message
    $sql_insert_message = "INSERT INTO messages (chat_id, sender_id, message, sent_at, status) 
                          VALUES (?, ?, ?, NOW(), 'sent')";
    $stmt_insert_message = $conn->prepare($sql_insert_message);
    $stmt_insert_message->bind_param("iis", $chat_id, $current_user_id, $message);
    
    if ($stmt_insert_message->execute()) {
        // Update last message in chat
        $sql_update_chat = "UPDATE chats 
                           SET last_message = ?, last_sent_at = NOW() 
                           WHERE id = ?";
        $stmt_update_chat = $conn->prepare($sql_update_chat);
        $stmt_update_chat->bind_param("si", $message, $chat_id);
        $stmt_update_chat->execute();
        
        // Redirect to avoid form resubmission
        header("Location: chat.php?id=" . $chat_id);
        exit;
    }
}

// Include header
include_once("../header.php");
?>

<div class="container my-4">
    <div class="row">
        <div class="col-md-3">
            <!-- Chat list -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Tin nhắn của tôi</h5>
                </div>
                <div class="list-group list-group-flush">
                    <?php
                    // Get all chats for current user
                    $sql_all_chats = "SELECT c.*, 
                                      CASE 
                                        WHEN c.buyer_id = ? THEN u_farmer.name
                                        ELSE u_buyer.name
                                      END as other_name,
                                      CASE 
                                        WHEN c.buyer_id = ? THEN f.shopname
                                        ELSE NULL
                                      END as farm_name
                                     FROM chats c
                                     JOIN users u_buyer ON c.buyer_id = u_buyer.id
                                     JOIN users u_farmer ON c.farmer_id = u_farmer.id
                                     LEFT JOIN farms f ON u_farmer.id = f.owner_id
                                     WHERE c.buyer_id = ? OR c.farmer_id = ?
                                     ORDER BY c.last_sent_at DESC";
                    $stmt_all_chats = $conn->prepare($sql_all_chats);
                    $stmt_all_chats->bind_param("iiii", $current_user_id, $current_user_id, $current_user_id, $current_user_id);
                    $stmt_all_chats->execute();
                    $all_chats_result = $stmt_all_chats->get_result();
                    
                    if ($all_chats_result->num_rows > 0) {
                        while ($chat = $all_chats_result->fetch_assoc()) {
                            $display_name = !empty($chat['farm_name']) ? $chat['farm_name'] : $chat['other_name'];
                            $active_class = ($chat['id'] == $chat_id) ? 'active' : '';
                            
                            // Check for unread messages
                            $sql_unread = "SELECT COUNT(*) as unread_count 
                                          FROM messages 
                                          WHERE chat_id = ? AND sender_id != ? AND status = 'sent'";
                            $stmt_unread = $conn->prepare($sql_unread);
                            $stmt_unread->bind_param("ii", $chat['id'], $current_user_id);
                            $stmt_unread->execute();
                            $unread_result = $stmt_unread->get_result();
                            $unread_data = $unread_result->fetch_assoc();
                            $unread_badge = ($unread_data['unread_count'] > 0) ? '<span class="badge bg-danger rounded-pill ms-2">' . $unread_data['unread_count'] . '</span>' : '';
                            
                            echo '<a href="chat.php?id=' . $chat['id'] . '" class="list-group-item list-group-item-action ' . $active_class . '">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-1">' . htmlspecialchars($display_name) . '</h6>
                                        ' . $unread_badge . '
                                    </div>
                                    <p class="mb-1 small text-truncate">' . htmlspecialchars($chat['last_message']) . '</p>
                                    <small class="text-muted">' . date('d/m/Y H:i', strtotime($chat['last_sent_at'])) . '</small>
                                  </a>';
                        }
                    } else {
                        echo '<div class="list-group-item">Bạn chưa có cuộc trò chuyện nào.</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <!-- Chat messages -->
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?php echo htmlspecialchars($other_user_name); ?></h5>
                    <?php if ($is_buyer): ?>
                    <a href="farm-detail.php?id=<?php echo $chat_data['farm_id']; ?>" class="btn btn-sm btn-light">
                        <i class="fas fa-store me-1"></i> Xem Shop
                    </a>
                    <?php endif; ?>
                </div>
                <div class="card-body" style="height: 400px; overflow-y: auto;" id="chat-messages">
                    <?php
                    if ($messages_result->num_rows > 0) {
                        $prev_date = '';
                        
                        while ($message = $messages_result->fetch_assoc()) {
                            $is_sender = ($message['sender_id'] == $current_user_id);
                            $message_class = $is_sender ? 'bg-primary text-white' : 'bg-light';
                            $message_align = $is_sender ? 'align-self-end' : 'align-self-start';
                            
                            // Show date separator if date changes
                            $message_date = date('Y-m-d', strtotime($message['sent_at']));
                            if ($message_date != $prev_date) {
                                echo '<div class="text-center my-3">
                                        <span class="badge bg-secondary">' . date('d/m/Y', strtotime($message['sent_at'])) . '</span>
                                      </div>';
                                $prev_date = $message_date;
                            }
                            
                            echo '<div class="d-flex flex-column mb-3 ' . $message_align . '" style="max-width: 75%;">
                                    <div class="p-2 rounded ' . $message_class . '">
                                        ' . nl2br(htmlspecialchars($message['message'])) . '
                                    </div>
                                    <small class="text-muted mt-1">' . date('H:i', strtotime($message['sent_at'])) . '</small>
                                  </div>';
                        }
                    } else {
                        echo '<div class="text-center text-muted">Hãy bắt đầu cuộc trò chuyện.</div>';
                    }
                    ?>
                </div>
                <div class="card-footer">
                    <form method="post" action="chat.php?id=<?php echo $chat_id; ?>">
                        <div class="input-group">
                            <textarea class="form-control" name="message" placeholder="Nhập tin nhắn..." rows="2" required></textarea>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i> Gửi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Scroll to bottom of chat messages
document.addEventListener('DOMContentLoaded', function() {
    var chatMessages = document.getElementById('chat-messages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
});

// Poll for new messages
var lastMessageId = <?php 
    // Get the ID of the last message
    $last_id_query = "SELECT MAX(id) as last_id FROM messages WHERE chat_id = ?";
    $stmt_last_id = $conn->prepare($last_id_query);
    $stmt_last_id->bind_param("i", $chat_id);
    $stmt_last_id->execute();
    $last_id_result = $stmt_last_id->get_result();
    $last_id_data = $last_id_result->fetch_assoc();
    echo $last_id_data['last_id'] ?? 0;
?>;

function checkNewMessages() {
    $.ajax({
        url: 'get_messages.php',
        type: 'GET',
        data: {
            chat_id: <?php echo $chat_id; ?>,
            last_id: lastMessageId
        },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.success && data.messages.length > 0) {
                var chatMessages = document.getElementById('chat-messages');
                var wasAtBottom = chatMessages.scrollHeight - chatMessages.clientHeight <= chatMessages.scrollTop + 50;
                
                var prevDate = '';
                data.messages.forEach(function(message) {
                    // Check if we need to add a date separator
                    if (message.date != prevDate) {
                        var dateElement = document.createElement('div');
                        dateElement.className = 'text-center my-3';
                        dateElement.innerHTML = '<span class="badge bg-secondary">' + 
                            new Date(message.date).toLocaleDateString('vi-VN') + '</span>';
                        chatMessages.appendChild(dateElement);
                        prevDate = message.date;
                    }
                    
                    // Create message element
                    var messageDiv = document.createElement('div');
                    messageDiv.className = 'd-flex flex-column mb-3 ' + 
                        (message.is_sender ? 'align-self-end' : 'align-self-start');
                    messageDiv.style.maxWidth = '75%';
                    
                    var messageContent = document.createElement('div');
                    messageContent.className = 'p-2 rounded ' + 
                        (message.is_sender ? 'bg-primary text-white' : 'bg-light');
                    messageContent.innerHTML = message.message.replace(/\n/g, '<br>');
                    
                    var timeSpan = document.createElement('small');
                    timeSpan.className = 'text-muted mt-1';
                    timeSpan.textContent = message.sent_at;
                    
                    messageDiv.appendChild(messageContent);
                    messageDiv.appendChild(timeSpan);
                    chatMessages.appendChild(messageDiv);
                });
                
                // Update last message ID
                lastMessageId = data.last_id;
                
                // Scroll to bottom if user was already at bottom
                if (wasAtBottom) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }
        }
    });
}

// Check for new messages every 5 seconds
setInterval(checkNewMessages, 5000);
</script>

<?php
// Include footer
include_once("../footer.php");

// Close connection
$conn->close();
?>
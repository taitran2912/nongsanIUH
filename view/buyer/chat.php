<?php
// Ensure user is logged in and has seller permissions
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit;
}

// Get farm ID
$farm_id = $storeId;

// Database connection
include_once("../../model/connect.php");
$kn = new clsketnoi();
$conn = $kn->moKetNoi();
$conn->set_charset('utf8');

// Get all chats for this farm
$sql = "SELECT c.*, 
        u_buyer.name as buyer_name,
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
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Tin nhắn khách hàng</h5>
                </div>
                <div class="card-body">
                    <?php if ($result->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Khách hàng</th>
                                        <th>Tin nhắn gần nhất</th>
                                        <th>Thời gian</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($chat = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($chat['buyer_name']); ?></td>
                                            <td><?php echo htmlspecialchars(mb_substr($chat['last_message'], 0, 50)) . (mb_strlen($chat['last_message']) > 50 ? '...' : ''); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($chat['last_sent_at'])); ?></td>
                                            <td>
                                                <?php if ($chat['unread_count'] > 0): ?>
                                                    <span class="badge bg-danger"><?php echo $chat['unread_count']; ?> tin nhắn mới</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Đã đọc</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary open-chat-btn" 
                                                        data-chat-id="<?php echo $chat['id']; ?>" 
                                                        data-buyer-name="<?php echo htmlspecialchars($chat['buyer_name']); ?>">
                                                    <i class="fas fa-comments"></i> Trả lời
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Bạn chưa có tin nhắn nào từ khách hàng.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to open chat buttons
    document.querySelectorAll('.open-chat-btn').forEach(button => {
        button.addEventListener('click', function() {
            const chatId = this.getAttribute('data-chat-id');
            const buyerName = this.getAttribute('data-buyer-name');
            
            // Open chat widget
            const chatContainer = document.getElementById('chatContainer');
            if (chatContainer) {
                chatContainer.classList.add('active');
                
                // Set current chat ID
                window.currentChatId = chatId;
                
                // Update UI
                document.getElementById('chatList').style.display = 'none';
                document.getElementById('chatMessages').classList.add('active');
                document.getElementById('chatPartnerName').textContent = buyerName;
                document.getElementById('backToChatList').style.display = 'block';
                
                // Load messages
                if (typeof window.loadChatMessages === 'function') {
                    window.loadChatMessages(chatId);
                }
                
                // Start polling
                if (typeof window.startChatPolling === 'function') {
                    window.startChatPolling();
                }
            }
        });
    });
});
</script>
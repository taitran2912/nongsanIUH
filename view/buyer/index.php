<?php
session_start();
include_once '../../controller/cBuyer.php';

$id = isset($_SESSION["id"]) ? intval($_SESSION["id"]) : 0;

$p = new cBuyer();

$r = $p->checkShop($id);
if($r && $r->num_rows > 0){
$row = $r->fetch_assoc();
$countShop = $row['count'];
if($countShop == 0){
    echo "<script>
            alert('Bạn không có quyền truy cập');
            window.location.href = '../customer/index.php';
          </script>";
    exit();
}
}
$storeId = 0;

$r = $p->getFarm($id);
if($r && $r->num_rows > 0){
    $row = $r->fetch_assoc();
    $storeId = $row['id'];
    $storeName = $row['shopname'];
}else {
    echo "<script>
            alert('Shop của bạn chưa được duyệt hoặc bị khoá');
            window.location.href = '../customer/index.php';
          </script>";
    exit();
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang người bán</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
    
    <link rel="stylesheet" href="../../asset/css/seller-dashboard.css">
    <!-- jQuery (required for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php
    
    ?>
</head>

<body>
    <div class="seller-dashboard">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <!-- <img src="../../image/logo.png" alt="Nông Sản Xanh Logo" class="logo"> -->
                <h3>
                    <?php 
                        echo $storeName
                    ?>
                </h3>
                <button id="sidebarCollapseBtn" class="d-md-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="?action=dashboard" class="nav-link <?php echo (!isset($_GET['action']) || $_GET['action'] == 'dashboard') ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt"></i> Tổng quan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?action=product" class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'product') ? 'active' : ''; ?>">
                        <i class="fas fa-box"></i> Sản phẩm
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?action=order" class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'order') ? 'active' : ''; ?>">
                        <i class="fas fa-shopping-cart"></i> Đơn hàng
                    </a>
                </li>

                <li class="nav-item">
                    <a href="?action=statis" class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'statis') ? 'active' : ''; ?>">
                        <i class="fas fa-chart-line"></i> Thống kê
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="?action=review" class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'review') ? 'active' : ''; ?>">
                        <i class="fas fa-star"></i> Đánh giá
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="?action=setting" class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'setting') ? 'active' : ''; ?>">
                        <i class="fas fa-cog"></i> Cài đặt
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="../customer/index.php" class="nav-link text-secondary">
                        <i class="fas fa-sign-out-alt"></i> Trở lại mua hàng
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <?php include_once 'nav.php'; ?>

            <!-- Content Area -->
            <div class="content-area p-4">
                <?php
                // Xác định trang cần hiển thị dựa trên tham số action
                $action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';
                
                // Kiểm tra và tải trang tương ứng
                switch ($action) {
                    case 'dashboard':
                        include_once 'dashboard.php';
                        break;
                    case 'product':
                        include_once 'product.php';
                        break;
                    case 'order':
                        include_once 'order.php';
                        break;
                    case 'customer':
                        include_once 'customer.php';
                        break;
                    case 'statis':
                        include_once 'statis.php';
                        break;
                    case 'review':
                        include_once 'review.php';
                        break;
                    case 'chat':
                        include_once 'chat.php';
                        break;
                    case 'setting':
                        include_once 'setting.php';
                        break;
                    case 'addProduct':
                        include_once 'addProduct.php';
                        break;
                    default:
                        include_once 'dashboard.php';
                        break;
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Chat Widget -->
    <div class="chat-widget" id="chatWidget">
        <div class="chat-button" id="chatButton">
            <i class="fas fa-comments"></i>
            <span class="chat-notification" id="chatNotification"></span>
        </div>
        
        <div class="chat-container" id="chatContainer">
            <div class="chat-header">
                <div class="d-flex align-items-center">
                    <button id="backToChatList" class="btn btn-sm btn-link text-white me-2" style="display: none;">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <h5 id="chatPartnerName" class="mb-0">Tin nhắn</h5>
                </div>
                <button class="chat-close" id="chatClose"><i class="fas fa-times"></i></button>
            </div>
            
            <div class="chat-content" id="chatContent">
                <div class="chat-list" id="chatList">
                    <!-- Chat list will be loaded here -->
                    <div class="chat-loading">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Đang tải...</span>
                        </div>
                    </div>
                </div>
                
                <div class="chat-messages" id="chatMessages">
                    <div class="chat-messages-header">
                        <button class="back-to-list" id="backToList"><i class="fas fa-arrow-left"></i></button>
                        <h6 id="chatPartnerName">Chọn một cuộc trò chuyện</h6>
                    </div>
                    <div class="chat-messages-content" id="chatMessagesContent">
                        <!-- Messages will be loaded here -->
                        <div class="chat-select-conversation">
                            <p>Vui lòng chọn một cuộc trò chuyện</p>
                        </div>
                    </div>
                    <div class="chat-input-container" id="chatInputContainer">
                        <textarea id="chatInput" placeholder="Nhập tin nhắn..." rows="1"></textarea>
                        <button id="sendMessage"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <!-- Custom JS -->
    <script src="../../asset/js/seller-dashboard.js"></script>

    <script>
    let currentChatId = 0;
    let lastMessageId = 0;
    let chatPollingInterval = null;
    let unreadCount = 0;

    document.addEventListener('DOMContentLoaded', function() {
        const chatButton = document.getElementById('chatButton');
        const chatClose = document.getElementById('chatClose');
        const chatContainer = document.getElementById('chatContainer');
        const chatList = document.getElementById('chatList');
        const chatMessages = document.getElementById('chatMessages');
        const backToList = document.getElementById('backToList');
        const sendMessage = document.getElementById('sendMessage');
        const chatInput = document.getElementById('chatInput');
        const chatMessagesContent = document.getElementById('chatMessagesContent');
        const chatNotification = document.getElementById('chatNotification');
        const sidebarChatBadge = document.getElementById('sidebarChatBadge');
        
        // Toggle chat container
        chatButton.addEventListener('click', function() {
            chatContainer.classList.toggle('active');
            if (chatContainer.classList.contains('active')) {
                loadChatList();
                chatNotification.style.display = 'none';
                unreadCount = 0;
            }
        });
        
        // Close chat container
        chatClose.addEventListener('click', function() {
            chatContainer.classList.remove('active');
        });
        
        // Back to chat list
        backToList.addEventListener('click', function() {
            chatList.style.display = 'block';
            chatMessages.classList.remove('active');
            stopChatPolling();
            currentChatId = 0;
        });
        
        // Send message
        sendMessage.addEventListener('click', sendChatMessage);
        
        // Send message on Enter (but allow Shift+Enter for new line)
        chatInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendChatMessage();
            }
        });
        
        // Auto-resize textarea
        chatInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Load chat list function
        function loadChatList() {
            console.log('Loading chat list...');
            fetch('get_seller_chats.php?farm_id=<?php echo $storeId; ?>')
                .then(response => {
                    console.log('Response received:', response);
                    return response.json();
                })
                .then(data => {
                    console.log('Chat list data:', data);
                    if (data.success) {
                        if (data.chats && data.chats.length > 0) {
                            renderChatList(data.chats);
                            
                            // Update unread count
                            unreadCount = data.unread_count || 0;
                            if (unreadCount > 0) {
                                chatNotification.textContent = unreadCount > 9 ? '9+' : unreadCount;
                                chatNotification.style.display = 'block';
                                sidebarChatBadge.textContent = unreadCount > 9 ? '9+' : unreadCount;
                                sidebarChatBadge.style.display = 'inline-block';
                            } else {
                                chatNotification.style.display = 'none';
                                sidebarChatBadge.style.display = 'none';
                            }
                        } else {
                            chatList.innerHTML = '<div class="no-chats">Không có cuộc trò chuyện nào</div>';
                            console.log('No chats found');
                        }
                    } else {
                        chatList.innerHTML = '<div class="no-chats">Không có cuộc trò chuyện nào</div>';
                        console.log('Error loading chat list:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading chat list:', error);
                    chatList.innerHTML = '<div class="chat-error">Không thể tải danh sách trò chuyện</div>';
                });
        }
        
        // Render chat list
        function renderChatList(chats) {
            if (chats.length === 0) {
                chatList.innerHTML = '<div class="no-chats">Không có cuộc trò chuyện nào</div>';
                return;
            }
            
            let html = '';
            chats.forEach(chat => {
                const unreadBadge = chat.unread_count > 0 ? 
                    `<span class="badge bg-danger rounded-pill">${chat.unread_count}</span>` : '';
                    
                html += `
                    <div class="chat-item" data-id="${chat.id}" data-name="${chat.display_name}">
                        <div class="chat-item-avatar">
                            <img src="../../image/default_avatar.jpg" alt="${chat.display_name}">
                        </div>
                        <div class="chat-item-info">
                            <div class="chat-item-name">${chat.display_name}</div>
                            <div class="chat-item-last-message">${chat.last_message}</div>
                        </div>
                        <div class="chat-item-meta">
                            <div class="chat-item-time">${chat.time_ago}</div>
                            ${unreadBadge}
                        </div>
                    </div>
                `;
            });
            
            chatList.innerHTML = html;
            
            // Add click event to chat items
            document.querySelectorAll('.chat-item').forEach(item => {
                item.addEventListener('click', function() {
                    const chatId = this.getAttribute('data-id');
                    const chatName = this.getAttribute('data-name');
                    openChat(chatId, chatName);
                });
            });
        }
        
        // Open chat function
        function openChat(chatId, chatName) {
            currentChatId = chatId;
            lastMessageId = 0;
            
            // Update UI
            chatList.style.display = 'none';
            chatMessages.classList.add('active');
            document.getElementById('chatPartnerName').textContent = chatName;
            chatMessagesContent.innerHTML = `
                <div class="chat-loading">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                </div>
            `;
            
            // Load messages
            loadChatMessages(chatId);
            
            // Start polling for new messages
            startChatPolling();
        }
        
        // Load chat messages
        function loadChatMessages(chatId) {
            fetch(`get_chat_messages.php?chat_id=${chatId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderChatMessages(data.messages);
                        lastMessageId = data.last_id || 0;
                    } else {
                        chatMessagesContent.innerHTML = '<div class="chat-error">Không thể tải tin nhắn</div>';
                    }
                })
                .catch(error => {
                    console.error('Error loading messages:', error);
                    chatMessagesContent.innerHTML = '<div class="chat-error">Không thể tải tin nhắn</div>';
                });
        }
        
        // Render chat messages
        function renderChatMessages(messages) {
            if (messages.length === 0) {
                chatMessagesContent.innerHTML = '<div class="no-messages">Chưa có tin nhắn nào</div>';
                return;
            }
            
            let html = '';
            let prevDate = '';
            
            messages.forEach(message => {
                // Add date separator if needed
                const messageDate = new Date(message.date).toLocaleDateString('vi-VN');
                if (messageDate !== prevDate) {
                    html += `<div class="message-date-separator"><span>${messageDate}</span></div>`;
                    prevDate = messageDate;
                }
                
                // Add message
                const messageClass = message.is_sender ? 'message-outgoing' : 'message-incoming';
                html += `
                    <div class="message ${messageClass}">
                        <div class="message-content">
                            ${message.message.replace(/\n/g, '<br>')}
                            <div class="message-time">${message.time}</div>
                        </div>
                    </div>
                `;
            });
            
            chatMessagesContent.innerHTML = html;
            chatMessagesContent.scrollTop = chatMessagesContent.scrollHeight;
        }
        
        // Send chat message
        function sendChatMessage() {
            const message = chatInput.value.trim();
            if (!message || currentChatId === 0) return;
            
            // Clear input and reset height
            chatInput.value = '';
            chatInput.style.height = 'auto';
            
            // Add temporary message to UI
            const tempId = 'temp-' + Date.now();
            const tempMessage = `
                <div class="message message-outgoing" id="${tempId}">
                    <div class="message-content">
                        ${message.replace(/\n/g, '<br>')}
                        <div class="message-time">Đang gửi...</div>
                    </div>
                </div>
            `;
            chatMessagesContent.insertAdjacentHTML('beforeend', tempMessage);
            chatMessagesContent.scrollTop = chatMessagesContent.scrollHeight;
            
            // Send message to server
            $.ajax({
                url: 'send_message.php',
                type: 'POST',
                data: {
                    chat_id: currentChatId,
                    message: message,
                    farm_id: <?php echo $storeId; ?>
                },
                dataType: 'json',
                success: function(data) {
                    // Remove temporary message
                    document.getElementById(tempId).remove();
                    
                    if (data.success) {
                        // Add the confirmed message
                        const confirmedMessage = `
                            <div class="message message-outgoing">
                                <div class="message-content">
                                    ${message.replace(/\n/g, '<br>')}
                                    <div class="message-time">${data.time}</div>
                                </div>
                            </div>
                        `;
                        chatMessagesContent.insertAdjacentHTML('beforeend', confirmedMessage);
                        chatMessagesContent.scrollTop = chatMessagesContent.scrollHeight;
                        
                        // Update last message ID
                        lastMessageId = data.message_id;
                    } else {
                        // Show error message
                        const errorMessage = `
                            <div class="message-error">
                                Không thể gửi tin nhắn: ${data.message}
                            </div>
                        `;
                        chatMessagesContent.insertAdjacentHTML('beforeend', errorMessage);
                        chatMessagesContent.scrollTop = chatMessagesContent.scrollHeight;
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error sending message:', xhr.responseText);
                    document.getElementById(tempId).remove();
                    
                    // Show error message
                    const errorMessage = `
                        <div class="message-error">
                            Không thể gửi tin nhắn. Vui lòng thử lại. (${status}: ${error})
                        </div>
                    `;
                    chatMessagesContent.insertAdjacentHTML('beforeend', errorMessage);
                    chatMessagesContent.scrollTop = chatMessagesContent.scrollHeight;
                }
            });
        }
        
        // Start polling for new messages
        function startChatPolling() {
            if (chatPollingInterval) {
                clearInterval(chatPollingInterval);
            }
            
            chatPollingInterval = setInterval(() => {
                if (currentChatId > 0) {
                    checkNewMessages();
                }
            }, 5000); // Check every 5 seconds
        }
        
        // Stop polling for new messages
        function stopChatPolling() {
            if (chatPollingInterval) {
                clearInterval(chatPollingInterval);
                chatPollingInterval = null;
            }
        }
        
        // Check for new messages
        function checkNewMessages() {
            fetch(`get_new_messages.php?chat_id=${currentChatId}&last_id=${lastMessageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.messages.length > 0) {
                        appendNewMessages(data.messages);
                        lastMessageId = data.last_id;
                    }
                })
                .catch(error => {
                    console.error('Error checking new messages:', error);
                });
        }
        
        // Append new messages to chat
        function appendNewMessages(messages) {
            let html = '';
            let prevDate = '';
            
            // Get the last date in the current chat
            const dateSeparators = chatMessagesContent.querySelectorAll('.message-date-separator');
            if (dateSeparators.length > 0) {
                const lastDateSeparator = dateSeparators[dateSeparators.length - 1];
                prevDate = lastDateSeparator.textContent.trim();
            }
            
            messages.forEach(message => {
                // Add date separator if needed
                const messageDate = new Date(message.date).toLocaleDateString('vi-VN');
                if (messageDate !== prevDate) {
                    html += `<div class="message-date-separator"><span>${messageDate}</span></div>`;
                    prevDate = messageDate;
                }
                
                // Add message
                const messageClass = message.is_sender ? 'message-outgoing' : 'message-incoming';
                html += `
                    <div class="message ${messageClass}">
                        <div class="message-content">
                            ${message.message.replace(/\n/g, '<br>')}
                            <div class="message-time">${message.time}</div>
                        </div>
                    </div>
                `;
            });
            
            chatMessagesContent.insertAdjacentHTML('beforeend', html);
            
            // Scroll to bottom if user was already at bottom
            const isAtBottom = chatMessagesContent.scrollHeight - chatMessagesContent.clientHeight <= chatMessagesContent.scrollTop + 50;
            if (isAtBottom) {
                chatMessagesContent.scrollTop = chatMessagesContent.scrollHeight;
            }
        }
        
        // Check for unread messages periodically
        setInterval(() => {
            if (!chatContainer.classList.contains('active') && window.location.href.indexOf('action=chat') === -1) {
                fetch('check_seller_unread.php?farm_id=<?php echo $storeId; ?>')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const newUnreadCount = data.unread_count || 0;
                            if (newUnreadCount > unreadCount) {
                                // Play notification sound if unread count increased
                                playNotificationSound();
                            }
                            
                            unreadCount = newUnreadCount;
                            if (unreadCount > 0) {
                                chatNotification.textContent = unreadCount > 9 ? '9+' : unreadCount;
                                chatNotification.style.display = 'block';
                                sidebarChatBadge.textContent = unreadCount > 9 ? '9+' : unreadCount;
                                sidebarChatBadge.style.display = 'inline-block';
                            } else {
                                chatNotification.style.display = 'none';
                                sidebarChatBadge.style.display = 'none';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error checking unread messages:', error);
                    });
            }
        }, 10000); // Check every 10 seconds
        
        // Play notification sound
        function playNotificationSound() {
            const audio = new Audio('../../asset/sounds/notification.mp3');
            audio.play().catch(e => console.log('Audio play failed:', e));
        }
        
        // Initial check for unread messages
        fetch('check_seller_unread.php?farm_id=<?php echo $storeId; ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    unreadCount = data.unread_count || 0;
                    if (unreadCount > 0) {
                        chatNotification.textContent = unreadCount > 9 ? '9+' : unreadCount;
                        chatNotification.style.display = 'block';
                        sidebarChatBadge.textContent = unreadCount > 9 ? '9+' : unreadCount;
                        sidebarChatBadge.style.display = 'inline-block';
                    }
                }
            })
            .catch(error => {
                console.error('Error checking initial unread messages:', error);
            });
    });
    </script>

    <style>
    /* Chat Widget Styles */
    .chat-widget {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .chat-button {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #28a745;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        position: relative;
    }

    .chat-button i {
        font-size: 24px;
    }

    .chat-button:hover {
        background-color: #218838;
        transform: scale(1.05);
    }

    .chat-notification {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: #dc3545;
        color: white;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        display: none;
    }

    .chat-container {
        position: absolute;
        bottom: 75px;
        right: 0;
        width: 350px;
        height: 450px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transform: scale(0);
        transform-origin: bottom right;
        transition: transform 0.3s ease;
        opacity: 0;
        visibility: hidden;
    }

    .chat-container.active {
        transform: scale(1);
        opacity: 1;
        visibility: visible;
    }

    .chat-header {
        padding: 15px;
        background-color: #28a745;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-header h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .chat-close {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 16px;
        padding: 0;
    }

    .chat-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
    }

    .chat-list {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
    }

    .chat-item {
        display: flex;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 5px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .chat-item:hover {
        background-color: #f8f9fa;
    }

    .chat-item-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 10px;
    }

    .chat-item-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .chat-item-info {
        flex: 1;
        min-width: 0;
    }

    .chat-item-name {
        font-weight: 600;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chat-item-last-message {
        font-size: 12px;
        color: #6c757d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chat-item-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        min-width: 45px;
    }

    .chat-item-time {
        font-size: 11px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .chat-messages {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: white;
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        visibility: hidden;
    }

    .chat-messages.active {
        transform: translateX(0);
        visibility: visible;
    }

    .chat-messages-header {
        padding: 10px 15px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        align-items: center;
    }

    .back-to-list {
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
        margin-right: 10px;
        padding: 5px;
    }

    .chat-messages-header h6 {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chat-messages-content {
        flex: 1;
        overflow-y: auto;
        padding: 15px;
        background-color: #f5f5f5;
    }

    .chat-input-container {
        padding: 10px;
        border-top: 1px solid #dee2e6;
        display: flex;
        align-items: center;
    }

    #chatInput {
        flex: 1;
        border: 1px solid #ced4da;
        border-radius: 20px;
        padding: 8px 15px;
        resize: none;
        max-height: 100px;
        font-size: 14px;
    }

    #chatInput:focus {
        outline: none;
        border-color: #28a745;
    }

    #sendMessage {
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        margin-left: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s ease;
    }

    #sendMessage:hover {
        background-color: #218838;
    }

    .message {
        margin-bottom: 10px;
        display: flex;
    }

    .message-incoming {
        justify-content: flex-start;
    }

    .message-outgoing {
        justify-content: flex-end;
    }

    .message-content {
        max-width: 80%;
        padding: 10px 15px;
        border-radius: 18px;
        position: relative;
        word-break: break-word;
    }

    .message-incoming .message-content {
        background-color: white;
        border: 1px solid #dee2e6;
    }

    .message-outgoing .message-content {
        background-color: #28a745;
        color: white;
    }

    .message-time {
        font-size: 10px;
        margin-top: 5px;
        opacity: 0.7;
        text-align: right;
    }

    .message-date-separator {
        text-align: center;
        margin: 15px 0;
        position: relative;
    }

    .message-date-separator::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
        background-color: #dee2e6;
        z-index: 1;
    }

    .message-date-separator span {
        background-color: #f5f5f5;
        padding: 0 10px;
        font-size: 12px;
        color: #6c757d;
        position: relative;
        z-index: 2;
    }

    .chat-loading {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .chat-loading .spinner-border {
        width: 2rem;
        height: 2rem;
    }

    .no-chats, .no-messages, .chat-error, .chat-select-conversation {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        color: #6c757d;
        text-align: center;
        padding: 20px;
    }

    .message-error {
        text-align: center;
        color: #dc3545;
        margin: 10px 0;
        font-size: 12px;
    }

    @media (max-width: 576px) {
        .chat-container {
            width: 300px;
            height: 400px;
            bottom: 70px;
        }
    }
    </style>
</body>

</html>
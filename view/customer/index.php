<?php
    session_start();
    $id = isset($_SESSION["id"]) ? intval($_SESSION["id"]) : 0;
    $role = isset($_SESSION["role"]) ? $_SESSION["role"] : '';
    include_once("../../controller/cProfile.php");
    include_once("../../model/connect.php");
    $p = new cProfile();

    // hủy đơn
    if(isset($_GET['action']) && $_GET['action'] == 'cancelorder'){
        $orderId = $_GET['id'];
        if($p->updateOrderStatus($orderId, 3, "Đã hủy")){
            echo "<script>alert('Hủy đơn hàng thành công!');</script>";
            echo "<script>window.location.href='index.php?action=profile';</script>";
        } else {
            echo "<script>alert('Hủy đơn hàng thất bại!');</script>";
        }
    }

    $count = 0;
    $countCart = $p->countCart($id);

    if ($countCart && $countCart->num_rows > 0) {
        $row = $countCart->fetch_assoc();
        $count = (int) $row['count'];
    }
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nông Sản Xanh - Sản phẩm nông nghiệp sạch</title>
    <link href="../../asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    
    <link rel="stylesheet" href="../../asset/css/styles.css">
    <link rel="stylesheet" href="../../asset/css/products.css">
    <link rel="stylesheet" href="../../asset/css/about-us.css">
    <link rel="stylesheet" href="../../asset/css/cart.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php
    if (isset($_GET['action']) && $_GET['action'] === 'detail') {
        echo '<link rel="stylesheet" href="../../asset/css/detail.css">';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'chitietdonhang') {
        echo '<link rel="stylesheet" href="../../asset/css/order_detail.css">';    
    }
    ?>
</head>

<body>
    <!-- Header -->
    <header class="sticky-top">
        <!-- Top Bar -->
        <div class="top-bar bg-success text-white py-2">
            <div class="container d-flex justify-content-between align-items-center">
                <div>
                    <span><i class="fas fa-phone-alt me-2"></i> 0123 456 789</span>
                    <span class="ms-3"><i class="fas fa-envelope me-2"></i> info@nongsanxanh.com</span>
                </div>
                <div>
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="?action=dashboard">
                    <img src="../../image/logo.png" alt="Nông Sản Xanh Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php echo (!isset($_GET['action']) || $_GET['action'] === 'dashboard') ? 'active' : ''; ?>" href="?action=dashboard">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] === 'product') ? 'active' : ''; ?>" href="?action=product">
                                Sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] === 'about') ? 'active' : ''; ?>" href="?action=about">Về chúng tôi</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <?php
                        if ($id == 0) {
                            echo '
                                <a href="?action=login" class="btn btn-outline-success me-2">
                                    Đăng nhập
                                </a>
                                <a href="?action=dangky" class="btn btn-outline-success me-2">
                                    Đăng ký
                                </a>
                            ';
                        } else {
                            echo '
                                <a href="?action=profile" class="btn btn-outline-success me-2 ';
                            echo (isset($_GET['action']) && $_GET['action'] === 'profile') ? 'active' : '';
                            echo '">
                                    <i class="fas fa-user"></i>
                                </a>';
                            echo '
                                <a href="../login/logout.php" class="btn btn-outline-success me-2">
                                    Đăng xuất
                                </a>
                            ';
                        }
                        ?>
                        <a href="?action=shopping-cart" class="btn btn-success position-relative <?php echo (isset($_GET['action']) && $_GET['action'] === 'shopping-cart') ? 'active' : ''; ?>">
                            <i class="fas fa-shopping-cart"></i>
                            <?php 
                            if($count > 0){
                                echo '
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    '.$count.'
                                </span>';
                            }
                            ?>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <?php
            if (isset($_REQUEST["action"])) {
                $val = $_REQUEST["action"];
                switch ($val) {
                    case 'login':
                        echo "
                            <script>
                                window.location.href = '../../log.php';
                            </script>
                        ";
                        break;
                    case 'dangky':
                        echo "
                            <script>
                                window.location.href = '../../log.php?dangky';
                            </script>
                        ";
                        break;
                    case 'profile':
                        include_once("profile.php");
                        break;
                    case 'product':
                        include_once("product.php");
                        break;
                    case 'shopping-cart':
                        include_once("shopping-cart.php");
                        break;
                    case 'about':
                        include_once("about.php");
                        break;
                    case 'detail':
                        include_once("detail.php");
                        break;
                    case 'order_detail':
                        include_once("chitietdonhang.php");
                        break;
                    case 'dashboard':
                    default:
                        include_once("dashboard.php");
                }
            } else {
                include_once("dashboard.php"); 
            }
        ?>
    </main>

    <!-- Footer -->
    <footer class="footer pt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget">
                        <img src="../../image/logo.png" width="50px" high="50px" class="mb-4" alt="Nông Sản Xanh Logo">
                        
                        <p>Chúng tôi cung cấp các sản phẩm nông nghiệp sạch, an toàn và chất lượng cao, được trồng và thu hoạch theo tiêu chuẩn hữu cơ quốc tế.</p>
                        <div class="social-links mt-3">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="footer-widget">
                        <h5 class="widget-title">Liên kết nhanh</h5>
                        <ul class="footer-links">
                            <li><a href="?action=dashboard">Trang chủ</a></li>
                            <li><a href="?action=product">Sản phẩm</a></li>
                            <li><a href="?action=about">Về chúng tôi</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5 class="widget-title">Danh mục sản phẩm</h5>
                        <ul class="footer-links">
                            <li><a href="#">Rau củ hữu cơ</a></li>
                            <li><a href="#">Trái cây theo mùa</a></li>
                            <li><a href="#">Gạo & Ngũ cốc</a></li>
                            <li><a href="#">Thực phẩm chế biến</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5 class="widget-title">Thông tin liên hệ</h5>
                        <div class="contact-info">
                            <p><i class="fas fa-map-marker-alt"></i> 123 Đường Nông Nghiệp, Quận 2, TP. Hồ Chí Minh</p>
                            <p><i class="fas fa-phone-alt"></i> 0123 456 789</p>
                            <p><i class="fas fa-envelope"></i> info@nongsanxanh.com</p>
                            <p><i class="fas fa-clock"></i> Thứ 2 - Chủ nhật: 8:00 - 20:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom py-3 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-0">© 2023 Nông Sản Xanh. Tất cả quyền được bảo lưu.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-0">Thiết kế bởi <a href="#" class="text-success">Nông Sản Xanh</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

    <!-- Chat Widget -->
    <?php if (isset($_SESSION["id"]) && $_SESSION["id"] > 0): ?>
    <div class="chat-widget" id="chatWidget">
        <div class="chat-button" id="chatButton">
            <i class="fas fa-comments"></i>
            <span class="chat-notification" id="chatNotification"></span>
        </div>
        
        <div class="chat-container" id="chatContainer">
            <div class="chat-header">
                <h5>Tin nhắn</h5>
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
            fetch('get_chat_list.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderChatList(data.chats);
                        
                        // Update unread count
                        unreadCount = data.unread_count || 0;
                        if (unreadCount > 0) {
                            chatNotification.textContent = unreadCount > 9 ? '9+' : unreadCount;
                            chatNotification.style.display = 'block';
                        } else {
                            chatNotification.style.display = 'none';
                        }
                    } else {
                        chatList.innerHTML = '<div class="no-chats">Không có cuộc trò chuyện nào</div>';
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
                            <img src="../../image/default_shop_avatar.jpg" alt="${chat.display_name}">
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
                    message: message
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
            if (!chatContainer.classList.contains('active')) {
                fetch('check_unread_messages.php')
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
                            } else {
                                chatNotification.style.display = 'none';
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
        fetch('check_unread_messages.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    unreadCount = data.unread_count || 0;
                    if (unreadCount > 0) {
                        chatNotification.textContent = unreadCount > 9 ? '9+' : unreadCount;
                        chatNotification.style.display = 'block';
                    }
                }
            })
            .catch(error => {
                console.error('Error checking initial unread messages:', error);
            });
    });

    // Expose functions to be used from other pages
    window.openChat = function(chatId, chatName) {
        currentChatId = chatId;
        lastMessageId = 0;
        
        // Update UI
        document.getElementById('chatList').style.display = 'none';
        document.getElementById('chatMessages').classList.add('active');
        document.getElementById('chatPartnerName').textContent = chatName;
        document.getElementById('chatMessagesContent').innerHTML = `
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
    };

    window.loadChatMessages = loadChatMessages;
    window.startChatPolling = startChatPolling;
    window.currentChatId = currentChatId;

    function sendMessage(chatId, message) {
        $.ajax({
            url: 'send_message.php',
            type: 'POST',
            data: {
                chat_id: chatId,
                message: message
            },
            success: function(response) {
                try {
                    var data = JSON.parse(response);
                    if (data.success) {
                        // Message sent successfully
                        // You can append the message to the chat window here
                        appendMessage(data.data);
                        // Clear the message input
                        $('#messageInput').val('');
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e, response);
                    alert('Có lỗi xảy ra khi xử lý phản hồi từ máy chủ.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Không thể kết nối đến máy chủ. Vui lòng thử lại sau.');
            }
        });
    }
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
        background-color: #e05d37;
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
        background-color: #d04d27;
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
        background-color: #e05d37;
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
        border-color: #e05d37;
    }

    #sendMessage {
        background-color: #e05d37;
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
        background-color: #d04d27;
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
        background-color: #e05d37;
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
    <?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="../../asset/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../../asset/js/script.js"></script>
</body>
</html>
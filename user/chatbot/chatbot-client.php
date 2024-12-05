<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <!-- CSS giữ nguyên từ mã ban đầu -->
</head>
<body>
<div class="chatbot-container">
    <div id="chatbot-bubble" class="bubble">
        <img src="./img/messenger-icon.png" alt="Chatbot">
    </div>
    <div id="chatbox" class="chatbox">
        <div class="chat-header">
            Chat với chúng tôi 
            <button id="close-button" class="close-btn">×</button>
        </div>
        <div class="chat-content" id="chat-content"></div>
        <div class="chat-input-container">
            <input type="text" id="user-input" placeholder="Nhập tin nhắn..." autocomplete="off" />
            <button id="send-button">Gửi</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chatbotBubble = document.getElementById('chatbot-bubble');
    const chatbox = document.getElementById('chatbox');
    const closeButton = document.getElementById('close-button');
    const sendButton = document.getElementById('send-button');
    const userInput = document.getElementById('user-input');
    const chatContent = document.getElementById('chat-content');

    chatbotBubble.addEventListener('click', function () {
        chatbox.style.display = 'flex';
        userInput.focus();
    });

    closeButton.addEventListener('click', function () {
        chatbox.style.display = 'none';
    });

    sendButton.addEventListener('click', sendMessage);
    userInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    function sendMessage() {
        const message = userInput.value.trim();
        if (message) {
            appendMessage('user-message', message);
            userInput.value = '';
            fetch('../admin/chatbot/chatbot-server.php', { // Gọi server-side chatbot
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ message })
            })
            .then(response => response.json())
            .then(data => {
                appendMessage('bot-message', data.response || 'Không có phản hồi từ chatbot.');
            })
            .catch(error => {
                appendMessage('bot-message', 'Lỗi kết nối tới server.');
            });
        }
    }

    function appendMessage(type, message) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('chat-message', type);
        messageElement.innerHTML = message;
        chatContent.appendChild(messageElement);
        chatContent.scrollTop = chatContent.scrollHeight;
    }
});
</script>
</body>
</html>

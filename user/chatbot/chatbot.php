<?php
// Bắt đầu session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kết nối đến cơ sở dữ liệu
include '../admin/connect.php'; 

// Bật hiển thị tất cả lỗi
error_reporting(E_ALL); 
ini_set('display_errors', 2); 

// Kiểm tra kết nối cơ sở dữ liệu
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePostRequest();
    exit; // Dừng sau khi xử lý POST
}

function handlePostRequest() {
    global $conn;
    $user_message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Nếu người dùng không gửi tin nhắn (nhấp vào bong bóng), gửi câu chào
    if (empty($user_message)) {
        $response = getGreetingResponse();
        echo json_encode(['response' => $response, 'history' => $_SESSION['chat_history'] ?? []]);
        return;
    }

    if ($user_message) {
        $response = chatbotResponse($user_message);
        updateChatHistory($user_message, $response);
        
        echo json_encode(['response' => $response, 'history' => $_SESSION['chat_history'] ?? []]);
    } else {
        echo json_encode(['response' => "Tin nhắn không hợp lệ."]);
    }
}

function updateChatHistory($user_message, $response) {
    if (!isset($_SESSION['chat_history'])) {
        $_SESSION['chat_history'] = [];
    }

    // Lưu lịch sử chat vào cơ sở dữ liệu
    global $conn;
    $stmt = $conn->prepare("INSERT INTO chat_history (user_message, bot_response, timestamp) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $user_message, $response);

    if (!$stmt->execute()) {
        file_put_contents('log.txt', "Database error: " . $stmt->error . PHP_EOL, FILE_APPEND);
    }

    $_SESSION['chat_history'][] = ['user' => htmlspecialchars($user_message), 'bot' => htmlspecialchars($response)];
    if (count($_SESSION['chat_history']) > 10) {
        array_shift($_SESSION['chat_history']); // Giữ lịch sử chat chỉ với 10 tin nhắn
    }
}

function chatbotResponse($message) {
    $message = strtolower(trim($message));
    $responses = getResponses();

    foreach ($responses as $data) {
        foreach ($data['keywords'] as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return $data['response'];
            }
        }
    }
    
    return generateDynamicResponse($message);
}

function getResponses() {
    return [
        [
            'keywords' => ['xin chào', 'chào bạn', 'hi', 'hello'],
            'response' => "Xin chào! Tôi có thể giúp gì được cho bạn?"
        ],
        [
            'keywords' => ['sản phẩm', 'laptop', 'máy tính'],
            'response' => getProductList()
        ],
        [
            'keywords' => ['giá', 'bao nhiêu', 'chi phí'],
            'response' => 'Bạn muốn biết giá của sản phẩm nào?'
        ],
        [
            'keywords' => ['liên hệ', 'thông tin liên hệ', 'gọi điện'],
            'response' => 'Bạn có thể liên hệ với chúng tôi qua số điện thoại: 0123-456-789.'
        ],
        [
            'keywords' => ['địa chỉ', 'nơi', 'chúng tôi ở đâu'],
            'response' => 'Chúng tôi ở 123 Đường ABC, Thành phố XYZ.'
        ],
    ];
}

function generateDynamicResponse($message) {
    return "Xin lỗi, tôi không hiểu yêu cầu của bạn.";
}

function getProductList() {
    global $conn;
    if (!$conn) {
        return "Không thể kết nối đến cơ sở dữ liệu.";
    }

    $stmt = $conn->prepare("SELECT ten_san_pham, gia FROM san_pham LIMIT 5");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product_list = array_map(function($row) {
            return "- " . htmlspecialchars($row['ten_san_pham']) . ": " . number_format($row['gia']) . " VND";
        }, $result->fetch_all(MYSQLI_ASSOC));

        return "Dưới đây là một số sản phẩm của chúng tôi:<br>" . implode("<br>", $product_list);
    } else {
        return "Xin lỗi, hiện không có sản phẩm nào trong kho.";
    }
}

function getGreetingResponse() {
    return "Xin chào, tôi là trợ lý của bạn. Bạn có cần tôi hỗ trợ điều gì không?";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #e9ecef;
        }
        .chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        .bubble {
            cursor: pointer;
            width: 60px;
            height: 60px;
        }
        .bubble img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }
        .chatbox {
            width: 300px;
            height: 400px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            display: none;
            flex-direction: column;
        }
        .chat-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            position: relative;
        }
        .close-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
            position: absolute;
            right: 10px;
            top: 10px;
        }
        .chat-content {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            border-bottom: 1px solid #ddd;
        }
        .chat-input-container {
            display: flex;
            padding: 10px;
            background-color: white;
        }
        #user-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            outline: none;
        }
        #send-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s;
        }
        #send-button:hover {
            background-color: #0056b3;
        }
        .chat-message {
            margin-bottom: 10px;
        }
        .user-message {
            text-align: right;
            background-color: #007bff;
            color: white;
            padding: 8px;
            border-radius: 10px;
            max-width: 75%;
            margin-left: auto;
        }
        .bot-message {
            text-align: left;
            background-color: #ddd;
            padding: 8px;
            border-radius: 10px;
            max-width: 75%;
            margin-right: auto;
        }
    </style>
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
        loadChatHistory();
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
            fetch('.chatbot/chatbot.php', { 
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ message })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data && data.response) {
                    appendMessage('bot-message', data.response);
                } else {
                    appendMessage('bot-message', 'Không có phản hồi từ chatbot.');
                }
                if (data.history) {
                    // Nếu bạn muốn hiển thị lịch sử chat
                    data.history.forEach(entry => {
                        appendMessage('user-message', entry.user);
                        appendMessage('bot-message', entry.bot);
                    });
                }
            })
            .catch(error => {
                appendMessage('bot-message', 'Xin lỗi, đã xảy ra lỗi: ' + error.message);
            });
        }
    }

    function appendMessage(type, message) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('chat-message', type);
        messageElement.innerHTML = message;
        chatContent.appendChild(messageElement);
        chatContent.scrollTop = chatContent.scrollHeight; // Cuộn xuống dưới cùng
    }

    function loadChatHistory() {
        
        }
});
</script>
</body>
</html>

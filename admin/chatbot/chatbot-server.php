<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../admin/connect.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($conn->connect_error) {
    die(json_encode(['response' => 'Không thể kết nối tới cơ sở dữ liệu.']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePostRequest();
    exit;
}

function handlePostRequest() {
    global $conn;
    $user_message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    if (empty($user_message)) {
        echo json_encode(['response' => getGreetingResponse()]);
        return;
    }

    $response = chatbotResponse($user_message);
    updateChatHistory($user_message, $response);
    echo json_encode(['response' => $response]);
}

function updateChatHistory($user_message, $response) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO chat_history (user_message, bot_response, timestamp) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $user_message, $response);
    $stmt->execute();

    if (!isset($_SESSION['chat_history'])) {
        $_SESSION['chat_history'] = [];
    }

    $_SESSION['chat_history'][] = ['user' => htmlspecialchars($user_message), 'bot' => htmlspecialchars($response)];
    if (count($_SESSION['chat_history']) > 10) {
        array_shift($_SESSION['chat_history']);
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
        ['keywords' => ['xin chào', 'hello'], 'response' => "Xin chào! Tôi có thể giúp gì cho bạn?"],
        ['keywords' => ['sản phẩm', 'máy tính'], 'response' => getProductList()],
        ['keywords' => ['giá', 'bao nhiêu'], 'response' => 'Bạn muốn biết giá sản phẩm nào?']
    ];
}

function getProductList() {
    global $conn;
    $stmt = $conn->prepare("SELECT ten_san_pham, gia FROM san_pham LIMIT 5");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = "- {$row['ten_san_pham']}: " . number_format($row['gia']) . " VND";
        }
        return implode("<br>", $products);
    } else {
        return "Hiện không có sản phẩm nào.";
    }
}

function generateDynamicResponse($message) {
    return "Xin lỗi, tôi không hiểu yêu cầu của bạn.";
}

function getGreetingResponse() {
    return "Xin chào, tôi là trợ lý chatbot. Bạn cần giúp đỡ gì?";
}

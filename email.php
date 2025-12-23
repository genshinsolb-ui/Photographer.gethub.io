<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Имя обязательно для заполнения.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Введите корректный email.";
    }
    if (empty($message)) {
        $errors[] = "Сообщение не может быть пустым.";
    }
    
    if (empty($errors)) {
        $to = "zvezda-email@example.com"; 
        $subject = "Новое сообщение с сайта фотографа от $name";
        $body = "Имя: $name\nEmail: $email\n\nСообщение:\n$message";
        $headers = "From: $email";
        
        if (mail($to, $subject, $body, $headers)) {
            echo json_encode(["success" => true, "message" => "Сообщение успешно отправлено!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Ошибка при отправке сообщения."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => implode("\n", $errors)]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Метод запроса неверен."]);
}
?>
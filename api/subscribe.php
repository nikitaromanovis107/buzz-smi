<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error']);
    exit;
}

$email = trim($_POST['email'] ?? '');
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'invalid']);
    exit;
}

$filepath = __DIR__ . '/../subscribers.txt';

// Загружаем существующие email'ы
$emails = [];
if (file_exists($filepath)) {
    $emails = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

// Проверяем дубль
if (in_array($email, $emails)) {
    echo json_encode(['status' => 'exists']);
    exit;
}

// Сохраняем
file_put_contents($filepath, $email . "\n", FILE_APPEND | LOCK_EX);

echo json_encode(['status' => 'ok']);
?>
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login_form.php');
    exit;
}
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

$title = trim($_POST['title'] ?? '');
$category = trim($_POST['category'] ?? '');
$author = trim($_POST['author'] ?? '');
$excerpt = trim($_POST['excerpt'] ?? '');
$full_text = $_POST['full_text'] ?? '';

if (!$title || !$full_text) {
    die('Ошибка: заполните все поля');
}

// Обработка изображения (опционально)
$img_path = $_POST['current_img'] ?? '';
if (!empty($_FILES['image']['name'])) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, $allowed) && $_FILES['image']['size'] <= 2097152) {
        $filename = uniqid() . '.' . $ext;
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
            $img_path = '/uploads/' . $filename;
        }
    }
}

$stmt = $pdo->prepare("UPDATE articles SET title = ?, category = ?, author = ?, excerpt = ?, full_text = ?, img = ? WHERE id = ?");
$stmt->execute([$title, $category, $author, $excerpt, $full_text, $img_path, $id]);

header('Location: dashboard.php?updated=1');
exit;
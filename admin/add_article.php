
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login_form.php');
    exit;
}
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверка данных
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? 'общество');
    $author = trim($_POST['author'] ?? 'Аноним');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $full_text = $_POST['full_text'] ?? '';

    if (!$title || !$full_text) {
        die('Ошибка: заголовок и текст обязательны');
    }

    // Обработка изображения
    $img_path = 'https://via.placeholder.com/1200x500?text=' . urlencode($title);
    
    if (!empty($_FILES['image']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed) && $_FILES['image']['size'] <= 2097152) { // 2 МБ
            $filename = uniqid() . '.' . $ext;
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
            
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
                $img_path = '/uploads/' . $filename;
            }
        }
    }

    // Сохранение в БД
    $stmt = $pdo->prepare("INSERT INTO articles (title, category, author, excerpt, full_text, img) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $category, $author, $excerpt, $full_text, $img_path]);

    header('Location: dashboard.php?added=1');
    exit;
}
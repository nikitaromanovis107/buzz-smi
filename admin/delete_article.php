<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login_form.php');
    exit;
}

include 'includes/db.php';

$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $pdo->prepare("DELETE FROM articles WHERE id = ?")->execute([$id]);
}

header('Location: dashboard.php');
exit;
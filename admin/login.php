<?php
session_start();

// 🔑 Установите ваш пароль здесь (замените "mypass" на свой!)
$correct_password = "173220";

if ($_POST['password'] === $correct_password) {
    $_SESSION['admin'] = true;
    header('Location: dashboard.php');
    exit;
} else {
    header('Location: login_form.php?error=1');
    exit;
}
?>
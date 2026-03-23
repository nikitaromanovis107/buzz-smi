<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login_form.php');
    exit;
}
header('Location: dashboard.php');
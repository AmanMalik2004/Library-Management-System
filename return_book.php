<?php
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'models/BorrowRecord.php';
require_once 'models/Book.php';
requireLogin();

$record_id = $_GET['record_id'] ?? 0;

if (!$record_id) {
    $_SESSION['error'] = 'Invalid record ID';
    header('Location: ' . BASE_URL . 'dashboard.php');
    exit();
}

$borrowModel = new Book();
$result = $borrowModel->returnBook($record_id, getCurrentUserId());

if ($result['success']) {
    $_SESSION['success'] = $result['message'];
} else {
    $_SESSION['error'] = $result['message'];
}

header('Location: ' . BASE_URL . 'dashboard.php');
exit();
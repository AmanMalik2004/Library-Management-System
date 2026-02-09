<?php
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'models/Book.php';
requireLogin();
$book_id = $_GET['book_id'] ?? 0;

if (!$book_id) {
    $_SESSION['error'] = 'Invalid book ID';
    header('Location: ' . BASE_URL . 'books.php');
    exit();
}

$bookModel = new Book();
$result = $bookModel->borrowBook(getCurrentUserId(), $book_id);

if ($result['success']) {
    $_SESSION['success'] = $result['message'];
} else {
    $_SESSION['error'] = $result['message'];
}

header('Location: ' . BASE_URL . 'dashboard.php');
exit();
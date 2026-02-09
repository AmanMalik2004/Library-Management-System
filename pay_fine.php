<?php
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'models/Fine.php';
requireLogin();

$fine_id = $_GET['fine_id'] ?? 0;
if (!$fine_id) {
    $_SESSION['error'] = 'Invalid fine ID';
    header('Location: ' . BASE_URL . 'fines.php');
    exit();
}

$fineModel = new Fine();
$result = $fineModel->payFine($fine_id, getCurrentUserId());

if ($result['success']) {
    $_SESSION['success'] = $result['message'];
} else {
    $_SESSION['error'] = $result['message'];
}

header('Location: ' . BASE_URL . 'fines.php');
exit();
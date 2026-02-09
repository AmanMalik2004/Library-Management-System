<?php
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'models/Book.php';
require_once 'models/BorrowRecord.php';
requireLogin();

$book_id = $_GET['id'] ?? 0;
$bookModel = new Book();
$book = $bookModel->getBookById($book_id);

if (!$book) {
    header('Location: ' . BASE_URL . 'books.php');
    exit();
}

$pageTitle = $book['title'];
$borrowModel = new BorrowRecord();
$isBorrowed = $borrowModel->isBookBorrowedByUser(getCurrentUserId(), $book_id);

include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <a href="books.php" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Back to Books
            </a>            
            <div class="card">
                <div class="card-body">
                    <h2><?php echo htmlspecialchars($book['title']); ?></h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-user"></i> Author:</strong> 
                               <?php echo htmlspecialchars($book['author_name'] ?? 'Unknown Author'); ?></p>
                            <p><strong><i class="fas fa-tag"></i> Category:</strong> 
                               <?php echo htmlspecialchars($book['category']); ?></p>
                            <p><strong><i class="fas fa-copy"></i> Total Copies:</strong> 
                               <?php echo $book['total_copies']; ?></p>
                            <p><strong><i class="fas fa-check-circle"></i> Available Copies:</strong> 
                               <span class="badge bg-<?php echo $book['available_copies'] > 0 ? 'success' : 'danger'; ?>">
                                   <?php echo $book['available_copies']; ?>
                               </span>
                            </p>
                            <p><strong><i class="fas fa-dollar-sign"></i> Fine per Day:</strong> 
                               $<?php echo number_format($book['fine_price'], 2); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Description</h5>
                            <p><?php echo nl2br(htmlspecialchars($book['description'] ?? 'No description available.')); ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-3">
                        <?php if ($isBorrowed): ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> You have already borrowed this book.
                            </div>
                        <?php elseif ($book['available_copies'] > 0): ?>
                            <a href="borrow_book.php?book_id=<?php echo $book['book_id']; ?>" 
                               class="btn btn-success btn-lg"
                               onclick="return confirm('Are you sure you want to borrow this book?')">
                                <i class="fas fa-book"></i> Borrow This Book
                            </a>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> This book is currently not available.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
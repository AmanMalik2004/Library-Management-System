<?php
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'models/Book.php';
requireLogin();

$pageTitle = 'Browse Books';
$bookModel = new Book();
$searchTerm = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$books = $bookModel->searchBooks($searchTerm, $category);
$categories = $bookModel->getCategories();

include 'includes/header.php';
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2><i class="fas fa-book"></i> Browse Books</h2>
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="books.php">
                        <div class="row">
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="search" 
                                       placeholder="Search by title or author..." 
                                       value="<?php echo htmlspecialchars($searchTerm); ?>">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="category">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo htmlspecialchars($cat); ?>" 
                                                <?php echo $category === $cat ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="books.php" class="btn btn-secondary w-100">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <?php if (empty($books)): ?>
                    <div class="col-12">
                        <div class="alert alert-info">No books found.</div>
                    </div>
                <?php else: ?>
                    <?php foreach ($books as $book): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                                    <p class="text-muted">
                                        <i class="fas fa-user"></i> 
                                        <?php echo htmlspecialchars($book['author_name'] ?? 'Unknown Author'); ?>
                                    </p>
                                    <p class="text-muted">
                                        <i class="fas fa-tag"></i> 
                                        <?php echo htmlspecialchars($book['category']); ?>
                                    </p>
                                    <p class="card-text">
                                        <?php echo htmlspecialchars(substr($book['description'] ?? '', 0, 100)); ?>...
                                    </p>
                                    <p>
                                        <strong>Available:</strong> 
                                        <span class="badge bg-<?php echo $book['available_copies'] > 0 ? 'success' : 'danger'; ?>">
                                            <?php echo $book['available_copies']; ?> / <?php echo $book['total_copies']; ?>
                                        </span>
                                    </p>
                                    <p>
                                        <strong>Fine:</strong> $<?php echo number_format($book['fine_price'], 2); ?> per day
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <a href="book_details.php?id=<?php echo $book['book_id']; ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-info-circle"></i> View Details
                                    </a>
                                    <?php if ($book['available_copies'] > 0): ?>
                                        <a href="borrow_book.php?book_id=<?php echo $book['book_id']; ?>" 
                                           class="btn btn-success btn-sm"
                                           onclick="return confirm('Are you sure you want to borrow this book?')">
                                            <i class="fas fa-book"></i> Borrow
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-times"></i> Not Available
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
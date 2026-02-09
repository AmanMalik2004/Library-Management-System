<?php
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'models/Book.php';
require_once 'models/BorrowRecord.php';
require_once 'models/Fine.php';
requireLogin();

$pageTitle = 'Dashboard';
$bookModel = new Book();
$borrowModel = new BorrowRecord();
$fineModel = new Fine();
$borrowRecords = $borrowModel->getUserBorrowRecords(getCurrentUserId(), 'borrowed');
$outstandingTotal = $fineModel->getOutstandingFinesTotal(getCurrentUserId());
$activeBorrows = $borrowModel->getActiveBorrowCount(getCurrentUserId());
$borrowLimit = 5;

include 'includes/header.php';
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
            <?php if ($outstandingTotal > 0): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> 
                    You have outstanding fines: <strong>$<?php echo number_format($outstandingTotal, 2); ?></strong>
                    <a href="fines.php" class="btn btn-sm btn-warning ms-2">Pay Now</a>
                </div>
            <?php endif; ?>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-book"></i> Borrowed Books</h5>
                            <h2><?php echo $activeBorrows; ?></h2>
                            <p>Limit: <?php echo $borrowLimit; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-dollar-sign"></i> Outstanding Fines</h5>
                            <h2>$<?php echo number_format($outstandingTotal, 2); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-check-circle"></i> Status</h5>
                            <h2><?php echo ($outstandingTotal > 0) ? 'Restricted' : 'Active'; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <a href="books.php" class="btn btn-primary mb-3"
                       <?php if ($activeBorrows >= $borrowLimit || $outstandingTotal > 0) echo 'disabled title="Cannot borrow more books"'; ?>>
                        Browse Books
                    </a>
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-list"></i> My Borrowed Books</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($borrowRecords)): ?>
                                <p class="text-muted">You have no borrowed books.</p>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Book Title</th>
                                                <th>Borrow Date</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($borrowRecords as $record):
                                                $dueDate = new DateTime($record['due_date']);
                                                $today = new DateTime();
                                                $isOverdue = $dueDate < $today;
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($record['title']); ?></td>
                                                    <td><?php echo date('M d, Y', strtotime($record['borrow_date'])); ?></td>
                                                    <td class="<?php echo $isOverdue ? 'text-danger fw-bold' : ''; ?>">
                                                        <?php echo date('M d, Y', strtotime($record['due_date'])); ?>
                                                        <?php if ($isOverdue): ?>
                                                            <span class="badge bg-danger">Overdue</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info"><?php echo ucfirst($record['status']); ?></span>
                                                    </td>
                                                    <td>
                                                        <a href="return_book.php?record_id=<?php echo $record['record_id']; ?>" 
                                                           class="btn btn-sm btn-success"
                                                           onclick="return confirm('Are you sure you want to return this book?')">
                                                            <i class="fas fa-undo"></i> Return
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<?php
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'models/Fine.php';
requireLogin();

$pageTitle = 'My Fines';
$fineModel = new Fine();
$fines = $fineModel->getUserFines(getCurrentUserId());
$outstandingTotal = $fineModel->getOutstandingFinesTotal(getCurrentUserId());
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

include 'includes/header.php';
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2><i class="fas fa-dollar-sign"></i> My Fines</h2>            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Outstanding Fines Total: 
                        <span class="text-danger fw-bold">$<?php echo number_format($outstandingTotal, 2); ?></span>
                    </h5>
                    <?php if ($outstandingTotal > 0): ?>
                        <p class="text-muted">
                            <i class="fas fa-exclamation-triangle"></i> 
                            You cannot borrow new books until all fines are cleared.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-list"></i> Fine History</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($fines)): ?>
                        <p class="text-muted">You have no fines.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Book Title</th>
                                        <th>Borrow Date</th>
                                        <th>Return Date</th>
                                        <th>Due Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($fines as $fine): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($fine['title']); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($fine['borrow_date'])); ?></td>
                                            <td><?php echo $fine['return_date'] ? date('M d, Y', strtotime($fine['return_date'])) : 'N/A'; ?></td>
                                            <td><?php echo date('M d, Y', strtotime($fine['due_date'])); ?></td>
                                            <td>$<?php echo number_format($fine['amount'], 2); ?></td>
                                            <td>
                                                <?php if ($fine['paid_status']): ?>
                                                    <span class="badge bg-success">Paid</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Unpaid</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!$fine['paid_status']): ?>
                                                    <a href="pay_fine.php?fine_id=<?php echo $fine['fine_id']; ?>" 
                                                       class="btn btn-sm btn-success"
                                                       onclick="return confirm('Are you sure you want to pay this fine?')">
                                                        <i class="fas fa-credit-card"></i> Pay
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Paid on <?php echo date('M d, Y', strtotime($fine['paid_at'])); ?></span>
                                                <?php endif; ?>
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
<?php include 'includes/footer.php'; ?>
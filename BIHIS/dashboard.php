<?php
ob_start();
require_once('includes/load.php');

// Check if user is logged in
if (!$session->isUserLoggedIn(true)) { 
    redirect('index.php', false);
}

$user = current_user();
?>

<?php include_once('layouts/header.php'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <h4>Welcome, <?php echo $user['name'] ?? 'User'; ?>!</h4>
                <p>You have successfully logged in to Barangay Health Inventory System.</p>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quick Stats</h5>
                    <p>Dashboard will show inventory statistics, alerts, and reports here.</p>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
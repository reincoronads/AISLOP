<?php
ob_start();
require_once('includes/load.php');

if($session->isUserLoggedIn(true)) { 
    redirect('dashboard.php', false);
}
?>

<?php include_once('layouts/header.php'); ?>

<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Left Side - Brand/Info Section -->
        <div class="col-md-6 bg-success text-white d-flex align-items-center">
            <div class="p-5">
                <div class="text-center">
                    <i class="fas fa-heartbeat fa-5x mb-4"></i>
                    <h1 class="display-4 fw-bold">Barangay Health Inventory System</h1>
                    <p class="lead mt-4">Managing community health supplies with care and efficiency</p>
                    <div class="mt-5">
                        <div class="row text-center">
                            <div class="col-4">
                                <i class="fas fa-pills fa-2x mb-2"></i>
                                <h5>Medicine Tracking</h5>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-stethoscope fa-2x mb-2"></i>
                                <h5>Equipment Management</h5>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-chart-line fa-2x mb-2"></i>
                                <h5>Real-time Reports</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="col-md-6 d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="p-4">
                            <div class="text-center mb-4">
                                <h2 class="text-success">Welcome Back</h2>
                                <p class="text-muted">Sign in to access the system</p>
                            </div>

                            <?php echo display_msg($msg); ?>

                            <form method="post" action="auth.php" class="mt-4">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" name="username" placeholder="Enter your username" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100 mt-3">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </button>
                            </form>

                            <div class="text-center mt-4">
                                <p class="text-muted">New to the system?</p>
                                <a href="register.php" class="btn btn-outline-success">
                                    <i class="fas fa-user-plus"></i> Register as BHW
                                </a>
                            </div>

                            <div class="text-center mt-4">
                                <small class="text-muted">
                                    By signing in, you agree to our terms of service and privacy policy.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
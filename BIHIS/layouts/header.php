<?php $user = current_user(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if (!empty($page_title))
            echo remove_junk($page_title);
            elseif(!empty($user))
            echo "BHIS - " . ucfirst($user['name']);
            else echo "Barangay Health Inventory System";?>
    </title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link rel="stylesheet" href="/BIHIS/assets/css/main.css">

</head>
<body class="bg-light">
    <?php
$css_path = realpath('../assets/css/main.css');
if ($css_path) {
    echo "<!-- CSS found: " . $css_path . " -->";
} else {
    echo "<!-- CSS NOT FOUND! -->";
}
?>
<?php if ($session->isUserLoggedIn(true)): ?>
    <!-- Header/Navbar with Green Theme -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <!-- Logo/Brand -->
            <a class="navbar-brand fw-bold text-white" href="dashboard.php">
                <i class="fas fa-heartbeat me-2"></i>Barangay Health System
            </a>
            
            <!-- Current Date -->
            <div class="navbar-text text-white me-3 d-none d-lg-block">
                <i class="fas fa-calendar me-1"></i>
                <strong><?php echo date("F j, Y, g:i a");?></strong>
            </div>

            <!-- User Profile Dropdown -->
            <div class="ms-auto">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- User Avatar -->
                            <?php if(!empty($user['image'])): ?>
                                <img src="uploads/users/<?php echo $user['image'];?>" alt="User" class="rounded-circle me-2" width="36" height="36" style="border: 2px solid white;">
                            <?php else: ?>
                                <div class="user-avatar rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                    <i class="fas fa-user-md text-white" style="font-size: 16px;"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="d-flex flex-column text-start">
                                <span class="fw-medium"><?php echo remove_junk(ucfirst($user['name'] ?? 'User')); ?></span>
                                <small class="text-white"><?php echo $user['user_level'] == 1 ? 'Admin' : 'Health Staff'; ?></small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li>
                                <a class="dropdown-item" href="profile.php?id=<?php echo (int)$user['id'];?>">
                                    <i class="fas fa-user me-2 text-success"></i>Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="edit_account.php">
                                    <i class="fas fa-cog me-2 text-success"></i>Settings
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="/BIHIS/logout.php">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Sidebar - WHITE BACKGROUND -->
    <div class="sidebar position-fixed top-0 start-0 h-100 pt-5">
        <div class="sidebar-menu mt-3">
            <?php if($user['user_level'] === '1'): ?>
                <!-- Admin menu -->
                <?php include_once('admin_menu.php');?>
            <?php elseif($user['user_level'] === '2'): ?>
                <!-- Health Staff menu -->
                <?php include_once('health_staff_menu.php');?>
            <?php endif;?>
        </div>
    </div>
<?php endif;?>

<!-- Main Content -->
<div class="page-content p-4">
    <div class="container-fluid">
<?php
ob_start();
require_once('includes/load.php');

$session->msg('d','Please login...');

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if(empty($username) || empty($password)) {
        $session->msg('d', "Username and password cannot be blank");
        redirect('index.php', false);
    }
    
    // Use the authenticate function from sql.php
    $user_id = authenticate($username, $password);
    
    if($user_id) {
        // Login successful
        $session->login($user_id);
        updateLastLogIn($user_id);
        
        $session->msg('s', "Welcome to Barangay Health System!");
        redirect('dashboard.php', true);
    } else {
        // Login failed
        $session->msg('d', "Sorry, Username/Password incorrect.");
        redirect('index.php', false);
    }
} else {
    $session->msg('d', "Please enter username and password.");
    redirect('index.php', false);
}
?>
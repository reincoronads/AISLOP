<?php
ob_start();
require_once('includes/load.php');

$session->logout();
$session->msg('s', "You have been logged out.");
redirect('index.php', false);
?>
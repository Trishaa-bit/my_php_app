<?php include 'config.php'; ?>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please <a href='login.php'>login</a>.");
}
echo "Welcome to your dashboard!";
?>
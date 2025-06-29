<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
echo "<h1>Welcome, Admin " . htmlspecialchars($_SESSION['username']) . "</h1>";
?>
<a href="logout.php">Logout</a>

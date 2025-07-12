<?php
// delete_post.php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$post_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Check if post exists and belongs to user or admin
$stmt = $conn->prepare("SELECT user_id FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Post not found.";
    exit();
}

$post = $result->fetch_assoc();

if ($role !== 'admin' && $post['user_id'] != $user_id) {
    echo "Access denied.";
    exit();
}

// Proceed to delete
$delete = $conn->prepare("DELETE FROM posts WHERE id = ?");
$delete->bind_param("i", $post_id);
$delete->execute();

header("Location: " . ($role === 'admin' ? 'admin_dashboard.php' : 'user_dashboard.php'));
exit();

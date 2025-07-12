<?php
// edit_post.php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$post_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Fetch the post and validate ownership or admin
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    echo "Post not found.";
    exit();
}

if ($role !== 'admin' && $post['user_id'] != $user_id) {
    echo "Access denied.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $update = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $update->bind_param("ssi", $title, $content, $post_id);
    $update->execute();

    header("Location: " . ($role === 'admin' ? 'admin_dashboard.php' : 'user_dashboard.php'));
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <style>
        body { font-family: Arial; background-color: #f5f5f5; padding: 40px; }
        .form-container { max-width: 600px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        input, textarea, button { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
        button { background-color: #007BFF; color: white; font-weight: bold; border: none; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Post</h2>
        <form method="POST">
            <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
            <textarea name="content" required><?= htmlspecialchars($post['content']) ?></textarea>
            <button type="submit">Update Post</button>
        </form>
    </div>
</body>
</html>

<?php
// admin_dashboard.php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch all posts
$result = $conn->query("SELECT posts.id, posts.title, posts.content, posts.created_at, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial; background: #eef2f7; padding: 30px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h2 { text-align: center; }
        .logout {
            text-align: right;
            margin-bottom: 15px;
        }
        .logout a {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #007BFF; color: white; }
        .actions a { margin-right: 10px; color: #007BFF; text-decoration: none; font-weight: bold; }
        .actions a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">
    <div class="logout">
        <a href="login.php">🔓 Logout</a>
    </div>
    <h2>👮‍♂️ Admin Dashboard - Welcome, <?= htmlspecialchars($username) ?></h2>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Author</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= nl2br(htmlspecialchars(substr($row['content'], 0, 100))) ?>...</td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
                    <td class="actions">
                        <a href="edit_post.php?id=<?= $row['id'] ?>">Edit</a>
                        <a href="delete_post.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this post?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Blog Posts</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            padding: 30px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        .post {
            border-left: 4px solid #007BFF;
            padding: 15px 20px;
            margin-bottom: 20px;
            background: #fdfdfd;
        }
        .post h3 {
            margin: 0 0 8px;
            color: #333;
        }
        .post p {
            margin: 0;
            color: #555;
        }
        .meta {
            margin-top: 10px;
            font-size: 14px;
            color: #888;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📚 All Blog Posts</h2>

    <?php
    $stmt = $conn->prepare("SELECT posts.title, posts.content, posts.created_at, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='post'>
                    <h3>" . htmlspecialchars($row['title']) . "</h3>
                    <p>" . nl2br(htmlspecialchars($row['content'])) . "</p>
                    <div class='meta'>✍️ By <strong>" . htmlspecialchars($row['username']) . "</strong> on " . date("d M Y", strtotime($row['created_at'])) . "</div>
                </div>";
        }
    } else {
        echo "<p>No posts available yet.</p>";
    }
    ?>

    <a href='user_dashboard.php' class='back-link'>← Back to Dashboard</a>
</div>
</body>
</html>

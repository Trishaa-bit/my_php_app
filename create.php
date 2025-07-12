<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $content, $user_id);

    if ($stmt->execute()) {
        header("Location: user_dashboard.php"); // Redirect to dashboard
        exit();
    } else {
        $error = "❌ Failed to create post.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #f2f2f2, #dce9f9);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 480px;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background: #fdfdfd;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        button {
            width: 100%;
            background: linear-gradient(to right, #007BFF, #00c6ff);
            color: white;
            border: none;
            padding: 14px;
            font-size: 17px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: linear-gradient(to right, #0056b3, #0083cc);
        }

        .message {
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
            color: red;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="card">
    <h2>📝 Create New Post</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Enter post title" required>
        <textarea name="content" placeholder="Write your post here..." required></textarea>
        <button type="submit" name="submit">Publish</button>
    </form>

    <?php if (isset($error)) echo "<div class='message'>$error</div>"; ?>

    <a href="user_dashboard.php" class="back-link">← Back to Dashboard</a>
</div>
</body>
</html>

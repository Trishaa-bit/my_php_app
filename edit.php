<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #e0e0e0;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            padding: 40px;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
            width: 550px;
            max-width: 90%;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        h2 {
            font-family: 'Fira Code', monospace;
            text-align: center;
            margin-bottom: 25px;
            color: #7CFC00;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-family: 'Fira Code', monospace;
            background: rgba(255, 255, 255, 0.07);
            color: #fff;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        input:focus,
        textarea:focus {
            outline: 2px solid #7CFC00;
        }

        button {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            background: linear-gradient(135deg, #ff00cc, #333399);
            color: white;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 15px rgba(255, 0, 204, 0.4);
        }

        .message {
            text-align: center;
            font-size: 16px;
            color: #7CFC00;
            margin-top: 20px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #9CDCFE;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="card">
    <?php 
    $id = $_GET['id'];
    if (isset($_POST['update'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];

        $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $content, $id);
        $stmt->execute();

        echo "<p class='message'>✅ Post updated successfully! <a class='back-link' href='index.php'>Go back</a></p>";
    } else {
        $stmt = $conn->prepare("SELECT * FROM posts WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
    ?>
        <h2>💻 Edit Your Post</h2>
        <form method="POST">
            <input type="text" name="title" value="<?= htmlspecialchars($result['title']) ?>" required>
            <textarea name="content" required><?= htmlspecialchars($result['content']) ?></textarea>
            <button type="submit" name="update">🚀 Update Post</button>
        </form>
        <a href="index.php" class="back-link">← Cancel</a>
    <?php } ?>
</div>

</body>
</html>

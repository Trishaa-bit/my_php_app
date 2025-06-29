<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Post</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://png.pngtree.com/background/20210715/original/pngtree-colourful-background-for-business-social-media-post-free-vector-instagram-and-picture-image_1294714.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            padding: 35px 45px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 500px;
            max-width: 90%;
            backdrop-filter: blur(5px);
        }

        h2 {
            font-family: 'Playfair Display', serif;
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
            font-size: 28px;
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
            font-family: 'Poppins', sans-serif;
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
            transition: background 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        button:hover {
            background: linear-gradient(to right, #0056b3, #0083cc);
        }

        .success {
            margin-top: 15px;
            text-align: center;
            color: #27ae60;
            font-weight: bold;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
            font-family: 'Poppins', sans-serif;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>📝 Add New Post</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Enter title" required>
        <textarea name="content" placeholder="Write your content here..." required></textarea>
        <button type="submit" name="submit">Publish Post</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];

        $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();

        echo "<p class='success'>✅ Post added successfully!</p>";
    }
    ?>

    <a href="index.php" class="back-link">← Back to Posts</a>
</div>

</body>
</html>

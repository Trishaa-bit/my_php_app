<?php
include 'config.php';

$results = [];

if (isset($_GET['query'])) {
    $query = "%" . $_GET['query'] . "%";
    $stmt = $conn->prepare("SELECT * FROM posts WHERE title LIKE ? OR content LIKE ?");
    $stmt->bind_param("ss", $query, $query);
    $stmt->execute();
    $results = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Blog Posts</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .search-box {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .search-box input[type="text"] {
            width: 60%;
            padding: 10px 15px;
            font-size: 16px;
            border: 2px solid #007BFF;
            border-radius: 5px 0 0 5px;
            outline: none;
        }

        .search-box button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #007BFF;
            color: #fff;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-box button:hover {
            background-color: #0056b3;
        }

        .results h3 {
            margin-top: 0;
            color: #444;
        }

        .post {
            background-color: #f9f9f9;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 5px solid #007BFF;
            border-radius: 5px;
            transition: background 0.2s;
        }

        .post:hover {
            background-color: #f1f7ff;
        }

        .post h4 {
            margin-top: 0;
            color: #007BFF;
        }

        .post p {
            color: #333;
            font-size: 15px;
        }

        em {
            background: #fff3cd;
            padding: 2px 5px;
            border-radius: 3px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🔍 Search Blog Posts</h2>

    <form method="GET" action="search.php" class="search-box">
        <input type="text" name="query" placeholder="Search by title or content..." required>
        <button type="submit">Search</button>
    </form>

    <div class="results">
        <?php if (isset($_GET['query'])): ?>
            <h3>Results for: <em><?= htmlspecialchars($_GET['query']) ?></em></h3>

            <?php if ($results->num_rows > 0): ?>
                <?php while ($row = $results->fetch_assoc()): ?>
                    <div class="post">
                        <h4><?= htmlspecialchars($row['title']) ?></h4>
                        <p><?= nl2br(htmlspecialchars(substr($row['content'], 0, 200))) ?>...</p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No posts found matching your search.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

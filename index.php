<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('https://www.hostinger.com/tutorials/wp-content/uploads/sites/2/2021/09/how-to-write-a-blog-post.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .add-button {
            display: inline-block;
            background: #007BFF;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .add-button:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 14px 16px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            color: #444;
        }

        tr:hover {
            background-color: #f1f9ff;
        }

        .actions a {
            color: #007BFF;
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .no-posts {
            text-align: center;
            color: #999;
            padding: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <body>

<!-- Search Button -->
<a href="search.php" style="
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 15px;
    background-color: #ffc107;
    color: black;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
">
    🔍 Search Posts
</a>
<div class="container">
    <h2>📋 All Blog Posts</h2>
    <body>
    <!-- Add the View All Posts button -->
    <a href="posts.php" style="
        display: inline-block;
        margin-top: 20px;
        padding: 10px 15px;
        background-color: #007BFF;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    ">
        📚 View All Posts
    </a>

    <a href="create.php" class="add-button">+ Add New Post</a>

    <table>
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Actions</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row['title']) . "</td>
                    <td>" . htmlspecialchars(substr($row['content'], 0, 100)) . "...</td>
                    <td class='actions'>
                        <a href='edit.php?id={$row['id']}'>Edit</a>
                        <a href='delete.php?id={$row['id']}' onclick=\"return confirm('Delete this post?')\">Delete</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='3' class='no-posts'>No posts found.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>

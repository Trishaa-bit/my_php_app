<?php
include 'config.php'; // Database connection

// Number of posts per page
$limit = 5;

// Get current page number from URL, default is 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate the offset
$offset = ($page - 1) * $limit;

// Fetch total number of posts
$totalResult = $conn->query("SELECT COUNT(*) as total FROM posts");
$totalRow = $totalResult->fetch_assoc();
$totalPosts = $totalRow['total'];
$totalPages = ceil($totalPosts / $limit);

// Fetch posts for the current page
$stmt = $conn->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$posts = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Posts Listing</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .post {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #007BFF;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            display: inline-block;
            padding: 6px 12px;
            margin-right: 5px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
        }
        .pagination a.active {
            background-color: #0056b3;
        }
        .pagination a.disabled {
            background-color: #cccccc;
            pointer-events: none;
        }
    </style>
</head>
<body>

<h2>All Blog Posts</h2>
<a href="index.php" style="
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 15px;
    background-color: #28a745;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
">
    ← Back to Home
</a>

<?php while ($row = $posts->fetch_assoc()): ?>
    <div class="post">
        <h3><?= htmlspecialchars($row['title']) ?></h3>
        <p><?= nl2br(htmlspecialchars(substr($row['content'], 0, 200))) ?>...</p>
        <small>Posted on <?= date("d M Y", strtotime($row['created_at'])) ?></small>
    </div>
<?php endwhile; ?>

<!-- Pagination -->
<div class="pagination">
    <!-- Previous link -->
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>">« Prev</a>
    <?php else: ?>
        <a class="disabled">« Prev</a>
    <?php endif; ?>

    <!-- Page numbers -->
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>

    <!-- Next link -->
    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>">Next »</a>
    <?php else: ?>
        <a class="disabled">Next »</a>
    <?php endif; ?>
</div>

</body>
</html>

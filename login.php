<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashedPassword, $role);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            header("Location: " . ($role === 'admin' ? "admin_dashboard.php" : "user_dashboard.php"));
            exit();
        } else {
            $error = "❌ Invalid password.";
        }
    } else {
        $error = "❌ Username not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <style>
    body { font-family: Arial;background-image:url("https://videocdn.cdnpk.net/videos/f22834dc-bf51-5b2e-9c12-4f30975bafb2/vertical/thumbnails/small.jpg?semt=ais_hybrid&item_id=3358572"); padding: 50px; }
    .container { max-width: 400px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #aaa;opacity: 0.8; }
    input, button { width: 100%; padding: 10px; margin: 8px 0; }
    a { text-decoration: none; color: #007bff; }
    h2 { text-align: center; }
  </style>
</head>
<body>
<div class="container">
  <h2>Login Page</h2>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="POST">
    <label>Username</label>
    <input name="username" required placeholder="Enter your username" minlength="3" pattern="[A-Za-z0-9_]+">
    
    <label>Password</label>
    <input type="password" name="password" required placeholder="Enter your password" minlength="4">
    
    <button type="submit">Login</button>
  </form>
  <p>Don't have an account? <a href="registeration.php">Register</a></p>
</div>
</body>
</html>

<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user';

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "❌ Registration failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register Page</title>
  <style>
    body { font-family: Arial; background:rgb(141, 139, 189); padding: 50px; }
    .container { max-width: 400px; margin: auto; background: white;background-image: url("https://img.freepik.com/premium-photo/aqua-blue-paper-texture-background_118047-20906.jpg?semt=ais_hybrid&w=740"); padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #aaa; }
    input, button { width: 100%;background-image: url("https://htmlcolorcodes.com/assets/images/html-color-codes-color-tutorials-hero.jpg"); padding: 10px; margin: 8px 0; }
    a { text-decoration: none; color:rgb(255, 255, 255); }
    h2 { text-align: center; }
    
  </style>
</head>
<body>
<div class="container">
  <h2>Register Page</h2>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="POST">
    <label>Username</label>
    <input name="username" required placeholder="Choose a username" minlength="3" pattern="[A-Za-z0-9_]+">
    
    <label>Password</label>
    <input type="password" name="password" required placeholder="Create a password" minlength="4">
    
    <button type="submit">Register</button>
  </form>
  <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>

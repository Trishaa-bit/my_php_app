<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Default role is 'user'
    $role = 'user';

    // Insert username, hashed password, and role
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        echo "✅ User registered successfully!";
    } else {
        echo "❌ Registration failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<form method="POST">
  <input name="username" required placeholder="Username">
  <input type="password" name="password" required placeholder="Password">
  <button type="submit">Register</button>
</form>

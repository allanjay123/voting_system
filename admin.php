<?php
session_start();
include "../config/db.php"; // connection same sa mga ibang pages

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {

        $stmt = $conn->prepare("SELECT id, fullname, username, password, role FROM users WHERE username = ? AND role = 'admin'");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            // check hashed password
            if (password_verify($password, $admin['password'])) {

                session_regenerate_id(true);

                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['fullname'] = $admin['fullname'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['role'] = $admin['role'];

                // redirect to existing dashboard (from docs)
                header("Location: ../admin/dashboard.php");
                exit();

            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Admin account not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body { font-family: Arial; background:#f4f6f9; display:flex; justify-content:center; align-items:center; height:100vh; }
        .login-box { background:#fff; padding:30px; width:350px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,.1); }
        h2 { text-align:center; margin-bottom:20px; }
        input { width:100%; padding:10px; margin:8px 0; }
        button { width:100%; padding:10px; background:#0b6623; color:white; border:none; cursor:pointer; font-weight:bold; }
        .error { color:red; text-align:center; margin-bottom:10px; }
        .back { display:block; text-align:center; margin-top:10px; text-decoration:none; color:#333; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Admin Login</h2>
    <?php if(!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Admin Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login as Admin</button>
    </form>
    <a class="back" href="login.php">← Back to Student Login</a>
</div>
</body>
</html>

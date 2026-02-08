<?php
session_start();
require_once "../config/db.php";
require_once "../lib/audit.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']); // student id
    $password = trim($_POST['password']); // student id din

    if ($username == "" || $password == "") {
        $error = "Please enter your Student ID and password.";
    } else {

        // Check if user exists (by username / student id)
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // EXISTING USER
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['fullname']  = $user['fullname'];
                $_SESSION['role']      = $user['role'] ?? 'student';

                audit_log(
                    $conn,
                    (int)$user['id'],
                    "Login",
                    "User: {$user['fullname']} (username: {$username}) | " . audit_client_details()
                );

                if ($_SESSION['role'] === 'admin') {
                    header("Location: ../admin/dashboard.php");
                } else {
                    header("Location: ../voter/vote.php");
                }
                exit();
            } else {
                $error = "Invalid password.";
            }

        } else {
            if ($fullname == "") {
                $error = "Full Name is required for first-time registration.";
            } else {
            // AUTO REGISTER STUDENT
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare(
                "INSERT INTO users (fullname, username, password, role)
                 VALUES (?, ?, ?, 'student')"
            );
            $insert->bind_param("sss", $fullname, $username, $hashed);
            $insert->execute();

            $_SESSION['user_id']   = $insert->insert_id;
            $_SESSION['fullname']  = $fullname;
            $_SESSION['role']      = 'student';

            audit_log(
                $conn,
                (int)$insert->insert_id,
                "Register+Login",
                "User: {$fullname} (username: {$username}) | auto-registered as student | " . audit_client_details()
            );

            header("Location: ../voter/vote.php");
            exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ISU Login</title>

<style>
body {
    margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    background: #f4f6f5;
}

.header {
    background: #0b6623;
    color: #fff;
    text-align: center;
    padding: 30px;
}

.container {
    max-width: 420px;
    margin: 60px auto;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}

h2 {
    text-align: center;
    color: #0b6623;
}

input {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border-radius: 8px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 14px;
    background: #f1b400;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: bold;
    color: #0b6623;
    cursor: pointer;
}

button:hover {
    background: #d9a200;
}

.error {
    text-align: center;
    color: red;
    font-weight: bold;
}
</style>
</head>

<body>

<div class="header">
    <h1>ISU Online Voting System</h1>
</div>

<div class="container">
    <h2>Student Login</h2>

    <?php if($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="fullname" placeholder="Full Name (first-time only)">
        <input type="text" name="username" placeholder="Student ID" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>

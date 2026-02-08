<?php
require_once "admin_check.php";

include("../config/db.php");

// ADD POSITION
if (isset($_POST['add'])) {
    $position = $_POST['position'];
    mysqli_query($conn, "INSERT INTO positions (position_name) VALUES ('$position')");
    header("Location: manage_positions.php");
    exit();
}

// DELETE POSITION
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM positions WHERE id=$id");
    header("Location: manage_positions.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM positions");
?>
<!DOCTYPE html>
<html>
<head>
<title>ISU | Manage Positions</title>

<style>
body {
    margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    background: #f4f6f5;
}

/* HEADER */
.header {
    background: #0b6623;
    color: white;
    padding: 20px;
    text-align: center;
}

/* CONTAINER */
.container {
    max-width: 900px;
    margin: 30px auto;
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 12px rgba(0,0,0,0.1);
}

/* FORM */
form {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

input[type=text] {
    flex: 1;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

button {
    background: #0b6623;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    background: #094d1b;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #f1b400;
    padding: 12px;
}

td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
}

tr:hover {
    background: #f9f9f9;
}

/* BUTTONS */
.delete {
    background: #b00020;
    color: white;
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
}

.delete:hover {
    opacity: 0.85;
}

/* BACK */
.back {
    display: inline-block;
    margin-top: 20px;
    color: #0b6623;
    font-weight: bold;
    text-decoration: none;
}
</style>
</head>

<body>

<div class="header">
    <h1>ISU Manage Positions</h1>
</div>

<div class="container">

    <form method="POST">
        <input type="text" name="position" placeholder="Enter position name" required>
        <button name="add">Add Position</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Position Name</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['position_name']; ?></td>
            <td>
                <a class="delete" href="?delete=<?= $row['id']; ?>" onclick="return confirm('Delete this position?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a class="back" href="dashboard.php">← Back to Dashboard</a>

</div>

</body>
</html>
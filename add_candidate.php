<?php
require_once "admin_check.php";

include("../config/db.php");

$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = trim($_POST['name']);
    $position_id = $_POST['position_id'];

    // Handle photo upload
    $photo = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    if (!empty($photo)) {
        if (!is_dir("../uploads")) mkdir("../uploads"); // create folder if not exist
        move_uploaded_file($tmp, "../uploads/".$photo);
    } else {
        $photo = "default.png"; // fallback image
    }

    // Insert candidate
    $stmt = $conn->prepare("INSERT INTO candidates (name, position_id, photo) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $position_id, $photo);

    if ($stmt->execute()) {
        header("Location: view_candidates.php");
        exit();
    } else {
        $error = "Error saving candidate: ".$stmt->error;
    }
}

// Fetch positions
$positions = mysqli_query($conn, "SELECT * FROM positions");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ISU | Add Candidate</title>
<style>
body { margin:0; font-family:Arial,sans-serif; background:#f4f6f5; }
.header { background:#0b6623; color:#fff; padding:20px; text-align:center; }
.header h1 { margin:0; }
.container { max-width:600px; margin:30px auto; background:#fff; padding:25px; border-radius:10px; box-shadow:0 5px 12px rgba(0,0,0,0.1); }
form { display:flex; flex-direction:column; }
input, select { padding:10px; margin-bottom:15px; border-radius:6px; border:1px solid #ccc; }
button { background:#0b6623; color:#fff; padding:12px; border:none; border-radius:6px; font-weight:bold; cursor:pointer; }
button:hover { opacity:0.9; }
.error { color:red; margin-bottom:15px; }
.back { display:inline-block; margin-top:10px; text-decoration:none; color:#0b6623; font-weight:bold; }
</style>
</head>
<body>

<div class="header"><h1>Add Candidate</h1></div>

<div class="container">

<?php if($error) echo "<div class='error'>$error</div>"; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Candidate Name" required>
    <select name="position_id" required>
        <option value="">Select Position</option>
        <?php while($pos = mysqli_fetch_assoc($positions)): ?>
            <option value="<?= $pos['id']; ?>"><?= $pos['position_name']; ?></option>
        <?php endwhile; ?>
    </select>
    <input type="file" name="photo" accept="image/*" required>
    <button type="submit">Save Candidate</button>
</form>

<a href="view_candidates.php" class="back">← Back to Candidates</a>

</div>
</body>
</html>
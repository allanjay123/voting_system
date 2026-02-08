<?php
require_once "admin_check.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ISU | Admin Dashboard</title>

<style>
    body {
        margin: 0;
        font-family: "Segoe UI", Arial, sans-serif;
        background: #f4f6f5;
    }

    /* HEADER */
    .header {
        background: #0b6623; /* ISU green */
        color: #fff;
        padding: 20px;
    }

    .header-content {
        max-width: 1200px;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-center {
        text-align: center;
        flex: 1;
    }

    .header h1 {
        margin: 0;
        font-size: 28px;
    }

    .header p {
        margin: 5px 0 0;
        font-size: 14px;
        opacity: 0.9;
    }

    .logo {
        width: 70px;
        height: auto;
    }

    /* CONTAINER */
    .container {
        padding: 30px;
        max-width: 1100px;
        margin: auto;
    }

    /* GRID */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    /* CARD */
    .card {
        background: #fff;
        border-radius: 10px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: 0.3s;
        border-top: 6px solid #f1b400; /* ISU gold */
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 18px rgba(0,0,0,0.15);
    }

    .card h3 {
        margin: 15px 0 10px;
        color: #0b6623;
    }

    .card p {
        font-size: 14px;
        color: #555;
    }

    /* LOGOUT */
    .logout {
        text-align: center;
        margin-top: 40px;
    }

    .logout a {
        text-decoration: none;
        background: #b00020;
        color: #fff;
        padding: 10px 25px;
        border-radius: 6px;
        font-weight: bold;
    }

    .logout a:hover {
        opacity: 0.9;
    }
</style>
</head>

<body>

<!-- HEADER WITH LOGOS -->
<div class="header">
    <div class="header-content">
        
        
        <!-- CENTER TEXT -->
        <div class="header-center">
            <h1>CCSICT Online Voting System</h1>
            <p>Administrator Dashboard</p>
        </div>
        
        
    </div>
</div>

<!-- CONTENT -->
<div class="container">

    <div class="grid">

        <div class="card" onclick="location.href='view_candidates.php'">
            <h3>👤 Manage Candidates</h3>
            <p>Add, edit and manage candidates</p>
        </div>

        <div class="card" onclick="location.href='manage_positions.php'">
            <h3>🏷 Manage Positions</h3>
            <p>Create positions (President, VP, etc.)</p>
        </div>

        <div class="card" onclick="location.href='../voter/vote.php'">
            <h3>🗳 Voting Page</h3>
            <p>Student voting interface</p>
        </div>

        <div class="card" onclick="location.href='election_settings.php'">
            <h3>⏱ Election Control</h3>
            <p>Start / End voting automatically</p>
        </div>

        <div class="card" onclick="location.href='view_results.php'">
            <h3>📊 Election Results</h3>
            <p>Real-time tally & bar graph</p>
        </div>

        <div class="card" onclick="location.href='audit_logs.php'">
            <h3>📋 Audit & Logs</h3>
            <p>System activity logs (login/voting/etc.)</p>
        </div>

        <div class="card" onclick="location.href='users.php'">
            <h3>👥 All Users</h3>
            <p>View registered users & voting status</p>
        </div>

        <div class="card" onclick="location.href='votes.php'">
            <h3>🧾 All Votes</h3>
            <p>View votes per position/candidate</p>
        </div>
        

    </div>

    <div class="logout">
        <a href="../auth/logout.php">Logout</a>
    </div>

</div>

</body>
</html>

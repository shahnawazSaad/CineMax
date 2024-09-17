<?php 
include 'TopBar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Complaints</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        #main {
            flex: 1;
        }

        body {
            background-color: #1a202c;
            background-image: url('dark.jpg'); 
            font-family: 'Roboto', sans-serif;
            color: #f7fafc;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            text-align: center;
            margin: 20px 0;
            font-size: 36px;
            font-weight: bold;
        }
        .content-container {
            margin: 50px 0;
            display: flex;
            flex-direction: column;
            align-items: center;

        }
        .content-section {
            width: 80%;
            background: rgba(45, 55, 72, 0.8);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .content-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            background: rgba(0, 0, 0, 0.6);
        }
        th, td {
            padding: 10px;
            text-align: left;
            color: white;
            border: none;
        }
        th {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.9);
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 22px;
            color: white;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .sidebar .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 15px;
            border: none;
            position: fixed;
            top: 15px;
            left: 15px;
        }
        .openbtn:hover {
            background-color: rgba(0, 0, 0, 0.9);
        }
    </style>
</head>
<body>
    <?php include 'conn.php'; ?>

    <?php 
$adminid=1;
?>

<div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <a href="admin_dashboard.php">Admin Dashboard</a>
        <a href="Delete_movies.php">Delete Movies</a>
        <a href="Add_New_movies.php">Add New Movies</a>
        <a href="Admin_Schedule.php">Movie Schedule</a>
        <a href="Admin_feedback.php">Feedback</a>
        <a href="./Testhome.php?adminid=<?php echo $adminid; ?>">Observe UI</a>
    </div>
<button class="openbtn" onclick="openNav()">☰ Open Sidebar</button>

    <div id="main">
        <div class="header">User Complaints</div>

        <div class="content-container">
            <div class="content-section">
                <?php
                // Query to get all user complaints
                $complaint_query = "SELECT UserID, UserName, Email, Complaint FROM User WHERE Complaint IS NOT NULL AND Complaint != ''";
                $complaint_result = $conn->query($complaint_query);

                if ($complaint_result->num_rows > 0) {
                    echo "<table><tr><th>UserID</th><th>UserName</th><th>Email</th><th>Complaint</th></tr>";
                    while ($row = $complaint_result->fetch_assoc()) {
                        echo "<tr><td>".$row["UserID"]."</td><td>".$row["UserName"]."</td><td>".$row["Email"]."</td><td>".$row["Complaint"]."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No complaints found.";
                }
                ?>
            </div>
        </div>
    </div>

    <?php  
include 'Footer.php';?>

    <script>
        // For open and close the sidebar
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
        }
    </script>
</body>
</html>

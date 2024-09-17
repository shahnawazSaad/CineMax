<?php 
include 'TopBar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a202c;
            background-image: url('dark.jpg'); 
            font-family: 'Roboto', sans-serif;
            color: #f7fafc;
            margin: 0;
            padding: 0;
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
        #main {
            transition: margin-left .5s;
            padding: 16px;
        }
        .header {
            text-align: center;
            margin: 20px 0;
            font-size: 36px;
            font-weight: bold;
        }
        .centered-section {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            margin-top: 50px;
        }
        .info-box {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            margin: 10px;
            text-align: center;
            width: 300px;
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
        td img {
            display: block;
            max-width: 100%;
            height: auto;
        }
        .poster {
            max-width: 100px;
            max-height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include 'conn.php'; ?>
    <?php


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['movieId'])) {

    $movieId = $_POST['movieId'];


    $query = "DELETE from Movies where movieid=$movieId";
    if ($conn->query($query) === TRUE) {

    } else {
        echo "Error: " . $query . "<br>" . $conn->error;

    }
}
?>

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
        <div class="header">Delete Movies</div>

        <div class="content-container">
            <div class="content-section">
                <h2>Movie Information</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to DELETE the Movie?')">
                <?php
                // Query to get all movie information
                $movie_info_query = "SELECT * FROM Movies";
                $movie_info_result = $conn->query($movie_info_query);

                if ($movie_info_result->num_rows > 0) {
                    
                    echo "<table><tr><th>Poster</th><th>MovieID</th><th>MovieName</th><th>Cast</th><th>Language</th><th>ReleaseDate</th><th>Genre</th><th>Schedule</th><th>Delete</th></tr>";
                    while ($row = $movie_info_result->fetch_assoc()) {
                        $movieId =$row['MovieID'];
                        $poster = base64_encode($row["Poster"]);
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mimeType = finfo_buffer($finfo, $row["Poster"]);
                        finfo_close($finfo);
                        // echo'<form method="post" action="'. htmlspecialchars($_SERVER["PHP_SELF"]).'" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to ADD the Movie?')">';
                        // echo'<tr><td><input type="hidden" name="movieId" value="'. $movieId.'"></td>';
                        echo'<tr><td><img src="data:' . $mimeType . ';base64,' . $poster . '" class="poster"></td>';
                        echo "<td>".$row["MovieID"]."</td><td>".$row["MovieName"]."</td><td>".$row["Cast"]."</td><td>".$row["Language"]."</td><td>".$row["ReleaseDate"]."</td><td>".$row["Genre"]."</td><td>".$row["Schedule"]."</td>";
                        echo'<td><button type="submit" name="movieId" value="'. $movieId.'" class="btn btn-primary" style="background-color: transparent; border: 1px solid #ffffff;">❌</button></td></tr>';
                        // echo'</form>';
                    }
                    echo "</table>";
                } else {
                    echo "No movies found.";
                }
                ?>
                </form>
            </div>
        </div>
    </div>




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
    <?php  
include 'Footer.php';?>
</body>
</html>

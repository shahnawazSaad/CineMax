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
    // Query to get the total number of users
    $user_count_query = "SELECT COUNT(UserID) as total_users FROM User";
    $user_count_result = $conn->query($user_count_query);
    $total_users = 0;
    if ($user_count_result->num_rows > 0) {
        $row = $user_count_result->fetch_assoc();
        $total_users = $row['total_users'];
    }

    // Query to get the total number of movies
    $movie_count_query = "SELECT COUNT(MovieID) as total_movies FROM Movies";
    $movie_count_result = $conn->query($movie_count_query);
    $total_movies = 0;
    if ($movie_count_result->num_rows > 0) {
        $row = $movie_count_result->fetch_assoc();
        $total_movies = $row['total_movies'];
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
        <div class="header">Welcome to Admin Dashboard</div>

        <div class="centered-section">
            <div class="info-box">
                <h2>Total Users</h2>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="info-box">
                <h2>Total Movies</h2>
                <p><?php echo $total_movies; ?></p>
            </div>
        </div>

        <div class="content-container">
            <div class="content-section">
                <h2>User Information</h2>
                <?php
                // Query to get all user information except passwords and tickets
                $user_info_query = "SELECT UserID, Name, UserName, Email, Phone FROM User";
                $user_info_result = $conn->query($user_info_query);

                if ($user_info_result->num_rows > 0) {
                    echo "<table><tr><th>UserID</th><th>Name</th><th>UserName</th><th>Email</th><th>Phone</th></tr>";
                    while ($row = $user_info_result->fetch_assoc()) {
                        echo "<tr><td>".$row["UserID"]."</td><td>".$row["Name"]."</td><td>".$row["UserName"]."</td><td>".$row["Email"]."</td><td>".$row["Phone"]."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No users found.";
                }
                ?>
            </div>

            <div class="content-section">
                <h2>Movie Information</h2>
                <?php
                // Query to get all movie information
                $movie_info_query = "SELECT * FROM Movies";
                $movie_info_result = $conn->query($movie_info_query);

                if ($movie_info_result->num_rows > 0) {
                    
                    echo "<table><tr><th>Poster</th><th>MovieID</th><th>MovieName</th><th>Cast</th><th>Language</th><th>ReleaseDate</th><th>Genre</th><th>Schedule</th></tr>";
                    while ($row_movie = $movie_info_result->fetch_assoc()) {

                        $poster = base64_encode($row_movie["Poster"]);
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mimeType = finfo_buffer($finfo, $row_movie["Poster"]);
                        finfo_close($finfo);
                        echo'<tr><td><img src="data:' . $mimeType . ';base64,' . $poster . '" class="poster"></td>';
                        echo "<td>".$row_movie["MovieID"]."</td><td>".$row_movie["MovieName"]."</td><td>".$row_movie["Cast"]."</td><td>".$row_movie["Language"]."</td><td>".$row_movie["ReleaseDate"]."</td><td>".$row_movie["Genre"]."</td><td>".$row_movie["Schedule"]."</td></tr>"; 
                    }
                    echo "</table>";
                } else {
                    echo "No movies found.";
                }
                ?>
            </div>

            <div class="content-section">
                <h2>Booking Information</h2>
                <?php
                // Query to get all booking information
                $booking_info_query = "SELECT * FROM Booking";
                $booking_info_result = $conn->query($booking_info_query);

                if ($booking_info_result->num_rows > 0) {
                    echo "<table><tr><th>Poster</th><th>MovieID</th><th>BookingID</th><th>UserID</th><th>Theater</th><th>Date</th><th>Showtime</th><th>Tickets</th><th>Price</th></tr>";
                    while ($row_booking = $booking_info_result->fetch_assoc()) {


                        $movie_info_query = "SELECT * FROM Movies WHERE movieid = " . $row_booking['MovieID'];
                        $movie_info_result = $conn->query($movie_info_query);
        
                        if ($movie_info_result->num_rows > 0) {
                            
                            while ($row_movie = $movie_info_result->fetch_assoc()) {
        
                                $poster = base64_encode($row_movie["Poster"]);
                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                $mimeType = finfo_buffer($finfo, $row_movie["Poster"]);
                                finfo_close($finfo);



                        echo'<tr><td><img src="data:' . $mimeType . ';base64,' . $poster . '" class="poster"></td>';
                        echo "<td>".$row_booking['MovieID']."</td><td>".$row_booking['BookingId']."</td><td>".$row_booking['UserID']."</td><td>".$row_booking['Theater']."</td><td>".$row_booking['date']."</td><td>".$row_booking['Showtime']."</td><td>".$row_booking['Tickets']."</td><td>".$row_booking['Price']."</td></tr>";


                        }
                      } 
                    }
                    echo "</table>";
                } else {
                    echo "No bookings found.";
                }
                ?>
            </div>

            <div class="content-section">
                <h2>Movie Schedule</h2>
                <?php

                // Query to get all Movie Schedule
                $moviedetails_info_query = "SELECT * FROM moviedetails";
                $moviedetails_info_result = $conn->query($moviedetails_info_query);





                if ($moviedetails_info_result->num_rows > 0) {
                    echo "<table><tr><th>Poster</th><th>MovieID</th><th>MovieDetailsID</th><th>MovieName</th><th>Theater</th><th>Date</th><th>Showtime</th><th>Seat</th><th>Price per Ticket</th></tr>";
                    while ($row_schedule = $moviedetails_info_result->fetch_assoc()) {


                        $movie_info_query = "SELECT * FROM Movies WHERE movieid = " . $row_schedule['MovieID'];
                        $movie_info_result = $conn->query($movie_info_query);
        
                        if ($movie_info_result->num_rows > 0) {
                            
                            while ($row_movie = $movie_info_result->fetch_assoc()) {
        
                                $poster = base64_encode($row_movie["Poster"]);
                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                $mimeType = finfo_buffer($finfo, $row_movie["Poster"]);
                                finfo_close($finfo);



                        echo'<tr><td><img src="data:' . $mimeType . ';base64,' . $poster . '" class="poster"></td>';
                        echo "<td>".$row_schedule['MovieID']."</td><td>".$row_schedule['MovieDetailsID']."</td><td>".$row_movie['MovieName']."</td><td>".$row_schedule['Theater']."</td><td>".$row_schedule['Date']."</td><td>".$row_schedule['Showtime']."</td><td>".$row_schedule['Seat']."</td><td>".$row_schedule['Price']."</td></tr>";


                        }
                      } 
                    }
                    echo "</table>";
                } else {
                    echo "No bookings found.";
                }
                ?>
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

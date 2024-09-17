<?php 
session_start();
include 'conn.php';
include 'TopBar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User's Booked Tickets</title>
    <link rel="stylesheet" href="test.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        body {
            background-color: #1a202c; /* Dark background */
        }
        .poster {
            width: 100px;
            height: 150px;
            object-fit: cover;
        }
        .content {
            color: #f7fafc; /* Light text */
            font-family: 'Roboto', sans-serif; /* Decent font style */
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 1rem;
            flex: 1; /* Allow container to grow and fill the available space */
        }
        .movie-info {
            background: #2d3748; /* Darker background for contrast */
            border-radius: 0.5rem;
            padding: 0.5rem; /* Reduced padding */
            margin-top: 1rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .movie-info:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
        }
        .headers, .info {
            display: grid;
            grid-template-columns: 110px 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; /* Increased size of each column */
            gap: 0.5rem; /* Reduced gap */
            align-items: center;
            text-align: center;
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
<body class="bg-gray-900 text-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4 content" style="margin-top: 6rem;">Your Booked Tickets</h1>
        <div class="bg-gray-800 shadow-md rounded-lg p-4 content" style="background: rgba(45, 55, 72, 0.8);">
            <div class="headers font-semibold">
                <div>Poster</div>
                <div>Name</div>
                <div>Language</div>
                <div>Date</div>
                <div>Theater</div>
                <div>Showtime</div>
                <div>Tickets</div>
                <div>Genre</div>
                <div>Price</div>
            </div>
            <div id="moviesList" class="mt-4">
            <?php 
            $uid = $_GET['userid'];
            ?>
            <div id="mySidebar" class="sidebar">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                <a href="./User_home.php?userid=<?php echo $uid; ?>">Dashboard</a>
                <a href="./User_modify.php?userid=<?php echo $uid; ?>">Settings</a>
                <a href="./User_feedback.php?userid=<?php echo $uid; ?>">Feedback</a>
                <a href="./Testhome.php?userid=<?php echo $uid; ?>">Movie Section</a>
                <a href="./Testhome.php">Log Out</a>
            </div>
            <button class="openbtn" onclick="openNav()">☰ Open Sidebar</button>
            <?php
            // Include the database connection file
            $sql = "SELECT movieid, theater, date, showtime, price, tickets FROM booking WHERE userid = $uid";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $mid = $row['movieid'];
                    // Fetch movie details using movie ID
                    $movieSql = "SELECT poster, moviename, language, releasedate, genre FROM movies WHERE movieid = $mid";
                    $movieResult = $conn->query($movieSql);
                    if ($movieResult->num_rows > 0) {
                        $movieRow = $movieResult->fetch_assoc();
                        $poster = base64_encode($movieRow['poster']);
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mimeType = finfo_buffer($finfo, $movieRow['poster']);
                        finfo_close($finfo);
                        // $movieRow['price'] = $row['tickets'] * $movieRow['price'];
                        echo '<div class="info movie-info">';
                        echo '<div><img src="data:' . htmlspecialchars($mimeType) . ';base64,' . htmlspecialchars($poster) . '" class="poster"></div>';
                        echo '<div>' . htmlspecialchars($movieRow['moviename']) . '</div>';
                        echo '<div>' . htmlspecialchars($movieRow['language']) . '</div>';
                        echo '<div>' . htmlspecialchars($row['date']) . '</div>';
                        echo '<div>' . htmlspecialchars($row['theater']) . '</div>';
                        echo '<div>' . htmlspecialchars($row['showtime']) . '</div>';
                        echo '<div>' . htmlspecialchars($row['tickets']) . '</div>';
                        echo '<div>' . htmlspecialchars($movieRow['genre']) . '</div>';
                        echo '<div>' . htmlspecialchars($row['price']) . '</div>';
                        echo '</div>';
                    } else {
                        echo '<p class="content">Movie details not found for movie ID ' . htmlspecialchars($mid) . '.</p>';
                    }
                }
            } else {
                echo '<p class="content">No ticket booked yet.</p>';
            }
            $conn->close();
            ?>
            </div>
        </div>
    </div>
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }
        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
        }
    </script>
    <?php include 'Footer.php'; ?>
</body>
</html>

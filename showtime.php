<?php 
include 'TopBar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a202c;
            background-image: url('dark.jpg'); 
            font-family: 'Roboto', sans-serif;
            color: #f7fafc;
            margin: 0;
            padding: 0;
            background-attachment: fixed; /* Fixes the background image */

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
            margin-top: 2rem;
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
            height: auto;
        }
    </style>
</head>
<body>

<?php 
if (!isset($_GET['userid'])) {
    $userid = 0;
} else {
    $userid = htmlspecialchars($_GET['userid']);
    include 'User_nav.php';  // user nav    
}
if (!isset($_GET['adminid'])) {
    $adminid = 0;
} else {
    $adminid = htmlspecialchars($_GET['adminid']);
    include 'Admin_nav.php'; // admin nav
}
if ($userid == 0 && $adminid == 0) {
    include 'nav.php';  // Guest nav
}
?>
    <div class="header">Movie Details</div>

    <div class="content-container">
        <?php
        include 'conn.php';

        // Query to get all movies
        $movie_info_query = "SELECT * FROM Movies where schedule = 'Now Showing'";
        $movie_info_result = $conn->query($movie_info_query);

        if ($movie_info_result->num_rows > 0) {
            while ($row_movie = $movie_info_result->fetch_assoc()) {
                // Fetch poster
                $poster = base64_encode($row_movie["Poster"]);
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_buffer($finfo, $row_movie["Poster"]);
                finfo_close($finfo);

                echo '<div class="content-section">';
                echo '<table>';
                echo '<tr><th>Poster</th><th>Movie Name</th><th>Theater</th><th>Date</th><th>Showtime</th><th>Seat</th><th>Price</th></tr>';

                // Query to get movie details
                $moviedetails_info_query = "SELECT * FROM moviedetails WHERE MovieID = " . $row_movie['MovieID'];
                $moviedetails_info_result = $conn->query($moviedetails_info_query);

                if ($moviedetails_info_result->num_rows > 0) {
                    $row_count = $moviedetails_info_result->num_rows; // Number of rows
                    $first_row = true;
                    $poster_size = 150 + ($row_count - 1) * 50; // Increase size dynamically

                    while ($row_schedule = $moviedetails_info_result->fetch_assoc()) {
                        echo "<tr>";
                        if ($first_row) {
                            echo '<td rowspan="' . $row_count . '"><img src="data:' . $mimeType . ';base64,' . $poster . '" style="height: ' . $poster_size . 'px; width: ' . ($poster_size * 0.67) . 'px;"></td>';
                            echo '<td rowspan="' . $row_count . '">' . $row_movie['MovieName'] . '</td>';
                            $first_row = false;
                        }
                        echo "<td>" . $row_schedule['Theater'] . "</td>";
                        echo "<td>" . $row_schedule['Date'] . "</td>";
                        echo "<td>" . $row_schedule['Showtime'] . "</td>";
                        echo "<td>" . $row_schedule['Seat'] . "</td>";
                        echo "<td>" . $row_schedule['Price'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td><img src='data:" . $mimeType . ";base64," . $poster . "' class='poster'></td><td colspan='5'>No schedule available</td></tr>";
                }

                echo '</table>';
                echo '</div>';
            }
        } else {
            echo "<div class='content-section'><p>No movies found.</p></div>";
        }
        ?>
    </div>

    <?php  
    include 'Footer.php';
    ?>
</body>
</html>

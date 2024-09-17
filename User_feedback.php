<?php 
session_start();
include 'conn.php';
include 'TopBar.php';
$uid = $_GET['userid'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['rating']) && isset($_POST['movieid'])) {
        $rating = $_POST['rating'];
        $movieid = $_POST['movieid'];


// Prepare the select statement to check if the movieid exists
$checkStmt = $conn->prepare("SELECT Rating FROM Feedback WHERE MovieID = ? AND UserID = ?");
$checkStmt->bind_param("ii", $movieid,$uid);
$checkStmt->execute();
$checkStmt->store_result(); // Store the result to check the number of rows

if ($checkStmt->num_rows > 0) {
    // MovieID exists, so update the rating
    $sql = "UPDATE Feedback SET Rating = ? WHERE MovieID = ? AND UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dii", $rating, $movieid,$uid); // Use "di" for double and integer types
} else {
    // MovieID does not exist, so insert a new record
    $sql = "INSERT INTO Feedback (UserID, MovieID, Rating) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iid", $uid, $movieid, $rating); // Use "iid" for integer, integer, and double types
}

$stmt->execute();
$stmt->close();
$checkStmt->close();





        $query = "SELECT Rating FROM Feedback WHERE movieid = '$movieid'";
        $result = $conn->query($query);


        if ($result->num_rows > 0) {

            $rating_update=0;
            $cnt=0;

          while ($row = $result->fetch_assoc()) {
            $rating_update += $row['Rating'];
            $cnt++;
          }
        }
        $rating_update = $rating_update/$cnt;



                $sql_movie = "UPDATE movies SET rating = ? WHERE movieid = ?";
                $stmt_movie = $conn->prepare($sql_movie);
                $stmt_movie->bind_param("di", $rating_update, $movieid);
                $stmt_movie->execute();
                $stmt_movie->close();
    }
    if (isset($_POST['complaint'])) {
        $complaint = $_POST['complaint'];
        $sql = "UPDATE user SET complaint = ? WHERE userid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $complaint, $uid);
        $stmt->execute();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback</title>
    <link rel="stylesheet" href="test.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* General styling */
        body {
            background-color: #1a202c;
            color: #f7fafc;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 1rem;
        }
        .table-container {
            margin-top: 2rem;
            padding: 1rem;
            background: #2d3748;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .table-header {
            font-weight: bold;
            text-align: left;
        }
.table-row {
    display: grid;
    grid-template-columns: 100px 2fr 250px; /* Adjusted the width of the third column */
    gap: 0.5rem;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #4a5568;
}

        .table-row:last-child {
            border-bottom: none;
        }
        .table-row img {
            width: 100px;
            height: 150px;
            object-fit: cover;
        }
        .table-row input[type="number"] {
            width: 60px;
            padding: 0.5rem;
            border: 1px solid #4a5568;
            border-radius: 0.25rem;
            background: #2d3748;
            color: #f7fafc;
        }
        .table-row input[type="submit"] {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.25rem;
            background: #3182ce;
            color: #f7fafc;
            cursor: pointer;
            transition: background 0.3s;
        }
        .table-row input[type="submit"]:hover {
            background: #2b6cb0;
        }
        .complaint-container {
            margin-top: 2rem;
        }
        .complaint-container textarea {
            width: 100%;
            padding: 1rem;
            border-radius: 0.25rem;
            border: 1px solid #4a5568;
            background: #2d3748;
            color: #f7fafc;
        }
        .complaint-container input[type="submit"] {
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.25rem;
            background: #3182ce;
            color: #f7fafc;
            cursor: pointer;
            transition: background 0.3s;
        }
        .complaint-container input[type="submit"]:hover {
            background: #2b6cb0;
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
            <div id="mySidebar" class="sidebar">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                <a href="./User_home.php?userid=<?php echo $uid; ?>">Dashboard</a>
                <a href="./User_modify.php?userid=<?php echo $uid; ?>">Settings</a>
                <a href="./User_feedback.php?userid=<?php echo $uid; ?>">Feedback</a>
                <a href="./Testhome.php?userid=<?php echo $uid; ?>">Movie Section</a>
                <a href="./Testhome.php">Log Out</a>
            </div>
            <button class="openbtn" onclick="openNav()">☰ Open Sidebar</button>


    
    <div class="container">
        <h1 class="text-3xl font-bold mb-4" style="margin-top: 6rem;">Rate Movies</h1>
        <div class="table-container">
            <div class="table-header">Movie Rating</div>
            <form method="POST">
                <?php
                $movieSql = "SELECT movieid, poster, moviename FROM movies";
                $movieResult = $conn->query($movieSql);
                if ($movieResult->num_rows > 0) {
                    while ($movieRow = $movieResult->fetch_assoc()) {
                        $poster = base64_encode($movieRow['poster']);
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mimeType = finfo_buffer($finfo, $movieRow['poster']);
                        finfo_close($finfo);
                        
                        echo '<div class="table-row">';
                        echo '<div><img src="data:' . htmlspecialchars($mimeType) . ';base64,' . htmlspecialchars($poster) . '"></div>';
                        echo '<div>' . htmlspecialchars($movieRow['moviename']) . '</div>';
                        echo '<div style="display: flex; align-items: center;">';
                
                        // Begin individual form for each movie
                        echo '<form method="POST">';
                        echo '<input type="hidden" name="movieid" value="' . htmlspecialchars($movieRow['movieid']) . '">';
                        echo '<input type="number" name="rating" min="1" value="1" max="10" required style="margin-right: 10px;">';
                        echo '<input type="submit" value="Submit Rating">';
                        echo '</form>'; // End individual form
                        
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No movies found.</p>';
                }
                
                ?>
                <!-- <input type="submit" value="Submit Rating"> -->
            </form>
        </div>
        <div class="complaint-container">
            <h2 class="text-3xl font-bold mb-4">Submit a Complaint</h2>
            <form method="POST">
                <textarea name="complaint" rows="5" placeholder="Write your complaint here..." required></textarea>
                <input type="submit" value="Submit Complaint">
            </form>
        </div>
    </div>
    <?php include 'Footer.php'; ?>

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
</body>
</html>

<?php 
$conn->close();
?>

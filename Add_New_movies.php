<?php 
include 'conn.php';
include 'TopBar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add New Movie</title>
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
    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: rgba(45, 55, 72, 0.8);
        border-radius: 10px;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .container:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
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

    form {
        display: flex;
        flex-direction: column;
    }
    label {
        margin-bottom: 5px;
        font-weight: bold;
    }
    input[type="text"], input[type="date"], input[type="file"], input[type="submit"], select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    box-sizing: border-box;
    border: none;
    border-radius: 5px;
    background-color: #fff ; 
    color: #000; 
}

    input[type="submit"] {
        background-color: #4a5568;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .upload-btn {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        font-size: 16px;
        color: #fff;
        background-color: #4a5568;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        transition: background-color 0.3s ease;
    }
    .upload-btn:hover {
        background-color: #2d3748;
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
<div class="header">Add Movies</div>

 <div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to ADD the Movie?')">
        <input type="file" name="poster" accept="image/*" style="display:none" id="poster" required>
        <label for="poster" class="upload-btn">Upload Poster</label>

        <input type="file" name="back" accept="image/*" style="display:none" id="back" required>
        <label for="back" class="upload-btn">Upload Background Image</label>

        <label for="name">Movie Name:</label>
        <input type="text" name="name" id="name" placeholder="Enter new Movie Name" required>

        <label for="Cast">Cast:</label>
        <input type="text" name="Cast" id="Cast" placeholder="Enter new Cast" required>

        <label for="Language">Language:</label>
        <input type="text" name="Language" id="Language" placeholder="Enter new Language" required>

        <label for="Genre">Genre:</label>
        <input type="text" name="Genre" id="Genre" placeholder="Enter new Genre" required>

        <label for="Synopsis">Synopsis:</label>
        <input type="text" name="Synopsis" id="Synopsis" placeholder="Enter new Synopsis" required>

        <label for="Schedule">Schedule:</label>
<select name="Schedule" id="Schedule" required>
    <option value="">Select Schedule</option> <!-- Default option -->
    <option value="Now Showing">Now Showing</option>
    <option value="Upcoming">Upcoming</option>
</select>


        <label for="Trailer">Trailer:</label>
        <input type="text" name="Trailer" id="Trailer" placeholder="Enter new Trailer Link" required>

        <div class="form-group">
            <label for="date">Release Date:</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <input type="submit" value="Submit">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (isset($_FILES["poster"]) && $_FILES["poster"]["error"] == 0) {
            $poster = file_get_contents($_FILES["poster"]["tmp_name"]);
            $poster = mysqli_real_escape_string($conn, $poster);
        } else {
            echo "Error uploading poster image.";
            exit;
        }

        if (isset($_FILES["back"]) && $_FILES["back"]["error"] == 0) {
            $back = file_get_contents($_FILES["back"]["tmp_name"]);
            $back = mysqli_real_escape_string($conn, $back);
        } else {
            echo "Error uploading background image.";
            exit;
        }

        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $Language = mysqli_real_escape_string($conn, $_POST['Language']);
        $Schedule = mysqli_real_escape_string($conn, $_POST['Schedule']);
        $Cast = mysqli_real_escape_string($conn, $_POST['Cast']);
        $date = $_POST['date'];
        $Genre = mysqli_real_escape_string($conn, $_POST['Genre']);
        $Trailer = mysqli_real_escape_string($conn, $_POST['Trailer']);
        $syn = mysqli_real_escape_string($conn, $_POST['Synopsis']);

        $sql = "INSERT INTO movies (movieName, Cast, Language, releasedate, genre, trailer, Synopsis, Schedule, poster, Background) 
                VALUES ('$name','$Cast','$Language', '$date', '$Genre', '$Trailer','$syn','$Schedule','$poster','$back')";

        if (mysqli_query($conn, $sql)) {
            // echo "<h4>Movie added successfully.</h4>";
        } else {
            echo "Error adding movie: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
    ?>
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
    
    document.querySelectorAll('.upload-btn').forEach(btn => {
    btn.addEventListener('click', function(event) {
        event.preventDefault(); // Prevents any default action
        document.getElementById(this.getAttribute('for')).click();
    }, { once: true }); // Ensures the event listener is added only once
});

</script>
<?php  
include 'Footer.php';?>
</body>
</html>

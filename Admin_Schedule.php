<?php 
include 'TopBar.php';
include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Movie Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        select, input[type="date"], input[type="text"] {
    color: black;
    background-color: white;
    border-radius: 0.25rem;
    padding: 0.5rem;
    width: 100%;
    box-sizing: border-box;
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
        body {
            background-color: #1a202c;
            background-image: url('dark.jpg'); 
            font-family: 'Roboto', sans-serif;
            color: #f7fafc;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }        
        .header {
            text-align: center;
            margin: 20px 0;
            font-size: 36px;
            font-weight: bold;
            color: white;
        }
        .content-section {
            width: 80%;
            background: rgba(45, 55, 72, 0.8);
            border-radius: 0.5rem;
            padding: 1rem;
            margin: 0 auto;
            margin-top: 2rem;
            margin-bottom: 2rem; /* Added margin-bottom for gap */
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            flex: 1;
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
            max-width: 100px;
            max-height: 150px;
            object-fit: cover;
        }
        select, input[type="date"] {
            color: black;
            background-color: white;
            border-radius: 0.25rem;
            padding: 0.5rem;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4A90E2;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 0.25rem;
        }
        input[type="submit"]:hover {
            background-color: #357ABD;
        }
        footer {
    background-color: rgba(45, 55, 72, 0.8);
    text-align: center;
    padding: 1rem;
    color: #f7fafc;
    position: relative;
    bottom: 0;
    width: 100%;
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
        .modal-content {
    color: black; 
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

    <div class="header">Assign Movie Schedule</div>

    <div class="content-section">
        <form action="" method="post">
            <?php
            $now_showing_query = "SELECT MovieID, MovieName, Poster FROM Movies WHERE Schedule='Now showing'";
            $result = $conn->query($now_showing_query);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Poster</th><th>Movie Name</th><th>Theater</th><th>Date</th><th>Showtime</th><th>Price</th><th>Seat</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    $poster = base64_encode($row["Poster"]);
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType = finfo_buffer($finfo, $row["Poster"]);
                    finfo_close($finfo);
                    
                    echo '<tr>';
                    echo '<td><img src="data:' . $mimeType . ';base64,' . $poster . '" class="poster"></td>';
                    echo '<td>' . $row["MovieName"] . '</td>';
                    echo '<td>
                            <select name="theater[]">
                                <option value="Theater 1">Theater 1</option>
                                <option value="Theater 2">Theater 2</option>
                                <option value="Theater 3">Theater 3</option>
                                <option value="Theater 4">Theater 4</option>
                                <option value="Theater 5">Theater 5</option>
                                <option value="Theater 6">Theater 6</option>
                            </select>
                          </td>';
                          echo '<td><input type="date" name="date[]" value="' . date("Y-m-d") . '" min="' . date("Y-m-d") . '" max="' . date("Y-m-d", strtotime("+7 days")) . '" onchange="checkAvailability(this)" requied></td>';
                          echo '<td>
                            <select name="showtime[]">
                                <option value="12PM">12PM</option>
                                <option value="2PM">2PM</option>
                                <option value="4PM">4PM</option>
                                <option value="6PM">6PM</option>
                                <option value="8PM">8PM</option>
                                <option value="10PM">10PM</option>
                            </select></td>';

                          echo '<td><input type="text" name="price[]" id="price" placeholder="Enter Price" required></td>';
                          echo '<td><input type="text" name="seat[]" id="seat" placeholder="Enter Seat" required></td>';

                    echo '<input type="hidden" name="movieid[]" value="' . $row["MovieID"] . '">';
                    echo '</tr>';
                }
                echo "</table>";
                echo '<input type="submit" value="Save Schedule" class="btn">';
            } else {
                echo "<p>No movies are currently showing.</p>";
            }
            ?>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $movie_ids = $_POST['movieid'];
        $theaters = $_POST['theater'];
        $dates = $_POST['date'];
        $prices = $_POST['price'];
        $seats = $_POST['seat'];
        $showtimes = $_POST['showtime'];

        $is_duplicate = false;
        $is_same_schedule = false;

        for ($i = 0; $i < count($movie_ids); $i++) {
            for ($j = $i + 1; $j < count($movie_ids); $j++) {
                // Check for duplicate entries within the same form submission
                if ($theaters[$i] === $theaters[$j] && $dates[$i] === $dates[$j] && $showtimes[$i] === $showtimes[$j]  ) {
                    $is_duplicate = true;
                    break 2;
                }
            }

            // Check if the same schedule has already been assigned before
            $check_query = "SELECT * FROM MovieDetails WHERE MovieID = '$movie_ids[$i]' AND Theater = '$theaters[$i]' AND Date = '$dates[$i]' AND Showtime = '$showtimes[$i]'";
            $check_result = $conn->query($check_query);
            if ($check_result->num_rows > 0) {
                $is_same_schedule = true;
                break;
            }
        }

        if ($is_duplicate) {
            echo '<div id="duplicateModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div class="bg-white rounded-lg p-6 shadow-lg text-center modal-content">
                        <h2 class="text-xl font-bold mb-4">Error</h2>
                        <p class="mb-4">Duplicate Theater, Date, and Showtime combination found. Please ensure all entries are unique.</p>
                        <button onclick="closeModal()" class="bg-blue-500 text-white px-4 py-2 rounded">OK</button>
                    </div>
                  </div>';
        } elseif ($is_same_schedule) {
            echo '<div id="sameScheduleModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div class="bg-white rounded-lg p-6 shadow-lg text-center modal-content">
                        <h2 class="text-xl font-bold mb-4">Error</h2>
                        <p class="mb-4">Same Schedule is already assigned before.</p>
                        <button onclick="closeModal()" class="bg-blue-500 text-white px-4 py-2 rounded">OK</button>
                    </div>
                  </div>';
        } else {
            for ($i = 0; $i < count($movie_ids); $i++) {
                $movie_id = $movie_ids[$i];
                $theater = $theaters[$i];
                $date = $dates[$i];
                $price = $prices[$i];
                $seat = $seats[$i];
                $showtime = $showtimes[$i];

                $sql = "INSERT INTO MovieDetails (MovieID, Theater, Date, Showtime, Seat, Price)
                        VALUES ('$movie_id', '$theater', '$date', '$showtime', '$seat', '$price')";

                if (!mysqli_query($conn, $sql)) {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }

            echo '<div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" style="display: flex;">
            <div class="bg-white rounded-lg p-6 shadow-lg text-center modal-content">
                <h2 class="text-xl font-bold mb-4">Success</h2>
                <p class="mb-4">Schedule saved successfully!</p>
                <button onclick="closeModal()" class="bg-blue-500 text-white px-4 py-2 rounded">OK</button>
            </div>
        </div>';
        
            
    
        }
    }

    mysqli_close($conn);
    ?>


    <?php include 'Footer.php'; ?>
    <script>
        function checkAvailability(input) {
            var selectedDate = input.value;
            var theaterInput = input.closest('tr').querySelector('select[name="theater[]"]').value;
            var showtimeInput = input.closest('tr').querySelector('select[name="showtime[]"]').value;
            // var priceInput = input.value;
            // var seatInput = input.value;


            var rows = document.querySelectorAll('table tr');
            var isDuplicate = false;

            rows.forEach(function(row) {
                if (row !== input.closest('tr')) {
                    var rowDate = row.querySelector('input[type="date"]').value;
                    // var rowPrice = row.querySelector('input[name="price[]"]').value;
                    // var rowSeat = row.querySelector('input[name="seat[]"]').value;
                    var rowTheater = row.querySelector('select[name="theater[]"]').value;
                    var rowShowtime = row.querySelector('select[name="showtime[]"]').value;

                    if (rowDate === selectedDate && rowTheater === theaterInput && rowShowtime === showtimeInput) {
                        isDuplicate = true;
                    }
                }
            });

            if (isDuplicate) {
                alert("This Theater, Date, and Showtime combination is already assigned. Please choose another.");
                input.value = "";
            }
        }

        function closeModal() {
    var duplicateModal = document.getElementById('duplicateModal');
    var sameScheduleModal = document.getElementById('sameScheduleModal');
    var successModal = document.getElementById('successModal'); // Added success modal reference

    if (duplicateModal) {
        duplicateModal.style.display = 'none';
    }
    if (sameScheduleModal) {
        sameScheduleModal.style.display = 'none';
    }
    if (successModal) {
        successModal.style.display = 'none'; // Hide success modal
    }
}



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

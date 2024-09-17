<?php  
session_start();
include 'conn.php';
include 'TopBar.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- <link rel="stylesheet" href="test.css"> -->
  <title>Movie Booking</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>

<?php

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signin'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT userid FROM user WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($row = $result->fetch_assoc()) {
      $userid= $row['userid'];
  }

  $query = "SELECT password FROM user WHERE email = ?";
  $stmt = mysqli_prepare($conn, $query);

  if ($stmt === false) {
      die("Error preparing the statement: " . mysqli_error($conn));
  }

  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $hashed_password);

  if (mysqli_stmt_fetch($stmt)) {
      if (password_verify($password, $hashed_password)) {
          $_SESSION["email_log"] = $email;
          $_SESSION["uid"] = $userid;

          header("Location: Testhome.php?userid=" . $userid);
          exit();
      } else {
          $message = "Incorrect password. Please try again.";
      }
  } else {
      $message = "User with the provided email not found.";
  }

  mysqli_stmt_close($stmt);
}

?>


    <!-- Modal for wrong password/email-->
    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $message; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


<?php 

if (!$_GET['userid']) {
  $loggedIn = 0;
} else {
  $loggedIn = 1;
  $userid = $_GET['userid'];
  include 'User_nav.php';  // user nav
}

if (!$_GET['adminid']) {
$loggedIn_ad = 0;
} else {
  $loggedIn_ad = 1;
  $adminid = $_GET['adminid'];
include 'Admin_nav.php'; // admin nav
}


if($loggedIn ==0 && $loggedIn_ad==0)
{
include 'nav.php';  //Guest Nav
}

?>





<?php

$book_success = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_ticket']) && $loggedIn) {
  $movieId = $_POST['movieId'];
  $theater = $_POST['theater'];
  $date = $_POST['date'];
  $showtime = $_POST['showtime'];
  $price = $_POST['price'];
  $seat = $_POST['seat'];
  $tickets = $_POST['tickets'];
  $updateprice =  $price *  $tickets;
  $newSeat = $seat - $tickets;

  $query = "INSERT INTO booking (userid, movieid, theater, date, showtime, price, tickets) 
            VALUES ('$userid', '$movieId', '$theater', '$date', '$showtime', '$updateprice', '$tickets')";

      // Prepare an update statement
      $updateStmt = $conn->prepare("UPDATE MovieDetails SET seat = ? WHERE movieid = ? AND theater = ? AND date = ? AND showtime= ?");
      $updateStmt->bind_param("iisss", $newSeat, $movieId,$theater,$date,$showtime);
    
        // Execute the update statement
        if ($updateStmt->execute()) {
          // echo "<script>alert('Profile updated successfully!');</script>";
      } else {
          echo "<script>alert('Error updating seat: " . $conn->error . "');</script>";
      }




  if ($conn->query($query) === TRUE) {
    $book_success = 'Ticket Booking Successfull';

} else {
     $book_success = 'Ticket Booking Failed';
}

        // Close the statement
        $updateStmt->close();
}

?>


    <!-- Modal for Ticket booking-->
    <div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookModalLabel">Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $book_success; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


<div class="container">
    <div class="row movie-details">
        <?php
        if (!isset($_GET['id']) ) {
          header("Location: Testhome.php"); 
          exit();
          
        }
        $movieId = $_GET['id'];


        $query = "SELECT movieid, moviename, poster, Language, genre,cast, releasedate,synopsis ,trailer,background,schedule,rating FROM movies WHERE movieid = '$movieId'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $trailer = $row['trailer'];
        }

        $poster = base64_encode($row['poster']);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $row['poster']);
        finfo_close($finfo);


        $back = base64_encode($row['background']);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $row['background']);
        finfo_close($finfo);


        $schedule =$row['schedule'];


        // In the booking page, after fetching movie details
           $schedules_query = "SELECT Theater, Date, Showtime,Seat,Price FROM MovieDetails WHERE MovieID = '$movieId'";
           $schedules_result = $conn->query($schedules_query);

              if ($schedules_result->num_rows > 0) {
               $theaterOptions = [];
               $dateOptions = [];
               $showtimeOptions = [];
               $priceOptions = [];
               $seatOptions = [];

               while ($schedule_row = $schedules_result->fetch_assoc()) {
                  $theaterOptions[] = $schedule_row['Theater'];
                  $dateOptions[] = $schedule_row['Date'];
                  $showtimeOptions[] = $schedule_row['Showtime'];
                  $priceOptions[] = $schedule_row['Price'];
                  $seatOptions[] = $schedule_row['Seat'];
                 }
                  $theaterOptions = array_unique($theaterOptions);
                  $dateOptions = array_unique($dateOptions);
                  $showtimeOptions = array_unique($showtimeOptions);
                  $priceOptions = array_unique($priceOptions);
                  $seatOptions = array_unique($seatOptions);
              }


        ?>

<?php
$schedules = [];

$schedules_query = "SELECT Theater, Date, Showtime,Seat,Price FROM MovieDetails WHERE MovieID = '$movieId'";
$schedules_result = $conn->query($schedules_query);

if ($schedules_result->num_rows > 0) {
    while ($schedule_row = $schedules_result->fetch_assoc()) {
        $schedules[] = $schedule_row;
    }
}
?>

<script>
    var schedules = <?php echo json_encode($schedules); ?>;
</script>


        <div class="col-md-4">
            <!-- this line -->
          <img src="data:<?php echo $mimeType; ?>;base64,<?php echo $poster; ?>" class="movie-poster img-fluid">  
        </div>
        <div class="col-md-8" style="margin-top: 500px;">
            <div class="movie-info">
                <h5 style="font-size: 1.5rem;">⭐<?php echo $row['rating']; ?></h5>
                <h5 style="font-size: 1.5rem;"><?php echo $row['moviename']; ?></h5>
                <p style="font-size: 1rem;">Cast: <?php echo $row['cast']; ?></p>
                <p style="font-size: 1rem;">Language: <?php echo $row['Language']; ?></p>
                <p style="font-size: 1rem;">Genre: <?php echo $row['genre']; ?></p>
                <p style="font-size: 1rem;">Release Date: <?php echo $row['releasedate']; ?></p>
                <div class="btn-group" style="margin-top: 10px;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#trailerModal" style="background-color: transparent; border: 1px solid #ffffff; margin-left: 10px;">Show Trailer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row synopsis">
        <div class="col-12">
            <h5>SYNOPSIS</h5>
            <p><?php echo $row['synopsis']; ?></p>
        </div>
    </div>

    <?php if ($schedule=="Upcoming"): ?>
      <div class="notice">
        <h5>Notice</h5>
        <p>Ticket Will be Available Soon</p>
    </div>
    <div class="hidden-booking-space"></div>
      <?php else: ?>

      <div class="row theater-info">
        <div class="col-12">
            <h5>BOOK TICKET</h5>
  <form method="post" action="">
    <input type="hidden" name="movieId" value="<?php echo $movieId; ?>">
    
    <div class="form-group">
        <label for="theater">Select Theater</label>
        <select class="form-control" id="theater" name="theater" required onchange="filterFields()">
          <option value="" disabled selected>Select a Theater</option>
            <?php foreach ($theaterOptions as $theater) { ?>
        <option value="<?php echo $theater; ?>"><?php echo $theater; ?></option>
    <?php } ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="date">Select Date</label>
        <select class="form-control" id="date" name="date" required onchange="filterFields()">
          <option value="" disabled selected>Select a Date</option>
            <?php foreach ($dateOptions as $date) { ?>
                <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
            <?php } ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="showtime">Select Showtime</label>
        <select class="form-control" id="showtime" name="showtime" required onchange="filterFields()">
          <option value="" disabled selected>Select a Showtime</option>
            <?php foreach ($showtimeOptions as $showtime) { ?>
                <option value="<?php echo $showtime; ?>"><?php echo $showtime; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="price">Select Price</label>
        <select class="form-control" id="price" name="price" required onchange="filterFields()">
          <option value="" disabled selected>Select a Price</option>
            <?php foreach ($priceOptions as $price) { ?>
                <option value="<?php echo $price; ?>"><?php echo $price; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
       <label for="seat">Available Seats</label>
       <input type="number" class="form-control" id="seat" name="seat" required readonly>
    </div> 

    <div class="form-group">
        <label for="tickets">Number of Tickets</label>
        <input type="number" class="form-control" id="tickets" name="tickets" min="1" value="1" required>
    </div>
    
    <?php if (!$loggedIn): ?>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal" style="background-color: transparent; border: 1px solid #ffffff;">Book Ticket</button>
    <?php else: ?>
        <button type="submit" name="book_ticket" class="btn btn-primary" style="background-color: transparent; border: 1px solid #ffffff;">Book Ticket</button>
    <?php endif; ?>
      <!-- Reset button -->
         <button type="button" class="btn btn-secondary" onclick="resetForm()" style="background-color: transparent; border: 1px solid #ffffff;">Reset</button>
  </form>

        </div>
      </div>
    <?php endif; ?>
</div>


<!-- Modal for sign in -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalCenterTitle">Sign In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <input type="hidden" name="login" value="1">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="signin"class="btn btn-primary" style="background-color: transparent; border: 1px solid #ffffff;">Sign In</button>
                    <button type="button" class="btn btn-primary" onclick="window.location.href='userpg.php'" style="background-color: transparent; border: 1px solid #ffffff;">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for trailer -->
<div class="modal fade bd-example-modal-lg" id="trailerModal" tabindex="-1" role="dialog" aria-labelledby="trailerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <iframe id="trailerIframe" width="1200vw" height="800vh" src="https://www.youtube.com/embed/<?php echo $row['trailer']; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="display: block; margin-left: -200px; margin-right: auto;"></iframe>
              </div>
        </div>
    </div>
</div>

<!-- Modal for success message -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ticket Booking Successful!
            </div>
        </div>
    </div>
</div>




<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
  body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4), rgba(42, 42, 42, 0.4) 45%, rgba(42, 42, 42, 1) 47%);
    color: #ffffff;
    position: relative;
    
  }

  body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 47%; /* Fixed height for the background image */
    background-image: url("data:<?php echo $mimeType; ?>;base64,<?php echo $back; ?>");
    background-size: cover; /* Ensure the image covers the area */
    background-repeat: no-repeat;
    background-position: center center; /* Center the image */
    filter: blur(5px); /* Add this line to apply the blur effect */
    z-index: -1;
  }

  h5, p, label, button, strong {
    color: #ffffff;
    font-weight: bold;
  }

  .synopsis h5, .theater-info h5, .notice h5 {
    font-size: 1.5rem;
    font-weight: normal; /* Decrease the thickness of the heading */
    text-transform: uppercase;
    margin-bottom: 20px;
    position: relative;
    padding-left: 15px; /* Adjust padding to the left for the thinner bar */
  }

  .synopsis h5::before, .theater-info h5::before, .notice h5::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 5px; /* Decrease the width of the colored bar */
    background-color: red; /* Color of the bar */
  }

  .synopsis p, .theater-info p, .notice p {
    font-size: 1.2rem;
    margin-bottom: 10px;
    padding-left: 0;
  }

  .container {
    position: relative;
    z-index: 1;
  }

  .movie-details {
    display: flex;
    align-items: flex-start;
  }

  .movie-poster {
    width: 350px;
    height: 500px;
    object-fit: cover;
    margin-right: 30px;
    margin-top: 355px; /* Increase this value to create a larger gap */

}


  .movie-info {
    max-width: 600px;
  }

  .movie-info h5 {
    font-size: 2rem;
    margin-bottom: 20px;
  }

  .movie-info p {
    font-size: 1.2rem;
    margin-bottom: 10px;
  }

  .synopsis {
    margin-top: 40px;
  }

  .theater-info {
    margin-top: 40px;
  }

  .btn-group {
    margin-top: 20px;
  }

  .modal-content {
    background-color: transparent;
    border: none;
  }

  .close {
    color: #ffffff;
  }

  .modal-body iframe {
    background: transparent;
  }
  .hidden-booking-space {
    height: 350px; /* Adjust this height to match the height of the booking section */
  }
  .notice {
    margin-top: 40px; /* Adjust this value as needed for the gap */
  }
</style>

<?php  
include 'Footer.php';?>



<script>
bookModal

<?php if ($message != ''): ?>
            $(document).ready(function() {
                $('#messageModal').modal('show');
            });
<?php endif; ?>


<?php if ($book_success != ''): ?>
            $(document).ready(function() {
                $('#bookModal').modal('show');
            });
<?php endif; ?>



  $('#trailerModal').on('hidden.bs.modal', function () {
    var iframe = $('#trailerIframe');
    iframe.attr('src', iframe.attr('src')); // Reset the iframe src to stop the video
  });



  var schedules = <?php echo json_encode($schedules); ?>;

  function filterFields() {
    var selectedTheater = document.getElementById('theater').value;
    var selectedDate = document.getElementById('date').value;
    var selectedShowtime = document.getElementById('showtime').value;
    var selectedPrice = document.getElementById('price').value;
    
    var availableTheaters = [];
    var availableDates = [];
    var availableShowtimes = [];
    var availablePrices = [];
    var availableSeats = [];

    schedules.forEach(function (schedule) {
        if ((!selectedTheater || schedule.Theater === selectedTheater) &&
            (!selectedDate || schedule.Date === selectedDate) &&
            (!selectedShowtime || schedule.Showtime === selectedShowtime) && 
            (!selectedPrice || schedule.Price === selectedPrice)) {

            // Push available options to arrays
            if (!availableTheaters.includes(schedule.Theater)) {
                availableTheaters.push(schedule.Theater);
            }
            if (!availableDates.includes(schedule.Date)) {
                availableDates.push(schedule.Date);
            }
            if (!availableShowtimes.includes(schedule.Showtime)) {
                availableShowtimes.push(schedule.Showtime);
            }
            if (!availablePrices.includes(schedule.Price)) {
                availablePrices.push(schedule.Price);
            }
            if (!availableSeats.includes(schedule.Seat)) {
                availableSeats.push(schedule.Seat);
            }
        }
    });

    
    // Update theater dropdown
    var theaterDropdown = document.getElementById('theater');
    theaterDropdown.innerHTML = '<option value="" disabled selected>Select a Theater</option>';
    availableTheaters.forEach(function (theater) {
        var option = document.createElement('option');
        option.value = theater;
        option.text = theater;
        theaterDropdown.appendChild(option);
    });
    if (selectedTheater && availableTheaters.includes(selectedTheater)) {
        theaterDropdown.value = selectedTheater;
    }

    // Update date dropdown
    var dateDropdown = document.getElementById('date');
    dateDropdown.innerHTML = '<option value="" disabled selected>Select a Date</option>';
    availableDates.forEach(function (date) {
        var option = document.createElement('option');
        option.value = date;
        option.text = date;
        dateDropdown.appendChild(option);
    });
    if (selectedDate && availableDates.includes(selectedDate)) {
        dateDropdown.value = selectedDate;
    }

    // Update showtime dropdown
    var showtimeDropdown = document.getElementById('showtime');
    showtimeDropdown.innerHTML = '<option value="" disabled selected>Select a Showtime</option>';
    availableShowtimes.forEach(function (showtime) {
        var option = document.createElement('option');
        option.value = showtime;
        option.text = showtime;
        showtimeDropdown.appendChild(option);
    });
    if (selectedShowtime && availableShowtimes.includes(selectedShowtime)) {
        showtimeDropdown.value = selectedShowtime;
    }

    // Update price dropdown
    var priceDropdown = document.getElementById('price');
    priceDropdown.innerHTML = '<option value="" disabled selected>Select a Price</option>';
    availablePrices.forEach(function (price) {
        var option = document.createElement('option');
        option.value = price;
        option.text = price;
        priceDropdown.appendChild(option);
    });
    if (selectedPrice && availablePrices.includes(selectedPrice)) {
        priceDropdown.value = selectedPrice;
    }

    // Update seat dropdown
    var availableSeats = schedules.find(function(schedule) {
        return schedule.Theater === selectedTheater && 
               schedule.Date === selectedDate &&
               schedule.Showtime === selectedShowtime
    });

    if (availableSeats) {
        document.getElementById('seat').value = availableSeats.Seat;
    } 
}



// Attach the filter function to dropdown changes
document.getElementById('theater').addEventListener('change', filterFields);
document.getElementById('date').addEventListener('change', filterFields);
document.getElementById('showtime').addEventListener('change', filterFields);
document.getElementById('price').addEventListener('change', filterFields);
document.getElementById('seat').addEventListener('change', filterFields);



function resetForm() {
    document.getElementById("theater").value = "";
    document.getElementById("date").value = "";
    document.getElementById("showtime").value = "";
    document.getElementById("price").value = "";
    document.getElementById("seat").value = "";
    document.getElementById("tickets").value = 1;
    filterFields();
}




</script>
  
</body>
</html>


<?php 
include 'conn.php';
include 'TopBar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>About Us</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <style>
    body {
      background-image: url("aboutus.jpg");
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      color: #ffffff; 
      background-attachment: fixed; /* Fixes the background image */

    }
    .about-section {
      padding: 50px 20px;
      color: #ffffff; /* Ensure paragraphs are white as well */
    }
    .about-section h1 {
      text-align: center;
      font-size: 36px;
      margin-bottom: 20px;
      color: #ffffff; /* White color for heading */
      font-weight: bold; /* Make the text bold */
    }
    .about-section h2, .about-section h3 {
      font-weight: bold;
      color: #ffffff; /* Ensure headings are white */
    }
    /* .about-section h2 {
      font-size: 32px;
      margin-bottom: 15px;
    } */
    .about-section h3 {
      font-size: 23px;
      margin-bottom: 10px;
      padding-left: 250px; /* Adjust this value to set your left gap */
      padding-right: 700px; /* Double the left gap for the right side */
      margin-top: 20px;
    }
    .about-section p {
    font-size: 17px;
    line-height: 1.5;
    text-align: justify; /* Justify text */
    padding-left: 250px; /* Adjust this value to set your left gap */
    padding-right: 700px; /* Double the left gap for the right side */
    margin: 0;
    font-weight: bold; /* Make the text bold */
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

<!-- About Us Section -->
<div class="about-section">
  <h1>About Us</h1>
  <h3>The First Multiplex Cinema Theatre in Bangladesh</h3>
  <p>
    STAR CINEPLEX : Show Motion Limited, incorporated on 19th December 2002, pioneered the modern Multiplex Movie Theater industry with STAR Cineplex brand in Bangladesh.<br><br>

    With lucid vision for the entertainment development in the country, the local and foreign promoters of Show Motion Ltd. started the first international quality state-of-the-art multiplex cinema theatre on 8th October 2004 in Bangladesh at Bashundhara City Mall at Panthapath, Dhaka.<br><br>

    In January 2019, STAR Cineplex opened another branch in Shimanto Shambhar. The new branch has 3 fully digital cinema screens with state-of-the-art 3D Projection Technology, Silver Screens, Dolby-Digital Sound and stadium seating. One of the 3 halls will have ATMOS sound system which will make the movie watching even more brilliant. Hall 1 has a seating capacity of 263, Hall 2 has that of 253 and 3 has the capacity of 221, totaling more than 730 seats.<br><br>

    STAR Cineplex, Bashundhara City shopping mall branch has six fully digital cinema screens with state-of-the-art 3D Projection Technology, Silver Screens, Dolby-Digital Sound and stadium seating. With a total capacity of 1,600 seats, the theater has a large lobby with full concession stands serving popcorn, soft drinks, ice-creams, and many other items. In addition to scheduled shows, STAR Cineplex also caters to special corporate bookings, red-carpet premieres, and private events. Visit www.cineplexbd.com for updated movie schedules and online ticket purchases.
  </p>

  <h3>Our Goal</h3>
  <p>
    Our goal is to provide the most modern, comfortable, cinema viewing experience of Hollywood and quality Dhallywood releases for a locally adjusted price for our youth and family-centered audiences in Dhaka. We aim to be the highest-value entertainment provider in Bangladesh with integrity & professionalism in every step.
  </p>
</div>

<!-- Bootstrap JS and Popper.js (required for Bootstrap components) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<?php  
include 'Footer.php';
?>
</body>
</html>

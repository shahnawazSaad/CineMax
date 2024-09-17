<?php 
include 'conn.php';
include 'TopBar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Theaters Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <style>
    body {
      background-image: url("pexels-pavel-danilyuk-7234214.jpg");
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center top;
      background-position: center -255px; 
      margin: 0;
      padding: 0;
      font-family: 'Arial', sans-serif;
      color: #f8f9fa;
      background-attachment: fixed; /* Fixes the background image */

    }
    .jumbotron {
      background: rgba(0, 0, 0, 0.6);
      color: #f8f9fa;
    }
    .card {
      background: rgba(0, 0, 0, 0.8);
      border: none;
      color: #f8f9fa;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
    }
    .card-title, .card-text {
      color: #f8f9fa;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
    .card-img-top {
    width: 100%;
    height: 250px; /* Adjust the height as needed */
    object-fit: cover; /* Ensures the image covers the entire area without distortion */
    border-radius: 0; /* Optional: Removes any border radius */
}

  </style>
</head>
<body>
<?php 
      // $userid = $_GET['userid']
 
     if (!isset($_GET['userid'])) {
         $userid = 0;
     } else {
        $userid = htmlspecialchars($_GET['userid']);
        include 'User_nav.php';  // user nav    
 
     }
  
     if (!isset($_GET['adminid'])) {
        // $userid_ad = 0;
         $adminid=0;
     } else {
        //$userid_ad=1;
        $adminid = htmlspecialchars($_GET['adminid']);
        include 'Admin_nav.php'; // admin nav
 
     }
  
     if($userid ==0 && $adminid==0)
     {
         include 'nav.php';  // Guest nav
     }
?>
  <!-- Jumbotron (Hero Section) -->
  <div class="jumbotron text-center">
    <h1 class="display-4">Welcome to Our Theaters</h1>
    <p class="lead">Experience the best cinematic entertainment in our theaters!</p>
  </div>

  <!-- Theater Listings -->
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="th3.jpg" class="card-img-top" alt="Theater 1">
          <div class="card-body">
            <h5 class="card-title">Theater 1</h5>
            <p class="card-text">Enjoy the latest blockbusters in a state-of-the-art facility.</p>
            <a href="#" class="btn btn-primary">Learn More</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="Theater-2.jpg" class="card-img-top" alt="Theater 2">
          <div class="card-body">
            <h5 class="card-title">Theater 2</h5>
            <p class="card-text">Immerse yourself in the world of cinema with our premium sound systems.</p>
            <a href="#" class="btn btn-primary">Learn More</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="Theater-3.jpg" class="card-img-top" alt="Theater 3">
          <div class="card-body">
            <h5 class="card-title">Theater 3</h5>
            <p class="card-text">Experience movies like never before in our comfortable seating.</p>
            <a href="#" class="btn btn-primary">Learn More</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="th-4.jpg" class="card-img-top" alt="Theater 1">
          <div class="card-body">
            <h5 class="card-title">Theater 4</h5>
            <p class="card-text">Enjoy the latest blockbusters in a state-of-the-art facility.</p>
            <a href="#" class="btn btn-primary">Learn More</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="Theater-5.jpg" class="card-img-top" alt="Theater 2">
          <div class="card-body">
            <h5 class="card-title">Theater 5</h5>
            <p class="card-text">Immerse yourself in the world of cinema with our premium sound systems.</p>
            <a href="#" class="btn btn-primary">Learn More</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="Theater-6.jpg" class="card-img-top" alt="Theater 3">
          <div class="card-body">
            <h5 class="card-title">Theater 6</h5>
            <p class="card-text">Experience movies like never before in our comfortable seating.</p>
            <a href="#" class="btn btn-primary">Learn More</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and Popper.js (required for Bootstrap components) -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <?php  
include 'Footer.php';?>
</body>
</html>

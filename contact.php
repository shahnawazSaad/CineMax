<?php 
include 'TopBar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Contact Page</title>
    <style>
        html, body {
            height: 100%;
            margin: 0 ;
            display: flex;
            flex-direction: column;
        }
        
        body {
    font-family: Arial, sans-serif;
    background-image: url('contact us.jpg'); 
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed; /* Fixes the background image */


}

        .content {
            flex: 1;
        }
        h2, label, button, strong {
            color: #ffffff;
            font-weight: bold;
        }
        .contact-container {
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, background 0.3s ease;
            margin-top: 50px;
        }
        .contact-container:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.9); /* Slightly less transparent on hover */
        }
        .contact-heading {
            color: black;
            text-align: center;
            margin-bottom: 20px;
        }
        .contact-info {
            color: black; /* Change to a dark color for better readability */
        }
        .maps-container {
            margin-top: 30px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .map-item {
            width: 48%; /* Two maps per row */
            margin-bottom: 15px;
        }
        .map-item iframe {
            width: 100%;
            height: 200px;
            border: 0;
        }
        .map-item h3 {
            margin-bottom: 10px;
            color: #ffffff; 
        }
    </style>
</head>
<body>
<?php 
      include 'conn.php';
     if (!isset($_GET['userid'])) {
         $userid = 0;
     } else {
        $userid = htmlspecialchars($_GET['userid']);
        include 'User_nav.php';  // user nav    
     }
     if (!isset($_GET['adminid'])) {
         $adminid=0;
     } else {
        $adminid = htmlspecialchars($_GET['adminid']);
        include 'Admin_nav.php'; // admin nav
     }
     if($userid ==0 && $adminid==0)
     {
         include 'nav.php';  // Guest nav
     }
?>
    <div class="container mt-5 content">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="contact-container">
                    <h2 class="contact-heading">Contact Us</h2>
                    <p class="contact-info">Please feel free to reach out to us using the contact information below:</p>
                    <ul class="list-group contact-info">
                        <li class="list-group-item">Email: <a href="mailto:info@example.com">info@example.com</a></li>
                        <li class="list-group-item">Phone: <a href="tel:+8801796545796">+880 1796-545796</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="maps-container">
            <div class="map-item">
                <h3>Star Cineplex ~ Sony Square - Mirpur-1</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.514432022977!2d90.35290527605228!3d23.80029938685745!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c15c3cfca391%3A0x18c46f2e75c2f64c!2sStar%20Cineplex%20~%20Sony%20Square%20-%20Mirpur-1!5e0!3m2!1sen!2sbd!4v1723538749129!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            
            </div>
            <div class="map-item">
               <h3>Star Cineplex - SKS Tower</h3>
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.1355772004413!2d90.3972433!3d23.778185999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c78aec2876a3%3A0xd88f0f59fd5f8077!2sStar%20Cineplex%20-%20SKS%20Tower!5e0!3m2!1sen!2sbd!4v1723538880882!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            
            </div>

            <div class="map-item">
              <h3>Star Cineplex - Bashundhara City</h3>
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.891173177097!2d90.38802717605127!3d23.751259888741973!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8a3303a6fbf%3A0xbc442f814508a7f0!2sStar%20Cineplex!5e0!3m2!1sen!2sbd!4v1723538936674!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            
            </div>
            
            <div class="map-item">
               <h3>Star Cineplex - Shimanto Shambhar</h3>
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.280342333811!2d90.37469757605092!3d23.737380389274747!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8ca5fc2992f%3A0x29c7e144c6374781!2sStar%20Cineplex%20-%20Shimanto%20Shambhar!5e0!3m2!1sen!2sbd!4v1723538987936!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            
            </div>

            <div class="map-item">
              <h3>Star Cineplex - Mohakhali Square</h3>
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.5359856059117!2d90.3839930760515!3d23.76392078825567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c758c36b3735%3A0xefd1575e361bb7e3!2sStar%20Cineplex!5e0!3m2!1sen!2sbd!4v1723539024992!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            
            </div>
            
            <div class="map-item">
               <h3>Star Cineplex - Dhanmondi</h3>
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.523804876803!2d90.3839403!3d23.764292000000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c758c36b3735%3A0xefd1575e361bb7e3!2sStar%20Cineplex!5e0!3m2!1sen!2sbd!4v1723539077002!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            
            </div>
        </div>
    </div>
<?php 
  include 'footer.php';
?>
</body>
</html>

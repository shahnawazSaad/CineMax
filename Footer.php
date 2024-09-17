<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinemax Footer Example</title>
    <style>
        .footer {
            background-color: #1a1a1a; /* Darker gray background */
            color: #ffffff;
            display: flex;
            justify-content: space-around;
            align-items: start;
            padding: 20px 250px; /* 250px padding for left and right */
            height: 200px;
            margin-top: 30px;
        }
        .footer-column {
            width: 22%;
        }
        .footer-column p {
            margin: 5px 0;
        }
        .footer .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .footer a {
            color: #ffffff;
            text-decoration: none;
            cursor: pointer;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        /* Copyright Section */
        .copyright {
            background-color: black; /* Full black background */
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Footer -->
    <div class="footer">
        <div class="footer-column">
            <img src="Bar_Logo.png" alt="Logo">
            <p>Show Motion Limited</p>
            <p>Level 8, Bashundhara City</p>
            <p>13/3 Ka, Panthapath, Tejgaon</p>
            <p>Dhaka 1215, Bangladesh.</p>
        </div>
        <div class="footer-column">
            <p>Contact Us</p>
            <p>Phone Number</p>
            <p>(+88) 09617660660</p>
            <p>01755665544</p>
        </div>
        <div class="footer-column">
            <p>Email Address</p>
            <p>info@cineplexbd.com</p>
        </div>
        <div class="footer-column">
            <p>More at Cineplex</p>
            <p><a id="privacyPolicyLink">Privacy & Policy</a></p>
            <p>Like Us On Facebook</p>
        </div>
    </div>

    <!-- Copyright Section -->
    <div class="copyright">
        <p>Copyright © 2024 Show Motion Limited. All Rights Reserved.</p>
    </div>

    <!-- Privacy & Policy Modal -->
    <div id="privacyModal" style="display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgba(0,0,0,0.9);padding-top:60px;color:#ffffff;">
        <div class="modal-content" style="background-color:#333333;margin:auto;padding:20px;border:1px solid #888;width:80%;max-width:800px;position:relative;box-shadow:0 4px 8px 0 rgba(0,0,0,0.2);">
            <span class="close" id="closeModal" style="position:absolute;right:20px;top:20px;font-size:30px;font-weight:bold;color:#aaa;">&times;</span>
            <h2 style="margin-top:0;font-size:24px;border-bottom:2px solid #fff;padding-bottom:10px;">Privacy Policy</h2>
            <!-- Include the rest of the privacy policy content here -->
            <p>The First Multiplex Cinema Theatre in Bangladesh, STAR Cineplex is the brand name of Show Motion Limited, pioneered in modern Multiplex Movie Theater industry in the country. With lucid vision for the entertainment development in the country, the local and foreign promoters of Show Motion Limited started the first international quality state-of-the-art multiplex cinema theatre on 8th October 2004 in Bangladesh at Bashundhara City Mall, Panthapath, Dhaka.</p>
            <h3>Our Policy</h3>
            <p>Welcome to the web site (the “Site”) of STAR Cineplex (cineplexbd.com). This Site is operated by STAR Cineplex and has been created to provide information about our company, whether accessible to you via web, mobile app or other platform (our services, together with the Site, are the “Services”) by visitors and users of the Services (“you” and/or “your”).
              STAR Cineplex collects information about you when you use our mobile applications, websites, and other online products and services (collectively, the “Services”) and through other interactions and communications you have with STAR Cineplex.
              Please read this privacy policy carefully so that you understand how we will treat your information. By using any of our Services, you confirm that you have read, understood and agree to this privacy policy. If you do not agree to this policy, please do not use any of the Services. If you have any queries, please email us at customerservices@cineplexbd.com</p>
            <h3>Information We Collect</h3>
            <p>Welcome to the web site (the “Site”) of STAR Cineplex (cineplexbd.com). This Site is operated by STAR Cineplex and has been created to provide information about our company, whether accessible to you via web, mobile app or other platform (our services, together with the Site, are the “Services”) by visitors and users of the Services (“you” and/or “your”).
              STAR Cineplex collects information about you when you use our mobile applications, websites, and other online products and services (collectively, the “Services”) and through other interactions and communications you have with STAR Cineplex.
              Please read this privacy policy carefully so that you understand how we will treat your information. By using any of our Services, you confirm that you have read, understood and agree to this privacy policy. If you do not agree to this policy, please do not use any of the Services. If you have any queries, please email us at customerservices@cineplexbd.com</p>
            <h3>Security</h3>
            <p>STAR Cineplex takes reasonable steps to protect the Personal Data provided via the Services from loss, misuse, and unauthorized access, disclosure, alteration, or destruction. However, no Internet or e-mail transmission is ever fully secure or error free; any transmission is at your own risk. In particular, e-mail sent to or from the Services may not be secure. Therefore, you should take special care in deciding what information you send to us via e-mail. Please keep this in mind when disclosing any Personal Data to STAR Cineplex via the Internet. Once we have received your information, we will use strict procedures and security features to try to prevent unauthorized access.</p>
            <p>Registered STAR Cineplex users will have an account name and password which enables you to access certain parts of our Services. You are responsible for keeping them confidential. Please don’t share them with anyone.</p>
            <h3>Contacting STAR Cineplex</h3>
            <p>To keep your Personal Data accurate, current, and complete, please contact us as specified below. We will take reasonable steps to update or correct Personal Data in our possession that you have previously submitted via the Services.</p>
            <p>Please also feel free to contact us if you have any questions about STAR Cineplex’s Privacy Policy or the information practices of the Services.</p>
            <p>You may contact us as follows:</p>
            <p>STAR Cineplex<br>
            Company: Show Motion Limited.<br>
            Address: Level 8, Bashundhara City, 13/3 Ka, Panthapath, Tejgaon, Dhaka 1215, Bangladesh.<br>
            Email: customerservices@cineplexbd.com</p>
        </div>
    </div>
    <script>
        // Get the modal
        var modal = document.getElementById('privacyModal');
        // Get the link that opens the modal
        var link = document.getElementById('privacyPolicyLink');
        // Get the <span> element that closes the modal
        var closeModal = document.getElementById('closeModal');
        // When the user clicks on the link, open the modal
        link.onclick = function() {
            modal.style.display = 'block';
        }
        // When the user clicks on <span> (x), close the modal
        closeModal.onclick = function() {
            modal.style.display = 'none';
        }
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>

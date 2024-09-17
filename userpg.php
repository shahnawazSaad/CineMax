<?php 
session_start();
include 'conn.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email_log"])) {
        $email = $_POST["email_log"];
        $password = $_POST["password_log"];

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
    } else {
        $Name = $_POST["fname"];
        $FirstName = $_POST["name"];
        $email = $_POST["email"];
        $Phone = $_POST["Phone"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $cnt_email=0;
        $cnt_user=0;
        $cnt_phn=0;

        $movie_info_query = "SELECT email,username,Phone from user"; 
        $movie_info_result = $conn->query($movie_info_query);

  
            while ($row = $movie_info_result->fetch_assoc()) {
               if($email==$row["email"])
               {
                 $cnt_email++;
               }
               if( $FirstName==$row["username"])
               {
                $cnt_user++;
               }
               if( $Phone==$row["Phone"])
               {
                $cnt_phn++;
               }

            }

        if ($_POST["password"] != $_POST["conpassword"]) {
            $message = "Password not match.";
        }
        elseif($cnt_email>=1){
            $message = "Email already exist!";
        }
        elseif($cnt_user>=1){
            $message = "Username already exist!";

        }
        elseif($cnt_phn>=1){
            $message = "Phone number already exist!";

        }
        else {

            $query = "INSERT INTO user (Name, username, Phone, Email, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt === false) {
                die("Error preparing the statement: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "sssss", $Name, $FirstName, $Phone, $email, $password);

            if (mysqli_stmt_execute($stmt)) {
                $message = "Signup successful!";
            } else {
                $message = "Error executing the query: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Sign In / Sign Up Form</title>
    <style>
        :root {
            --white: #e9e9e9;
            --gray: #333;
            --blue: #0367a6;
            --lightblue: #008997;
            --button-radius: 0.7rem;
            --max-width: 758px;
            --max-height: 450px;
            font-size: 12.3px;
            font-family:"Segoe UI", "Open Sans", "Helvetica Neue", sans-serif;
        }

        body {
            align-items: center;
            background-color: var(--white);
            background: url("/MTB/Images/aboutus.jpg");
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: grid;
            height: 100vh;
            place-items: center;
        }

        .form__title {
            font-weight: 300;
            margin: 0;
            margin-bottom: 1.25rem;
        }

        .link {
            color: var(--gray);
            font-size: 0.9rem;
            margin: 1.5rem 0;
            text-decoration: none;
        }

        .container {
            background-color: var(--white);
            border-radius: var(--button-radius);
            box-shadow: 0 0.9rem 1.7rem rgba(0, 0, 0, 0.25), 0 0.7rem 0.7rem rgba(0, 0, 0, 0.22);
            height: var(--max-height);
            max-width: var(--max-width);
            overflow: hidden;
            position: relative;
            width: 100%;
        }

        .container__form {
            height: 100%;
            position: absolute;
            top: 0;
            transition: all 0.6s ease-in-out;
        }

        .container--signin {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.right-panel-active .container--signin {
            transform: translateX(100%);
        }

        .container--signup {
            left: 0;
            opacity: 0;
            width: 50%;
            z-index: 1;
        }

        .container.right-panel-active .container--signup {
            animation: show 0.6s;
            opacity: 1;
            transform: translateX(100%);
            z-index: 5;
        }

        .container__overlay {
            height: 100%;
            left: 50%;
            overflow: hidden;
            position: absolute;
            top: 0;
            transition: transform 0.6s ease-in-out;
            width: 50%;
            z-index: 100;
        }

        .container.right-panel-active .container__overlay {
            transform: translateX(-100%);
        }

        .overlay {
            background-color: var(--lightblue);
            background: url("/MTB/Images/aboutus.jpg");
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100%;
            left: -100%;
            position: relative;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
            width: 200%;
        }

        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .overlay__panel {
            align-items: center;
            display: flex;
            flex-direction: column;
            height: 100%;
            justify-content: center;
            position: absolute;
            text-align: center;
            top: 0;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
            width: 50%;
        }

        .overlay--left {
            transform: translateX(-20%);
        }

        .container.right-panel-active .overlay--left {
            transform: translateX(0);
        }

        .overlay--right {
            right: 0;
            transform: translateX(0);
        }

        .container.right-panel-active .overlay--right {
            transform: translateX(20%);
        }

        .btn {
            background-color: black;
            border-radius: 20px;
            border: 1px solid var(--blue);
            color: var(--white);
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: bold;
            letter-spacing: 0.1rem;
            padding: 0.9rem 4rem;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
        }

        .overlay .btn {
            background-color: transparent;
            border: 2px solid var(--white);
        }

        .form > .btn {
            margin-top: 1.5rem;
        }

        .btn:active {
            transform: scale(0.95);
        }

        .btn:focus {
            outline: none;
        }

        .form {
            background-color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 3rem;
            height: 100%;
            text-align: center;
        }

        .input {
            background-color: #fff;
            border: none;
            padding: 0.9rem 0.9rem;
            margin: 0.5rem 0;
            width: 100%;
        }

        @keyframes show {
            0%,
            49.99% {
                opacity: 0;
                z-index: 1;
            }

            50%,
            100% {
                opacity: 1;
                z-index: 5;
            }
        }
    </style>
</head>
<body>

    <div class="container right-panel-active">
        <!-- Sign Up -->
        <div class="container__form container--signup">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="form" id="form1">
                <h2 class="form__title">Sign Up</h2>
                <input type="text" placeholder="Full Name" class="input"  id="fname" name="fname" required/>
                <input type="text" placeholder="Username" class="input"  id="name" name="name" required/>
                <input type="email" placeholder="Email" class="input"  id="email" name="email" required/>
                <input type="text" placeholder="Phone" class="input"  id="Phone" name="Phone" required/>
                <input type="password" placeholder="Password" class="input" id="password" name="password" required/>
                <input type="password" placeholder="Confirm Password" class="input" id="conpassword" name="conpassword" required/>
                <button type="submit" class="btn">Sign Up</button>
            </form>
        </div>

        <!-- Sign In -->
        <div class="container__form container--signin">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="form" id="form2">
                <h2 class="form__title">Sign In</h2>
                <input type="email" placeholder="Email" class="input" id="email_log" name="email_log" required/>
                <input type="password" placeholder="Password" class="input" id="password_log" name="password_log" required/>
                <a href="Admin_Login.php" class="link">Are you admin?</a>
                <button type="submit" class="btn">Sign In</button>
            </form>
        </div>

        <!-- Overlay -->
        <div class="container__overlay">
            <div class="overlay">
                <div class="overlay__panel overlay--left">
                    <button class="btn" id="signIn">Sign In</button>
                </div>
                <div class="overlay__panel overlay--right">
                    <button class="btn" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
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

    <script>
        const signInButton = document.getElementById('signIn');
        const signUpButton = document.getElementById('signUp');
        const container = document.querySelector('.container');

        signInButton.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });

        signUpButton.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        <?php if ($message != ''): ?>
            $(document).ready(function() {
                $('#messageModal').modal('show');
            });
        <?php endif; ?>
    </script>

</body>
</html>

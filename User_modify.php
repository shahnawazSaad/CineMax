<?php
session_start();


$uid =$_GET['userid'];


// Include the database connection file
include 'conn.php';
include 'TopBar.php';

//$uid = $_SESSION['uid'];
//$userid=1; // Temporary line for testing, should use actual session value in production
// Fetch user details using user ID
$userSql = "SELECT name, username, email, phone , password FROM user WHERE userid = ?";
$stmt = $conn->prepare($userSql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$userResult = $stmt->get_result();
$userData = $userResult->fetch_assoc();

$password = $userData['password'];
$fullname = $userData['name'];
$username = $userData['username'];
$email = $userData['email'];
$phone = $userData['phone'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newPhone = $_POST['phone'];
    $newPassword = $_POST['password'];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Prepare an update statement
    $updateStmt = $conn->prepare("UPDATE user SET phone = ?, password = ? WHERE userid = ?");
    $updateStmt->bind_param("ssi", $newPhone, $hashedPassword, $uid);

    // Execute the update statement
    if ($updateStmt->execute()) {
        echo "<script>alert('Profile updated successfully!');</script>";
        $phone = $newPhone; // Update the phone in the current session
    } else {
        echo "<script>alert('Error updating profile: " . $conn->error . "');</script>";
    }

    // Close the statement
    $updateStmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="test.css">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a202c; /* Dark background */
            font-family: 'Roboto', sans-serif; /* Font style */
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 2rem;
        }
        .profile-info {
            background: rgba(45, 55, 72, 0.8); /* Darker background with transparency */
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .profile-info:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #f7fafc;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.375rem;
            border: 1px solid #4a5568;
            background: #1a202c;
            color: #f7fafc;
            transition: border-color 0.3s ease-in-out, background-color 0.3s ease-in-out;
        }
        .form-group input:focus {
            border-color: #2b6cb0;
            background: #2d3748;
        }
        .btn {
            display: inline-block;
            background: #4a5568;
            color: #f7fafc;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }
        .btn:hover {
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




    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold mb-8 text-center text-gray-100">Your Profile</h1>
        <div class="profile-info">
            <form action="" method="post">
                <div class="form-group">
                    <label for="full-name">Full Name</label>
                    <input type="text" id="full-name" name="full_name" value="<?php echo htmlspecialchars($fullname); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="user-name">User Name</label>
                    <input type="text" id="user-name" name="user_name" value="<?php echo htmlspecialchars($username); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                </div>
                <div class="form-group">
                    <label for="password">Current Password</label>
                    <input type="text" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" value="">
                </div>
                <button type="submit" class="btn w-full">Update Profile</button>
            </form>
        </div>
    </div>


    <script>
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
    <?php  
include 'Footer.php';?>
</body>
</html>

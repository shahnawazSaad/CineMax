<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Website</title>
    <!-- <link rel="stylesheet" href="test.css"> -->
    <style>
    nav {
            background-color: rgba(0, 0, 0, 0.9); 
            color: #fff;
            height: 50px; 
            display: flex;
            align-items: center;
            position: relative;
            padding: 10px;
        }
        .nav-links {
            margin-left: 240px; /* 250px gap from the left side */
            display: flex;
            gap: 10px;
        }
        .nav-links a {
            color: #fff;
            text-decoration: none;
            padding: 8px 15px;
            border: 1px solid transparent;
            border-radius: 5px;
        }
        .nav-links a:hover {
            background-color: white;
            color: rgb(127, 23, 23);
        }
        .search-bar {
            display: none;
            align-items: center;
            gap: 10px;
            background-color: white;
            padding: 5px;
            border-radius: 5px;
        }
        .search-bar.active {
            display: flex;
        }
    </style>
</head>
<body>



<nav>
    <div class="nav-links">
    <a href="./Testhome.php?adminid=<?php echo $adminid; ?>">Home</a>
    <a href="./showtime.php?adminid=<?php echo $adminid; ?>">Showtime</a>
    <a href="./theaters.php?adminid=<?php echo $adminid; ?>">Theaters</a>
    <a href="./contact.php?adminid=<?php echo $adminid; ?>">Contact Us</a>
    <a href="./AboutUs.php?adminid=<?php echo $adminid; ?>">About Us</a>
    <a href="./admin_dashboard.php?adminid=<?php echo $adminid; ?>">Admin</a>
        
    </div>

    <!-- <div class="search-bar">
        <input type="text" placeholder="Search...">
        <button type="submit"><i class="fa fa-search"></i></button>
    </div> -->
       
</nav>

</body>
</html>
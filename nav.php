<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Website</title>
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
<body class="bg-black text-white">

<nav>
    <div class="nav-links">
        <a href="Testhome.php">Home</a>
        <a href="./showtime.php">Showtime</a>
        <a href="./theaters.php">Theaters</a>
        <a href="./contact.php">Contact Us</a>
        <a href="./AboutUs.php">About Us</a>
        <a href="./userpg.php">User Login</a>
    </div>
</nav>


</body>
</html>

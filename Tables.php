<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "SDProjectNew";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "CREATE TABLE Booking (
        BookingId INT PRIMARY KEY AUTO_INCREMENT,
        UserID VARCHAR(255) NOT NULL,
        MovieID VARCHAR(255) NOT NULL,
        Theater VARCHAR(255) NOT NULL,
        date DATE NOT NULL,
        Price INT NOT NULL,
        Showtime VARCHAR(50) NOT NULL,
        Tickets INT NOT NULL
    )";
    
    $sql2 = "CREATE TABLE Movies (
        MovieID INT PRIMARY KEY AUTO_INCREMENT,
        MovieName VARCHAR(255) NOT NULL,
        Cast VARCHAR(255) NOT NULL,
        Language VARCHAR(255) NOT NULL,
        ReleaseDate DATE NOT NULL,
        Genre VARCHAR(50) NOT NULL,
        Trailer TEXT NOT NULL,
        Synopsis TEXT NOT NULL,
        Schedule VARCHAR(50) NOT NULL,
        Rating DOUBLE,
        Poster BLOB NOT NULL,
        Background BLOB NOT NULL

    )";

$sql3 = "CREATE TABLE User (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    UserName VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Phone VARCHAR(255) NOT NULL,
    Complaint TEXT,
    Password VARCHAR(2555) NOT NULL
)";
$sql4 = "CREATE TABLE MovieDetails (
    MovieDetailsID INT PRIMARY KEY AUTO_INCREMENT,
    MovieID INT NOT NULL,
    Theater VARCHAR(255) NOT NULL,
    Date DATE NOT NULL,
    Showtime VARCHAR(50) NOT NULL,
    Seat INT NOT NULL,
    Price INT NOT NULL,
    FOREIGN KEY (MovieID) REFERENCES Movies(MovieID)
)";
$sql5 = "CREATE TABLE Feedback (
    Feedback INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT NOT NULL,
    MovieID INT NOT NULL,
    Rating DOUBLE NOT NULL,
    FOREIGN KEY (MovieID) REFERENCES Movies(MovieID),
    FOREIGN KEY (UserID) REFERENCES User(UserID)
)";

    if (mysqli_query($conn, $sql)) {
        echo "<h4> Booking Table Booking created successfully </h4>";
    } else {
        echo "Error creating table Booking: " . mysqli_error($conn);
    }
    
    if (mysqli_query($conn, $sql2)) {
        echo " <h4>Movies Table Booking created successfully </h4>";
    } else {
        echo "Error creating table Movies: " . mysqli_error($conn);
    }
    
    if (mysqli_query($conn, $sql3)) {
        echo " <h4> User Table Booking created successfully </h4>";
    } else {
        echo "Error creating table User: " . mysqli_error($conn);
    }

    if (mysqli_query($conn, $sql4)) {
        echo "<h4>MovieDetails Table created successfully</h4>";
    } else {
        echo "Error creating table MovieDetails: " . mysqli_error($conn);
    }
    if (mysqli_query($conn, $sql5)) {
        echo "<h4>Feedback Table created successfully</h4>";
    } else {
        echo "Error creating table Feedback: " . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
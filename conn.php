<?php
    
    // $movieName = $_POST['movieName'];
    // $theater = $_POST['theater'];
    // $date = $_POST['date'];
    // $showtime = $_POST['showtime'];
    // $tickets = $_POST['tickets'];
    
    //Database Connection
  
    $conn = new mysqli('localhost','root','','SDProjectNew');
    if($conn->connect_error)
    {
      
      die('Connection Failed : '.$conn->connect_error);
    // }else{
    //   $stmt = $conn->prepare("insert into Booking(movieName,theater,date,showtime,tickets) values(?,?,?,?,?)");
    //   $stmt->bind_param("ssssi",$movieName , $theater , $date , $showtime , $tickets);
    //   $stmt->execute();
    //   $stmt->close();
    //   $conn->close();
     }

?>
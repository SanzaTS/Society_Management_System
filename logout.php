<?php

include("session.php");
include("connection.php"); 


$name = $_SESSION['name'];
   // echo $username;
   
 //   $sql = "UPDATE `user` SET `active`='offline' WHERE `username` = '$username' ";

   $sql =  "UPDATE user SET active = 'offline' WHERE email = '$name' ";

    if(mysqli_query($con,$sql))
    {
        session_unset();

        session_destroy();
        
        header("location:index.php");
    }
    else{
        echo "Something Went Wrong";
    }

   





?>
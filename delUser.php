<?php

include("session.php");
include("connection.php");

$id = $_GET['id'];
$role = $_GET['role'];


if($role =="user")
{
   $memId = "SELECT memberId FROM member WHERE user_id = $id";
   $query = mysqli_query($con,$memId);

   while($data = mysqli_fetch_array($query))
   {
       $memberId = $data['memberId'];
   }

   if(mysqli_query($con,"DELETE FROM payment WHERE member_id = $memberId"))
   {
       if(mysqli_query($con,"DELETE FROM member  WHERE user_id = $id "))
       {
           if(mysqli_query($con,"DELETE FROM user_role WHERE user_id = $id"))
           {
               if(mysqli_query($con,"DELETE FROM user WHERE userId = $id"))
               {
                   header("location:users.php");
               }
           }
       }
   }
}
else
{
    if(mysqli_query($con,"DELETE FROM admin  WHERE userId = $id "))
    {
        if(mysqli_query($con,"DELETE FROM user_role WHERE user_id = $id"))
        {
            if(mysqli_query($con,"DELETE FROM user WHERE userId = $id"))
            {
                header("location:users.php");
            }
        }
    }

}

//$message ="user deleted id: ".$id." role: ".$role;
//echo "<script>alert('$message');</script>";

//header("location:users.php");


?>
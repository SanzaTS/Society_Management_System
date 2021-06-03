<?php
include("session.php");
include("connection.php");
include("funtions.php");



  $mId = $_GET['id'];
  $owing = $_GET['owing'];


  $userDetails = "SELECT u.email,m.name FROM user u, member m WHERE u.userId = m.user_id AND m.memberId = $mId";

  $results = mysqli_query($con,$userDetails);

  while($row = mysqli_fetch_array($results))
  {
      $email = $row['email'];
      $name = $row['name'];
  }

  if($owing == "both")
  {
      $owing = "Premium & FOOD";
  }
 
 /* $massage = "mener id = ".$mId ." and Owing ".$owing ."Email to send to ".$email;
  echo "<script>alert('$massage');</script>";*/

  //header("location:outstanding.php")
   $subject = "Outstanding Amount";



 $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 </head>
 <body>

 <div>
         <p> Hi ' . $name . '.</p>
         <p> </p>
         <p>This is the reminder to pay for  your outsatand fees. </p>
         <p>You need to pay for : '. $owing.' </p>
         <p>Please note your fees will be added with your current month durring payment </p>
         <p>Please click the following link to check your infnormation "<a href ="http://localhost//Society_Management_System/index.php"  target="_blank">Society Mangement System</a>"</p>
         <p> </p>
         <p> </p>
         <p>Regards </p>
         <p> Admin </p>


 </div>
 </body>
 </html>';



if(sendMail($email,$subject,$body))
{
    $massage = "Email Sent Succesfully";

    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Email Sent Succesfully');
    window.location.href='outstanding.php';
    </script>");


   
  /*  echo '<script>alert('.$massage.')</script>';
    
    header("location:outstanding.php");*/
}
else
{
    $massage = "Email Sending  failed";


    
   /* echo '<script>alert('.$massage.')</script>';
    header("location:outstanding.php");*/

    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Email Sending  failed');
    window.location.href='outstanding.php';
    </script>");
}
  
?>
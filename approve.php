<?php
include("session.php");
include("connection.php");
include("funtions.php");

$mid = $_GET['id'];
$amount = $_GET['amount'];

$update = "UPDATE claim SET status = 'Approved' WHERE member_id = $mid";

if(mysqli_query($con, $update) or die(mysqli_error($con)))
{
   // header("location:claimApplications.php");
   $query = "SELECT user.email,member.name
              FROM user,member
              WHERE user.userId = member.user_id
              AND member.memberId = $mid";

   $reults = mysqli_query($con, $query) or die(mysqli_error($con));

   while($row = mysqli_fetch_array($reults))
   {
       $email = $row['email'];
       $name = $row['name'];
   }

   
   $subject = "Claim Application Approved";
            
   $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
   <html xmlns="http://www.w3.org/1999/xhtml">
   <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   </head>
   <body>

   <div>
       
          <p>Hi  '.$name.' </p>
          <p> </p>
          <p> </p>
           <p> </p>
           <p>Your application has been approved . </p>
           <p>Amount to be paid is  R'.$amount.' will be be proccessed in 2 to 3 working days </p>
           <p> </p>
           <p> </p>
           
           <p>Regards </p>
           <p> Admin </p>


   </div>
   </body>
   </html>';

   if(sendMail($email,$subject,$body))
   {
     //  $error = "Application competed awaiting approval";
     header("location:claimApplications.php?success");
   }

}


?>
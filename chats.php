<?php

include("session.php");
include("connection.php");

$name = $_SESSION['name'];

$error = " ";

if(isset($_POST['send']))
{
   $reciever = mysqli_real_escape_string($con,$_POST['user']) ;
   $msg = mysqli_real_escape_string($con,$_POST['msg']);
   $date = date("d/m/Y");
   $time = date("H:i:s");
   
   if(!isset($_POST['MyRadio']))
   {
       die;
   }

   $priority = mysqli_real_escape_string($con,$_POST['MyRadio']);
 
  /* if(empty($reciever))
   {
    $message ="Massage failed to ";
    echo "<script>alert('$message');</script>";
   }
*/
  // $exec = "INSERT INTO chat(sender, reciever, msg, date, time) VALUES('$name','$reciever','$date','$time')";
   $exec ="INSERT INTO `chat`( `sender`, `reciever`, `msg`, `date`, `time`, `priority`) VALUES ('$name','$reciever','$msg','$date','$time','$priority')";
  // $exec = "INSERT INTO `chat`(`sender`, `reciever`, `msg`, `date`, `time`) VALUES ('admin@gmail.com','sanelesithole001@gmail.com','Did you recieve my massege','30/05/2021','14:17:51')";

  if(mysqli_query($con,$exec) or die(mysqli_error($con)))
   {
        $message ="Massage sent to ".$reciever;
        echo "<script>alert('$message');</script>";
   }
   else {

    $message ="Something went wrong could not  send the massaage to ".$reciever. " - ". mysqli_error($con);
    echo "<script>alert('$message');</script>";
      //mysqli_error($con);

   }

}


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Society Management System</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Society Management<br/> System</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <!---
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            
            <!-- Navbar-->
            <!--
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fas fa-user fa-fw"></i></a>
                </li>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#!">Settings</a>
                    <a class="dropdown-item" href="#!">Activity Log</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="login.html">Logout</a>
                </div>
            </ul>
           

            <!----  Cheeking --->

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow-none d-md-inline-block  ml-auto mr-0 mr-md-3 my-2 my-md-0">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user fa-fw green-text"></i>
                <span class="mr-2 d-none d-lg-inline text-white -600 small"> </span>
               <!-- <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"> -->
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="userProfile.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          <!---- end checking --->
        </nav>
        <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <!--< a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>-->
                            <div class="sb-sidenav-menu-heading">Society Mangement System</div>
                             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                             <!--   <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                 Actions
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                             </a>-->
                             <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                   <!-- <a class="nav-link" href="addUser.php">Add User</a> -->
                                    

                                    <!--<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#payments" aria-expanded="false" aria-controls="payments">
                                    
                                        Make Payments
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>-->
                                    <div class="collapse" id="payments" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <!--<nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="payment.php">Cash</a>
                                            <a class="nav-link" href="instant.php">Instant</a>
                                        
                                        </nav>-->
                                    </div>
                                      
                                </nav>
                             </div>


                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Views
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                   <!-- <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Users
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="newUsers.php">New Users</a>
                                            <a class="nav-link" href="users.php">All Users</a>
                                            <a class="nav-link" href="membersReport.php"> Members</a>
                                        </nav>
                                    </div>  -->
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Payments
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="perUser.php"> Payments</a>
                                            <a class="nav-link" href="userOutstanding.php">Outsanding Payments</a>
                                            <a class="nav-link" href="annual.php"> Anuall Payment</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Events and Communication</div>
                            <a class="nav-link" href="calender.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Calender
                            </a>
                            <a class="nav-link" href="chats.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Notifications
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $name."[Member]"; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Notification</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Send and Recieve Notifications</li>
                        </ol>

                        <div class="card-body">
                                        <!-- Dropdown Card Example -->
                                        <div class="text-center">
                                                   <td>  <a href="" class="btn btn-success btn-rounded mb-4" data-toggle="modal" data-target="#modalLoginForm2">Send Notification</a></td>
                                                </div>


              <div class="modal-body mx-3">
              <form  method="post"  action="chats.php">
              
                <div class="modal fade" id="modalLoginForm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Send Notification</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> 
              <div class="modal-body mx-3">
              <form  method="post"  action="outstanding.php">
                <div class="md-form mb-5">
                  <i class="fas fa-user prefix grey-text"></i>
                  
                  <select id="defaultForm-email" class="form-control validate" name="user"> 
                  <option>--Select Reciever</option>
                      <?php
                             $query = "select * from user WHERE email <> '$name'";
                             $results = mysqli_query($con,$query);
                             while($row =mysqli_fetch_array($results))
                             {
                                 $uName = $row['email'];
      
                                 ?>
      
                                  <option value="<?php echo $uName; ?>"><?php echo $uName;?><option>
      
      
                                 <?php
      
                             }
                      ?>
                  </select>
                  <label data-error="wrong"   data-success="right" for="defaultForm-email">Email </label>
                </div>

                <div class="md-form mb-4">
                  <i class="fas fa-book prefix grey-text"></i>
                  <textarea class="form-control" rows="3" id="defaultForm-pass" name="msg" maxlength="50"></textarea>
                  <label data-error="wrong" data-success="right" for="defaultForm-pass">Massage</label>
                </div>

                <div class="md-form mb-4">
               <!--   <i class="fas fa-book prefix grey-text"></i> -->
                <!--  <input type="text"  name = "title" id="defaultForm-pass" class="form-control validate">  -->
                <input type="radio" name="MyRadio" id="defaultForm-pass"  value="High" checked>High Importance <!--This one is automatically checked when the user opens the page -->
                <input type="radio" name="MyRadio"  id="defaultForm-pass"  value="Low">Low Importance <br>
                <label data-error="wrong" data-success="right" for="defaultForm-pass"Priority </label>
                </div>

 
               
              </div>
              <div class="modal-footer d-flex justify-content-center">
                <button type="submit" name="send" class="btn btn-success">Send  </button>
              </div>
              <form>
            </div>
          </div>
        </div>                                      
<div class="card shadow mb-4">
  <!-- Card Header - Dropdown -->
  <?php 
      
     $query = "select * from chat WHERE reciever = '$name'";
       
      $results = mysqli_query($con,$query);
     
     if(mysqli_num_rows($results) > 0  )
     {
      while($row = mysqli_fetch_array($results))
      {
        $id  = $row['id'];
        $sender = $row['sender'];
        $msg = $row['msg'];
        $date = $row['date'];
        $time = $row['time'];
        $priority = $row['priority'];

        $priority = $row['priority'];

        if($priority == "High")
        {
            $color= "danger";
        }
        else
        {
            $color= "warning";
        }
        
      

  ?>
  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
    <h4 class="m-0 font-weight-bold text-primary">Notifications</h4><br>
   
    
  </div>
  <!-- Card Body -->
  <div class="card-body">
    
     
     <br>
    
     <h6 style="color:orange;"> <?php echo $sender."        ".$date."    ".$time;?><h6>
    
     <br>
     <p class="m-0 font-weight-bold text-<?php  echo $color;?>" style="<?php echo $color; ?>"><?php echo $msg; ?></p><br>

     
     
     
  </div>

  <?php
   }
}
else{
?>
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
    <h4 class="m-0 font-weight-bold text-primary">Notifications</h4><br>
    <p class="m-0 font-weight-bold text-primary"> No massages recieved </p><br>

<?php

}

?>
</div>

                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                           <div class="text-muted">Copyright &copy; Society Management System</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>

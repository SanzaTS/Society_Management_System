<?php

include("session.php");
include("connection.php");

$name = $_SESSION['name'];

$error = " ";

if(isset($_POST['SAVE']))
{
    $id = mysqli_real_escape_string($con,$_POST['user']);
    $membership = mysqli_real_escape_string($con,$_POST['membership']);
    $amount = mysqli_real_escape_string($con,$_POST['amount']);
    $date = date("Y-m-d");

    if(is_numeric($amount))
    {
        if($id != "noselection")
        {
            if($membership !="none")
            {
                if($membership == "Premium")
                {
                    if($amount >= 120)
                    {
                        if($amount == 120)
                        {
                            $premium = "INSERT INTO payment(payment_date, amount, optionId, member_id, fee_id) VALUES ('$date',$amount,1,$id,2)";

                            if(mysqli_query($con,$premium) or die(mysqli_error($con)))
                            {
                               
                                $error = "Payement completed";

                            }
                            else {
                                $error ="Payment could not be competed,  something went wrong!";
                            }

                        }
                        else {
                            //
                        }

                    }
                    else {
                        $error ="A minimum of  R120 is required to make Premium Payment";
                    }
                }
                elseif ($membership == "Food") {
                    if($amount >= 90)
                    {
                        if($amount == 90)
                        {

                            $food = "INSERT INTO payment(payment_date, amount, optionId, member_id, fee_id) VALUES ('$date',$amount,1,$id,1)";

                            if(mysqli_query($con,$food) or die(mysqli_error($con)))
                            {
                               
                                $error = "Payement completed";

                            }
                            else {
                                $error ="Payment could not be competed,  something went wrong!";
                            }

                        }
                        else {
                            //
                        }

                    }
                    else{
                        $error ="A minimum of  R90 is required to make Food Payment";
                    }
                }
                elseif ($membership == "Both") {
                    if($amount >= 210)
                    {
                        if($amount == 210)
                        {
                            $bundle = "INSERT INTO payment(payment_date, amount, optionId, member_id, fee_id) VALUES ('$date',$amount,1,$id,3)";

                            if(mysqli_query($con,$bundle) or die(mysqli_error($con)))
                            {
                               
                                $error = "Payement completed";

                            }
                            else {
                                $error ="Payment could not be competed,  something went wrong!";
                            }
                        }
                        else {
                            //
                        }

                        
                    }
                    else {
                        $error ="A minimum of  R210 is required to make Premium & Food Payment";
                    }
                }

            }
            else{
                $error = "Menbership must be selected before you make payement";
            }

        }
        else{
            $error = "Member must be selected before you make payement";
        }

    }
    else
    {
      $error = "The Amount must be digits";
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
            <a class="navbar-brand" href="index.html">Society Management<br/> System</a>
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
                <a class="dropdown-item" href="adminUpdate.php">
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
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Society Mangement System</div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Actions
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="addUser.php">Add User</a>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#payments" aria-expanded="false" aria-controls="payments">
                                    
                                    Make Payments
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="payments" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="payment.php">Cash</a>
                                        <a class="nav-link" href="#">Instant</a>
                                    
                                    </nav>
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
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Users
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="newUsers.php">New Users</a>
                                            <a class="nav-link" href="users.php">All Users</a>
                                            <a class="nav-link" href="membersReport.php"> Members</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Payments
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="userPay.php"> Per User</a>
                                            <a class="nav-link" href="outstanding.php">Outsanding Payments</a>
                                            <a class="nav-link" href="paymentReports.php"> All Payment</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="events.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Calender
                            </a>
                            <a class="nav-link" href="notification.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Notifications
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $name. " [ADMIN]"; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Payments</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Make user payment(Cash)</li>
                        </ol>

                        <div class="card-body">
                                        <form action="payment.php" method="post">
                                        <label class="text-center font-weight-bold my-4" style="color:red;"><?php echo $error; ?></label>
                                           <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Members List</label>
                                                <select class="form-control" name="user"> 
                                                    
                                                  <option value="noselection"> select member</option>
                                                  <?php
                                                            $userQuery = mysqli_query($con,"SELECT memberId,name,surname FROM member");

                                                            while($row = mysqli_fetch_array($userQuery))
                                                            {
                                                                $name = $row['name'];
                                                                $surname = $row['surname'];
                                                                $id = $row['memberId'];
                                                                $fullName = $name. " " .$surname;

                                                 ?>                
                                                                <option value="<?php echo $id  ?>"  > <?php echo $fullName  ?> </option>

                                                <?php                

                                                            }
                                                  ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Membership</label>
                                                <select class="form-control" name="membership"> 
                                                    
                                                  <option value="none"> Select Product</option>
                                                  <option value="Premium"> Premium</option>
                                                  <option value="Food"> Food</option>
                                                  <option value="Both"> Premium & Food</option>
                                                  
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Amount</label>
                                                <input class="form-control py-4" name="amount" id="inputEmailAddress" type="text" aria-describedby="emailHelp" placeholder="Enter amount to pay" />
                                            </div>
                                            
                                            <div class="form-group mt-4 mb-0"><button type="submit" name="SAVE" class="btn btn-success">Make Payment</button><br></div>
                                            
                                        </form>

                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
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

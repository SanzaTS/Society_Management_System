<?php

include("session.php");
include("connection.php");

$name = $_SESSION['name'];
$message = "";

mysqli_query($con, "DELETE FROM reserve WHERE amount = '0' ");

if(isset($_POST['pay']))
{
    $mid = mysqli_real_escape_string($con,$_POST['id']);
    $membership = mysqli_real_escape_string($con,$_POST['membership']);
    $amount = mysqli_real_escape_string($con,$_POST['amount']);
    $date = date("Y-m-d");
   
    $query = mysqli_query($con,"SELECT amount FROM reserve WHERE memberId = $mid");

    while($row = mysqli_fetch_array($query))  
    {
        $reserve = $row['amount'];
    } 

     
    if(!empty($amount))
    {
    
        if(is_numeric($amount))
        {
            
                if($membership !="none")
                {
                    if($membership == "Premium")
                    {
                        if($amount >= 120)
                        {
                            if($amount == 120)
                            {


                                $total = $reserve -$amount;

                               


                               $premium = "INSERT INTO payment(payment_date, amount, optionId, member_id, fee_id) VALUES ('$date',$amount,1,$mid,2)";
    
                                if(mysqli_query($con,$premium) or die(mysqli_error($con)) or die(mysqli_error($con)) )
                                {
                                    if(mysqli_query($con,"UPDATE `reserve` SET `amount`= '$total' WHERE memberId = $mid")){
                                   // $error = "Payement completed";
                                    $message = "Payement completed";
                                    echo "<script>alert('$message');</script>";

                                     }
    
                                }
                                else {
                                   // $error ="Payment could not be competed,  something went wrong!";
                                    $message = "Payment could not be competed,  something went wrong!t";
                                    echo "<script>alert('$message');</script>";
                                }
    
                            }
                           
                                
    
                                
                            
    
                        }
                        else {
                           // $error ="A minimum of  R120 is required to make Premium Payment";
                            $message = "A minimum of  R120 is required to make Premium Payment";
                            echo "<script>alert('$message');</script>";
                            
                        }
                    }
                    elseif ($membership == "Food") {
                        if($amount >= 90)
                        {
                            if($amount == 90)
                            {
                                $total = $reserve -$amount;
                            
                                $food = "INSERT INTO payment(payment_date, amount, optionId, member_id, fee_id) VALUES ('$date',$amount,1,$mid,1)";
    
                                if(mysqli_query($con,$food) or die(mysqli_error($con)))
                                {
                                   
                                   // $error = "Payement completed";
                                    if(mysqli_query($con,"UPDATE `reserve`  SET `amount`= '$total' WHERE memberId = $mid") or die(mysqli_error($con)) ){
                                        //$error = "Payement completed";
                                        $message = "Payement completed";
                                        echo "<script>alert('$message');</script>"; 
    
                                         }
    
                                }
                                else {
                                   // $error ="Payment could not be competed,  something went wrong!";
                                    $message = "Payment could not be competed,  something went wrong!";
                                    echo "<script>alert('$message');</script>";
                                    
                                }
    
                            }
                  
    
                        }
                        else{
                            $error ="A minimum of  R90 is required to make Food Payment";
                            $message = "A minimum of  R90 is required to make Food Payment";
                            echo "<script>alert('$message');</script>";
                            
                        }
                    }
                    elseif ($membership == "Bundle") {
                        if($amount >= 210)
                        {
                            if($amount == 210)
                            {
                                $total = $reserve -$amount;
                                $bundle = "INSERT INTO payment(payment_date, amount, optionId, member_id, fee_id) VALUES ('$date',$amount,1,$mid,3)";
    
                                if(mysqli_query($con,$bundle) or die(mysqli_error($con)))
                                {
                                   
                                 //   $error = "Payement completed";
                                    if(mysqli_query($con,"UPDATE `reserve` SET `amount`= '$total' WHERE memberId = $mid")  or die(mysqli_error($con)) ){
                                        //$error = "Payement completed";
                                        $message = "Payement completed";
                                        echo "<script>alert('$message');</script>";
    
                                         }
    
                                }
                                else {
                                  //  $error ="Payment could not be competed,  something went wrong!";
                                    $message = "Payment could not be competed,  something went wrong!";
                                   echo "<script>alert('$message');</script>";
                                    
                                }
                            }
                     
    
                            
                        }
                        else {
                           // $error ="A minimum of  R210 is required to make Premium & Food Payment";
                            $message = "A minimum of  R210 is required to make Premium & Food Payment";
                            echo "<script>alert('$message');</script>";
                        }
                    }
    
                }
                else{
                  //  $error = "Menbership must be selected before you make payement";
                    $message = "Menbership must be selected before you make payemen";
                    echo "<script>alert('$message');</script>";
                }
    
          
    
        }
        else
        {
         // $error = "";

          $message = "The Amount must be digits";
          echo "<script>alert('$message');</script>";
        }
   
    }
    else {
        $message = "amount must not be empty ";
        echo "<script>alert('$message');</script>";
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
                            <!--< a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>-->
                            <div class="sb-sidenav-menu-heading">Society Mangement System</div>
                             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                             <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                 Actions
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                             </a>
                             <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="application.php">Apply For Claim</a>
                                    

                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#payments" aria-expanded="false" aria-controls="payments">
                                    
                                        Make Payments
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="payments" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="userCash.php">Cash</a>
                                            <a class="nav-link" href="userInstant.php">Instant</a>
                                            <a class="nav-link" href="userCredit.php">Credit</a>
                                        
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
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="calender.php">
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
                        <?php echo $name. " [Member]"; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Make Pyament </h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Make credit payments</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Users Missng all Payment
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                            <th>Name</th>
                                                <th>Surname</th>
                                                <th>Credit</th>
                                                <th>Action</th>
                        
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Surname</th>
                                                <th>Credit </th>
                                                <th>Action</th>
                                                
                                                
                                              
               
                                            </tr>
                                        </tfoot>
                                        <tbody>
 
                                             <?php

                                             $exec = "SELECT member.memberId
                                                        FROM member, user
                                                        WHERE member.user_id = user.userId
                                                        AND user.email = '$name'";
                                            $results = mysqli_query($con,$exec);

                                            while($line = mysqli_fetch_array($results))
                                            {
                                                $mid = $line['memberId'];
                                            }
                                               
                                               $payQuery = "SELECT member.memberId,member.name,member.surname,reserve.amount
                                                            FROM member,reserve
                                                            WHERE member.memberId= reserve.memberId
                                                            and member.memberId= $mid";



                                               $payment = mysqli_query($con,$payQuery);

                                               while($data = mysqli_fetch_array($payment))
                                               {
                                                  $memberId = $data['memberId'];
                                                   $name = $data['name'];
                                                   $surname = $data['surname'];
                                                   $credit = $data['amount'];
                                                
                                                  
                                                  



                                               ?>
                                               <tr>
                                                    <td> <?php echo $name;  ?>  </td>
                                                    <td> <?php echo $surname;  ?> </td>
                                                    <td> <?php echo $credit;  ?> </td>
                                               
                                                  
                                                    <div class="text-center">
                                                   <td>  <a href="" class="btn btn-success btn-rounded mb-4" data-toggle="modal" data-target="#modalLoginForm2">Pay Now</a>
                                                   
                                                   
                                                  </td>
                                                 
                                                </div>
                                                   
                               
                                                </tr>                                                           

                                               <?php    
                                               }



                                              ?>
        <div class="modal fade" id="modalLoginForm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Make  payement(Credit)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> 
              <div class="modal-body mx-3">
              <form  method="post"  action="userCredit.php">
                <div class="md-form mb-5">
               <!--   <i class="fas fa-id-card prefix grey-text"></i>  -->
                  <input type="hidden" name="id" id="defaultForm-email" class="form-control validate" value="<?php echo $memberId;  ?>">
                <!--  <label data-error="wrong"   data-success="right" for="defaultForm-email">Member Id</label>  -->
                </div>

                <div class="md-form mb-4">
                  <i class="fas fa-user prefix grey-text"></i>
                  <input type="text" name="name"  id="defaultForm-pass" class="form-control validate"  value="<?php echo $name; ?>"  ?>
                  <label data-error="wrong" data-success="right" for="defaultForm-pass">Member Name</label>
                </div>

                <div class="md-form mb-4">
                  <i class="fas fa-book prefix grey-text"></i>
                  
                  <select name="membership" id="defaultForm-pass">
                  <option value="none">Please select Membership Type</option>
                  <option value="Premium">Premium</option>
                  <option value="Food">Food</option>
                  <option value="Bundle">Premium & Food</option>
                  </select><br>
                  <label data-error="wrong" data-success="right" for="defaultForm-pass">Membership Due</label>
                </div>

                <div class="md-form mb-4">
                  <i class="fas fa-coins prefix grey-text"></i>
                  <input type="text" name="amount" id="defaultForm-pass" class="form-control validate" placeholder= "Enter amount"  ?>
                  <label data-error="wrong" data-success="right" for="defaultForm-pass">Amount</label>
                </div>
               
              </div>
              <div class="modal-footer d-flex justify-content-center">
                <button type="submit" name="pay" class="btn btn-success">Pay </button>
              </div>
              <form>
            </div>
          </div>
        </div>
                       
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

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
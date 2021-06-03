<?php

include("session.php");
include("connection.php");

$name = $_SESSION['name'];
$message = "";
if(isset($_POST['single']))
{
    $mid = mysqli_real_escape_string($con,$_POST['id']);
    $membership = mysqli_real_escape_string($con,$_POST['membership']);
    $amount = mysqli_real_escape_string($con,$_POST['amount']);
    $date = date("Y-m-d");
    $total = 0;

    if(!empty($amount))
    {
        if(is_numeric($amount))
        {
            $resuts = mysqli_query($con,"SELECT DATEDIFF(NOW(),payment_date) as NumOfDays FROM payment WHERE member_id = $mid");
            while($row = mysqli_fetch_array($resuts))
            {
                $days = $row['NumOfDays'];
            }

            $months = round($days / 30, 0);
          if($months > 1 )
          {
            if($membership = "Premium")
              {
                  $total = (20 * $months) +  (120 * $months);

                  if($amount >= $total)
                  {
                                        
                    if($amount == $total)
                    {
                        $premium = "INSERT INTO payment(payment_date, amount, optionId, member_id, fee_id) VALUES ('$date',$amount,1,$mid,2)";
                        if(mysqli_query($con,$premium) or die(mysqli_error($con)))
                        {
                           
                            $message = "Payement completed";
                            echo "<script>alert('$message');</script>";

                        }
                        else {
                            $message ="Payment could not be competed,  something went wrong!";
                            echo "<script>alert('$message');</script>";
                        }
                    }
                    else {
                        // reserved
                    }

                  }
                  else {
                    $message = "amount due is R".$total ." Ensure you pay full amount";
                    echo "<script>alert('$message');</script>";  
                  }
              }
              elseif($membership = "Food") {
                    $total = (50 * $months) +  (90 * $months);

                    if($amount >= $total)
                    {
                        if($amount == $total)
                        {
                            $food = "INSERT INTO payment(payment_date, amount, optionId, member_id, fee_id) VALUES ('$date',$amount,1,$mid,1)";
                            if(mysqli_query($con,$food) or die(mysqli_error($con)))
                            {
                               
                                
                                $message = "Payement completed";
                                echo "<script>alert('$message');</script>";

                            }
                            else {
                                $message ="Payment could not be competed,  something went wrong!";
                                echo "<script>alert('$message');</script>";
                            }
                        }
                        else {
                            // reserved
                        }

                    }
                    else {
                    
                        $message = "amount due is R".$total ." Ensure you pay full amount";
                        echo "<script>alert('$message');</script>";
                    }
              } 

          }
          else {
            $message = "Must be more than 1 mothh to make payment";
            echo "<script>alert('$message');</script>";
          }
        
        }
        else {
            $message = "amount must be digit ";
            echo "<script>alert('$message');</script>";
        }
   
    }
    else {
        $message = "amount must not be empty ";
        echo "<script>alert('$message');</script>";
    }
}

if(isset($_POST['double']))
{
    $mid = mysqli_real_escape_string($con,$_POST['id']);
    $membership = mysqli_real_escape_string($con,$_POST['membership']);
    $amount = mysqli_real_escape_string($con,$_POST['amount']);
    $date = date("Y-m-d");
    $total = 0;

    if(!empty($amount))
    {
        if(is_numeric($amount))
        {
            $resuts = mysqli_query($con,"SELECT DATEDIFF(NOW(),payment_date) as NumOfDays FROM payment WHERE member_id = $mid");
            while($row = mysqli_fetch_array($resuts))
            {
                $days = $row['NumOfDays'];
            }

            $months = round($days / 30, 0);
          if($months > 1 )
          {
            
                  $total = (70 * $months) +  (210 * $months);

                  if($amount >= $total)
                  {
                                        
                    if($amount == $total)
                    {
                        $premium = "INSERT INTO payment(payment_date, amount, optionId, member_id, fee_id) VALUES ('$date',$amount,1,$mid,3)";
                        if(mysqli_query($con,$premium) or die(mysqli_error($con)))
                        {
                           
                            $message = "Payement completed";
                            echo "<script>alert('$message');</script>";

                        }
                        else {
                            $message ="Payment could not be competed,  something went wrong!";
                            echo "<script>alert('$message');</script>";
                        }
                    }
                    else {
                        // reserved
                    }

                  }
                  else {
                    $message = "amount due is R".$total ." Ensure you pay full amount";
                    echo "<script>alert('$message');</script>";  
                  }
              
             

            }
          else {
            $message = "Must be more than 1 mothh to make payment";
            echo "<script>alert('$message');</script>";
          }
        
        }
        else {
            $message = "amount must be digit ";
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

        <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin=anonymous>
<script src=//code.jquery.com/jquery-3.3.1.slim.min.js integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin=anonymous></script>
<script src=//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin=anonymous></script>
<script src=//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin=anonymous></script>
<script src=//code.jquery.com/jquery-3.5.1.slim.js integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin=anonymous></script>
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
            -->
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
           -->

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
                                            <a class="nav-link" href="instant.php">Instant</a>
                                        
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
                            <div class="sb-sidenav-menu-heading">Events and Communication</div>
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
                        <h1 class="mt-4">Outstanding Payments</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Members outstanding payments</li>
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
                                                <th>ID Number</th>
                                                <th>Phone Number</th>
                                                <th>gender</th>
                                                <th>Owing</th>
                                                <th>Fine</th>
                                                <th>Action</th>
                        
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Surname</th>
                                                <th>ID Number</th>
                                                <th>Phone Number</th>
                                                <th>gender</th>
                                                <th>Owing</th>
                                                <th>Fine</th>
                                                <th>Action</th>
                                                
                                              
               
                                            </tr>
                                        </tfoot>
                                        <tbody>
 
                                             <?php
                                               
                                               $payQuery = "SELECT m.memberId,m.name,m.surname,m.id,m.cell_no,m.gender,p.payment_date
                                                            FROM member m
                                                            LEFT JOIN payment p 
                                                            ON m.memberId = p.member_id
                                                            WHERE p.payment_date IS NULL";

                                               $payment = mysqli_query($con,$payQuery);

                                               while($data = mysqli_fetch_array($payment))
                                               {
                                                  $memberId = $data['memberId'];
                                                   $name = $data['name'];
                                                   $surname = $data['surname'];
                                                   $id = $data['id'];
                                                   $cell = $data['cell_no'];
                                                   $gender = $data['gender'];
                                                   $owing = "Premium & Food";
                                                   $fine = "R70";
                                                  
                                                  



                                               ?>
                                               <tr>
                                                    <td> <?php echo $name;  ?>  </td>
                                                    <td> <?php echo $surname;  ?> </td>
                                                    <td> <?php echo $id;  ?> </td>
                                                    <td> <?php echo $cell;  ?> </td>
                                                    <td> <?php echo $gender;  ?> </td>
                                                    <td> <?php echo $owing;  ?> </td>
                                                    <td> <?php echo $fine;  ?> </td>
                                                  
                                                    <div class="text-center">
                                                   <td>  <a href="" class="btn btn-success btn-rounded mb-4" data-toggle="modal" data-target="#modalLoginForm2">Pay Now</a>
                                                   <a href="alert.php?id=<?php echo $memberId;  ?>&owing=both" class="btn btn-warning btn-rounded mb-4" >Send  Alert</a>
                                                   
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
                <h4 class="modal-title w-100 font-weight-bold">Make user payement(Cash)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> 
              <div class="modal-body mx-3">
              <form  method="post"  action="outstanding.php">
                <div class="md-form mb-5">
                  <i class="fas fa-id-card prefix grey-text"></i>
                  <input type="text" name="id" id="defaultForm-email" class="form-control validate" value="<?php echo $memberId;  ?>">
                  <label data-error="wrong"   data-success="right" for="defaultForm-email">Member Id</label>
                </div>

                <div class="md-form mb-4">
                  <i class="fas fa-user prefix grey-text"></i>
                  <input type="text" name="name"  id="defaultForm-pass" class="form-control validate"  value="<?php echo $name; ?>"  ?>
                  <label data-error="wrong" data-success="right" for="defaultForm-pass">Member Name</label>
                </div>

                <div class="md-form mb-4">
                  <i class="fas fa-book prefix grey-text"></i>
                  <input type="text" name="membership" id="defaultForm-pass" class="form-control validate"  value="<?php echo $owing; ?>"  ?>
                  <label data-error="wrong" data-success="right" for="defaultForm-pass">Membership Due</label>
                </div>

                <div class="md-form mb-4">
                  <i class="fas fa-coins prefix grey-text"></i>
                  <input type="text" name="amount" id="defaultForm-pass" class="form-control validate" placeholder= "Enter amount"  ?>
                  <label data-error="wrong" data-success="right" for="defaultForm-pass">Amount</label>
                </div>
               
              </div>
              <div class="modal-footer d-flex justify-content-center">
                <button type="submit" name="double" class="btn btn-success">Pay </button>
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

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Users With Single Payment
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                            <th>Name</th>
                                                <th>Surname</th>
                                                <th>ID Number</th>
                                                <th>Phone Number</th>
                                                <th>gender</th>
                                                <th>Payment Date</th>
                                                <th>Amount</th>
                                                <th>Paid For</th>
                                                <th>Membership</th> 
                                                <th>Owing</th> 
                                                <th>Fine</th>  
                                                <th>Action</th>                                  
                        
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Surname</th>
                                                <th>ID Number</th>
                                                <th>Phone Number</th>
                                                <th>gender</th>
                                                <th>Payment Date</th>
                                                <th>Amount</th>
                                                <th>Paid For</th>
                                                <th>Membership</th>
                                                <th>Owing</th>
                                                <th>Fine</th>
                                                <th>Action</th>   
                                              
               
                                            </tr>
                                        </tfoot>
                                        <tbody>
 
                                             <?php
                                               
                                               $payQuery = "SELECT  m.memberId,m.name,m.surname,m.id,m.cell_no,m.gender,p.payment_date,p.amount,o.name as OptionName,f.name as membershipName
                                                            FROM member m,payment p,payment_option o,membership_fee f 
                                                            WHERE m.memberId = p.member_id
                                                            AND o.optionId = p.optionId
                                                            AND p.fee_id = f.fee_id
                                                            AND MONTH(p.payment_date) = MONTH(CURRENT_DATE) - 1
                                                          AND YEAR(p.payment_date) = YEAR(CURRENT_DATE)
                                                            AND memberId IN  (
                                                                                SELECT member_id
                                                                                FROM payment
                                                                                WHERE fee_id <> 3
                                                                                GROUP BY member_id
                                                                                HAVING COUNT(member_id) <= 1)";

                                               $payment = mysqli_query($con,$payQuery);

                                               while($data = mysqli_fetch_array($payment))
                                               {
                                                   $memberId = $data['memberId'];
                                                   $name = $data['name'];
                                                   $surname = $data['surname'];
                                                   $id = $data['id'];
                                                   $cell = $data['cell_no'];
                                                   $gender = $data['gender'];
                                                   $date = $data['payment_date'];
                                                   $amount = $data['amount'];
                                                   $option = $data['OptionName'];
                                                   $membership = $data['membershipName'];
                                                   
                                                   if($membership == "Premium")
                                                   {
                                                       $owing = "Food";
                                                       $fine = "R50";
                                                   }
                                                   else {
                                                    $owing = "Premium";
                                                    $fine = "R20";
                                                   }
                                                  



                                               ?>
                                               <tr>
                                                    <td> <?php echo $name;  ?>  </td>
                                                    <td> <?php echo $surname;  ?> </td>
                                                    <td> <?php echo $id;  ?> </td>
                                                    <td> <?php echo $cell;  ?> </td>
                                                    <td> <?php echo $gender;  ?> </td>
                                                    <td> <?php echo $date;  ?> </td>
                                                    <td> <?php echo "R". $amount;  ?> </td>
                                                    <td> <?php echo $option;  ?> </td>
                                                    <td> <?php echo $membership;  ?> </td>
                                                    <td> <?php echo $owing;  ?> </td>
                                                    <td> <?php echo $fine;  ?> </td>
                                                 
                                                   
                                                   <div class="text-center">
                                                   <td>  <a href="" class="btn btn-success btn-rounded mb-4" data-toggle="modal" data-target="#modalLoginForm">Pay Now</a>
                                                   <a href="alert.php?id=<?php echo $memberId;  ?>&owing=<?php echo $owing ?>" class="btn btn-warning btn-rounded mb-4" >Send  Alert</a>
                                                  </td>
                                                </div>
                                                   
                                                   
                               
                                                </tr>                                                           

                                               <?php    
                                               }



                                              ?>
        <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Make user payement(Cash)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> 
              <div class="modal-body mx-3">
              <form  method="post"  action="outstanding.php">
                <div class="md-form mb-5">
                  <i class="fas fa-id-card prefix grey-text"></i>
                  <input type="text" name="id" id="defaultForm-email" class="form-control validate" value="<?php echo $memberId;  ?>">
                  <label data-error="wrong"   data-success="right" for="defaultForm-email">Member Id</label>
                </div>

                <div class="md-form mb-4">
                  <i class="fas fa-user prefix grey-text"></i>
                  <input type="text" name="name"  id="defaultForm-pass" class="form-control validate"  value="<?php echo $name; ?>"  ?>
                  <label data-error="wrong" data-success="right" for="defaultForm-pass">Member Name</label>
                </div>

                <div class="md-form mb-4">
                  <i class="fas fa-book prefix grey-text"></i>
                  <input type="text" name="membership" id="defaultForm-pass" class="form-control validate"  value="<?php echo $owing; ?>"  ?>
                  <label data-error="wrong" data-success="right" for="defaultForm-pass">Membership Due</label>
                </div>

                <div class="md-form mb-4">
                  <i class="fas fa-coins prefix grey-text"></i>
                  <input type="text" name="amount" id="defaultForm-pass" class="form-control validate" placeholder= "Enter amount"  ?>
                  <label data-error="wrong" data-success="right" for="defaultForm-pass">Amount</label>
                </div>
               
              </div>
              <div class="modal-footer d-flex justify-content-center">
                <button type="submit" name="single" class="btn btn-success">Pay </button>
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

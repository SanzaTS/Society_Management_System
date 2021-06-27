<?php

include("session.php");
include("connection.php");
include("funtions.php");

$name = $_SESSION['name'];
$message = "";
if(isset($_POST['send']))
{
  
    $mid = mysqli_real_escape_string($con,$_POST['id']);
    $name = mysqli_real_escape_string($con,$_POST['name']);
    $reason = mysqli_real_escape_string($con,$_POST['reason']);
    $msg = mysqli_real_escape_string($con,$_POST['msg']);
    
    $update = "UPDATE claim SET status = 'Rejected' WHERE member_id = $mid";

    if(mysqli_query($con,$update) or die(mysqli_errno($con))) 
    {
       $status = "UPDATE member SET status = 'member' WHERE memberId = $mid";

       if(mysqli_query($con,$status) or die(mysqli_errno($con)))
       {
         
        
        $subject = "    REJECTED DUE TO : ". $reason;
            
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
                <p>Your application was rejected due to the following reason: . </p>
                <p> </p>
                <p>'.$msg.'  </p>
                <p> </p>
                <p>Regards </p>
                <p> Admin </p>
    
    
        </div>
        </body>
        </html>';

        $query = "SELECT user.email,member.name
        FROM user,member
        WHERE user.userId = member.user_id
        AND member.memberId = $mid";

        $reults = mysqli_query($con, $query) or die(mysqli_error($con));

        while($row = mysqli_fetch_array($reults))
        {
           $email = $row['email'];

        }

        if(sendMail($email,$subject,$body))
        {
         
           // $error = "Application competed awaiting approval";
        
           ?>
           <script type="text/javascript">
           alert("Email has been sent to the applicant");
           window.location.href = "claimApplications.php?success";
           </script>

        <?php
        }

       }
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
                                            <a class="nav-link" href=" credit.php">Credit</a>
                                        
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

                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseApp" aria-expanded="false" aria-controls="pagesCollapseApp">
                                        Claims
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseApp" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="claimApplications.php"> Applications</a>
                                            <a class="nav-link" href="claims.php">Claims Details</a>
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
                        <h1 class="mt-4">Member Applications</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Members claim application</li>
                        </ol>

                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                               Proccess Applications
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
                                                <th>Membership Status</th>
                                                <th>Payment Due</th>
                                                <th>Application Status</th>
                                                <th>date</th>
                                                <th>Id Coopy</th>
                                                <th>Certificates</th>
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
                                                <th>Membership Status</th>
                                                <th>Payment Due</th>
                                                <th>Application Status</th>
                                                <th>date</th>
                                                <th>Id Coopy</th>
                                                <th>Certificates</th>
                                                <th>Action</th>
                                                
                                              
               
                                            </tr>
                                        </tfoot>
                                        <tbody>
 
                                             <?php
                                               
                                               $payQuery = "SELECT member.memberId,member.name,member.surname,member.id,member.cell_no,member.status,member.gender,claim.status as Stats,claim.claim_date,claim.id_copy,claim.proof,claim.amount
                                                            FROM member, claim
                                                            WHERE member.memberId = claim.member_id
                                                            AND claim.status = 'Pending'";

                                               $payment = mysqli_query($con,$payQuery);

                                               while($data = mysqli_fetch_array($payment))
                                               {
                                                  $memberId = $data['memberId'];
                                                   $name = $data['name'];
                                                   $surname = $data['surname'];
                                                   $id = $data['id'];
                                                   $cell = $data['cell_no'];
                                                   $gender = $data['gender'];
                                                   $status = $data['status'];
                                                   $amount = $data['amount'];
                                                   $stats = $data['Stats'];
                                                   $date = $data['claim_date'];
                                                   $idCopy = $data['id_copy']; 
                                                   $proof = $data['proof'];

                                                  
                                                  



                                               ?>
                                               <tr>
                                                    <td> <?php echo $name;  ?>  </td>
                                                    <td> <?php echo $surname;  ?> </td>
                                                    <td> <?php echo $id;  ?> </td>
                                                    <td> <?php echo $cell;  ?> </td>
                                                    <td> <?php echo $gender;  ?> </td>
                                                    <td> <?php echo $status;  ?> </td>
                                                    <td> <?php echo "R". $amount;  ?> </td>
                                                    <td> <?php echo $stats;  ?> </td>
                                                    <td> <?php echo $date;  ?> </td>
                                                    <td><a href="uploads/<?php echo $idCopy?>" target="_blank" class="btn btn-warning btn-rounded mb-4">View ID Copy</a> </td>
                                                    <td><a href="uploads/<?php echo $proof?>" target="_blank" class="btn btn-warning btn-rounded mb-4">View Certificates</a> </td>
                                            
                                                  
                                                    <div class="text-center">
                                                   <td>  
                                                   <a href="approve.php?id=<?php echo $memberId;  ?>&amount=<?php echo $amount; ?>" class="btn btn-success btn-rounded mb-4" >Aprove</a>
                                                   <a href="" class="btn btn-danger btn-rounded mb-4" data-toggle="modal" data-target="#modalLoginForm2">Reject</a>
                                                  
                                                   
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
                <h4 class="modal-title w-100 font-weight-bold">Reject Claim</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> 
              <div class="modal-body mx-3">
              <form  method="post"  action="claimApplications.php">
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
                  <select name="reason" id="reason">
                  <option value="Document Mismatch " > Document Mismatch </option>
                  <option value="Still Owing" > Still Owing </option>
                  <option value="Missing Documents" >Missing Documents</option>
                  </select></br>
                  <label data-error="wrong" data-success="right" for="reason">Reason </label>
                </div>

                <div class="md-form mb-4">
                  <i class="fas fa-pen prefix grey-text"></i>
                  <textarea class="form-control" rows="3" id="defaultForm-pass" name="msg" maxlength="50"></textarea>
                  <label data-error="wrong" data-success="right" for="defaultForm-pass">Comments</label>
                </div>
               
              </div>
              <div class="modal-footer d-flex justify-content-center">
                <button type="submit" name="send" class="btn btn-success">Submit </button>
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

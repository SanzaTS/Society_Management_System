<?php

include("session.php");
include("connection.php");

$name = $_SESSION['name'];
$error = "";


if(isset($_POST['update']))
{
    $fname = mysqli_real_escape_string($con,$_POST['name']);
    $surname = mysqli_real_escape_string($con,$_POST['surname']);
    $id = mysqli_real_escape_string($con,$_POST['idNum']);
    $phone = mysqli_real_escape_string($con,$_POST['phone']);
   // $email = mysqli_real_escape_string($con,$_POST['email']);
    
    $gender = "";

    if(!empty($fname)|| !empty($surname) || !empty($id)  || !empty($phone)   )
    {
     
         
              if (preg_match("/^[a-zA-Z ]*$/",$fname))
              {
                  if (preg_match("/^[a-zA-Z ]*$/",$surname))
                  {
                      if(strlen($fname) >= 3)
                      {
                          if(strlen($surname) >= 3)
                          {
                              if (is_numeric($id))
                              {
                                  if (is_numeric($phone))
                                  {
                                      $code = substr($phone,0,1);

                                      if($code =="0")
                                      {
                                          $second = substr($phone,1,1);
                                          if($second == "7" || $second =="8" || $second =="1" || $second =="6")
                                          {

                                              $third = substr($phone,2,1);
                                              if($third == "0"||$third == "1"||$third == "2" || $third == "3" || $third == "4" || $third == "6" ||$third == "8"|| $third == "9")
                                              {
                                                   if(strlen($id) == 13)
                                                      {
                                                          if(strlen($phone) == 10)
                                                          {
                                                            $sex =  substr($id,6,4);
                                                                        
                                                            if($sex < 5000)
                                                            {
                                                                $gender = "Female";
                                                            }
                                                            else
                                                            {
                                                                $gender = "Male";
                                                            }
                                                            $userId = "";
                                                            if($id)
                                                             $sq = "select userId from user where email = '$name' ";
                                                             $q = mysqli_query($con,$sq);
                                                            while( $row = mysqli_fetch_array($q))
                                                             {
                                                                   $userId = $row['userId'];
                                                             }
                                                                 echo "----" . $userId;             
                                                                $query = "UPDATE member SET name = '$fname',
                                                                surname = '$surname', id = '$id', cell_no = '$phone',
                                                                gender = '$gender'
                                                                WHERE user_id = $userId ";
//a.name,a.surname,a.id,a.cell_no,a.gender,u.email from admin a,
                                                                $res = mysqli_query($con,$query);

                                                                if (!$res) {
                                                                    echo "Error: " . $query . "<br>" . mysqli_error($con);
                                                                } else {
                                                                    header('Location: userProfile.php');
                                                                }


                                                            

                                                          }
                                                          else {
                                                              $error = "Phone Number must be  10 digits";
                                                          }

                                                      }
                                                      else {
                                                          $error = "ID Number must be  13 digits";
                                                      }

                                               

                                              }
                                              else {
                                                  $error = "invalid phone format";
                                              }

                                          }
                                          else {
                                              $error = "Phone number code should be 07,08,01or 06";
                                          }

                                      }
                                      else {
                                         $error = "Phone number must start with 0";
                                      }

                                  }
                                  else {
                                      $error="Phone Number must be digit";
                                  }

                              }
                              else{
                                  $error="ID Number must be digit";
                              }

                          }
                          else{
                              $error =  "Last name must have minimum of 3 charecters";  
                          }

                      }
                      else {
                          $error =  "First name must have minimum of 3 charecters";
                      }

                  }
                  else{
                      $error = "Last name must be charectors";
                  }

              }
              else {
                  $error = "First name must be charectors";
              }

  

      


    }
    else{
        $error = "Make sure all fields are filled";
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
                <a class="dropdown-item" href="#">
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
                               <!--     <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
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
                        <?php echo $name. " [Memebr]"; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">User profile</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">View and update user profile</li>
                        </ol>
                        <?php

                            $query = "select a.name,a.surname,a.id,a.cell_no,a.gender,u.email from member a, user u WHERE a.user_id = u.userId AND u.email = '$name' ";
                            $results = mysqli_query($con,$query);
                            $row = mysqli_fetch_array($results);

                        ?>

                        <div class="card-body">
                                        <form action="userProfile.php" method="post">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">First Name</label>
                                                        <input class="form-control py-4"name="name" id="inputFirstName" type="text" value="<?php echo $row['name']  ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputLastName">Last Name</label>
                                                        <input class="form-control py-4" name="surname" id="inputLastName" type="text" value="<?php echo $row['surname']  ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">ID Number</label>
                                                        <input class="form-control py-4" name="idNum" id="id" type="text" value="<?php echo $row['id']  ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="cellNum"> Gender</label>
                                                        <input class="form-control py-4" name="gender" id="cellNum" type="text" value="<?php echo $row['gender']  ?> " disabled/>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputPassword">Phone</label>
                                                        <input class="form-control py-4"name="phone" id="inputPassword" type="text" value="<?php echo $row['cell_no']  ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword"> Email</label>
                                                        <input class="form-control py-4" name="email" id="inputConfirmPassword" type="text" value="<?php echo $row['email']  ?>"  disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4 mb-0"><button type="submit" name="update" class="btn btn-success">Update Profile</button><br></div>
                                            
                                        </form>
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

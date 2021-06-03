<?php

include("session.php");
include("connection.php");
include("funtions.php");

$name = $_SESSION['name'];

$error = "";

if(isset($_POST['SAVE']))
{
    $name = mysqli_real_escape_string($con,$_POST['name']);
    $surname = mysqli_real_escape_string($con,$_POST['surname']);
    $id = mysqli_real_escape_string($con,$_POST['id']);
    $phone = mysqli_real_escape_string($con,$_POST['phone']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $role = mysqli_real_escape_string($con,$_POST['role']);
    $password = "password";
    $subject = "Registration Confirmation";
 
    $dob = "";
    $gender = "";

    if(!empty($name)|| !empty($surname) || !empty($id) || !empty($email) || !empty($phone)  )
    {
     
          if (filter_var($email, FILTER_VALIDATE_EMAIL))
          {
              if (preg_match("/^[a-zA-Z ]*$/",$name))
              {
                  if (preg_match("/^[a-zA-Z ]*$/",$surname))
                  {
                      if(strlen($name) >= 3)
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
                                                              $check1 = mysqli_query($con,"SELECT * FROM user WHERE email = '$email'");
                                                              if(mysqli_num_rows($check1)== 0)
                                                              {
                                                                  $date = date("Y-m-d");
                                                                  $sql1 = "INSERT INTO user(email,password,createDate,active) VALUES('$email','$password','$date','offline')";
                                                                if(mysqli_query($con,$sql1) or die(mysqli_error($con)))
                                                                {
                                                                  $userId = mysqli_insert_id($con);

                                                                  if($role == "admin")
                                                                  {
                                                                    $role1 = "INSERT INTO user_role(user_id,role_id) VALUES($userId,1)";

                                                                    if(mysqli_query($con,$role1) or die(mysqli_error($con)))
                                                                    {
                                                                        $sex1 =  substr($id,6,4);
                                                                    
                                                                        if($sex1 < 5000)
                                                                        {
                                                                            $gender = "Female";
                                                                        }
                                                                        else
                                                                        {
                                                                            $gender = "Male";
                                                                        }
   
                                                                        $admin = "INSERT INTO admin (name,surname,id,cell_no,gender,userId)  VALUES ('$name','$surname','$id','$phone','$gender',$userId)";
                                                                    
                                                                        if(mysqli_query($con,$admin) or die(mysqli_error($con)))
                                                                        {
                                                                            
                                                                                                $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                                                                                <html xmlns="http://www.w3.org/1999/xhtml">
                                                                                                <head>
                                                                                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                                                                                </head>
                                                                                                <body>

                                                                                                <div>
                                                                                                        <p> Hi ' . $name . '.</p>
                                                                                                        <p> </p>
                                                                                                        <p> Admin has successfully completed the registration on your behalf. </p>
                                                                                                        <p>Please find the  following information: </p>
                                                                                                        <p>Use email your email to login. </p>
                                                                                                        <p>And password is as follows: '.$password.'</p>
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
                                                                            $error = "Admin successfully added and email has been sent to the user with details";
                                                                           }
                                                                           
  
  
                                                                        }
                                                                        else {
                                                                            $error ="Something went wrong";
                                                                        }
                                                                    }

                                                                  }
                                                                  elseif($role == "user")
                                                                  {
                                                                    $role = "INSERT INTO user_role(user_id,role_id) VALUES($userId,2)";

                                                                    if(mysqli_query($con,$role) or die(mysqli_error($con)))
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
   
                                                                        $member = "INSERT INTO member(name,surname,id,cell_no,status,start_date,gender,user_id)  VALUES ('$name','$surname','$id','$phone','member','$date','$gender',$userId)";
                                                                    
                                                                        if(mysqli_query($con,$member) or die(mysqli_error($con)))
                                                                        {
                                                                            $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                                                            <html xmlns="http://www.w3.org/1999/xhtml">
                                                                            <head>
                                                                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                                                            </head>
                                                                            <body>

                                                                            <div>
                                                                                    <p> Hi ' . $name . '.</p>
                                                                                    <p> </p>
                                                                                    <p> Admin has successfully completed the registration on your behalf. </p>
                                                                                    <p>Please find the  following information: </p>
                                                                                    <p>Use email your email to login. </p>
                                                                                    <p>And password is as follows: '.$password.'</p>
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
                                                                                  $error = "User successfully added and email has been sent to the user with details";
                                                                            }
  
  
                                                                        }
                                                                        else {
                                                                            $error ="Something went wrong";
                                                                        }
                                                                    }
                                                                  }
                                                                  elseif ($role = "none") {
                                                                      $error = "Select role to complete payment";
                                                                  }



                                                                }


                                                                 

                                                             }
                                                             else {
                                                                  $error = "Email already exists";
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
          else {
             $error = "Email must be valid";
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
                        <h1 class="mt-4">Add Users</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Add users to excess the system</li>
                        </ol>

                        <div class="card-body">
                                        <form action="addUser.php" method="post">
                                        <label class="text-center font-weight-bold my-4" style="color:red;"><?php echo $error; ?></label>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">First Name</label>
                                                        <input class="form-control py-4"name="name" id="inputFirstName" type="text" placeholder="Enter first name" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputLastName">Last Name</label>
                                                        <input class="form-control py-4" name="surname" id="inputLastName" type="text" placeholder="Enter last name" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">ID Number</label>
                                                        <input class="form-control py-4" name="id" id="id" type="text" placeholder="Enter ID Number" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="cellNum">Cellphone Number</label>
                                                        <input class="form-control py-4" name="phone" id="cellNum" type="text" placeholder="Enter cellphone number"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" name="email" id="inputEmailAddress" type="text" aria-describedby="emailHelp" placeholder="Enter email address" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">User Role</label>
                                                <select class="form-control" name="role"> 
                                                    
                                                    <option value="none"> Select User Role</option>
                                                    <option value="admin"> Admin</option>
                                                    <option value="user"> User</option>
                                                    
                                                    
                                                  </select>
                                            </div>
                                            <div class="form-group mt-4 mb-0"><button type="submit" name="SAVE" class="btn btn-success">Add User</button><br></div>
                                            
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

<?php

include("session.php");
include("connection.php");
include("funtions.php");

$name = $_SESSION['name'];

$error = " ";

$username = "SELECT memberId FROM member m, user u WHERE m.user_id = u.userId and u.email = '$name'";
$results = mysqli_query($con,$username);

while($row = mysqli_fetch_array($results))
{
    $mid = $row['memberId'];
}

$date = date("Y-m-d");

if(isset($_POST['SAVE']))
{
  /*  $id = mysqli_real_escape_string($con,$_POST['id']);
    $cert = mysqli_real_escape_string($con,$_POST['certificates']);*/
    $date = date("Y-m-d");

        $targetDir = "uploads/";
        $cert = basename($_FILES["certificates"]["name"]);
    $fileName = basename($_FILES["id"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    $certLocation = $targetDir.$cert;
    $certType = pathinfo($certLocation,PATHINFO_EXTENSION);

        if(!empty($fileName) || !empty($cert))
        {
            
            $check = "SELECT member_id, MIN(payment_date) As first_occurence ,year(CURRENT_DATE)- year(MIN(payment_date)) AS years
                      FROM payment
                      WHERE member_id = $mid
                      GROUP BY member_id";

        $res = mysqli_query($con,$check) or die(mysqli_error($con));

        while($line = mysqli_fetch_array($res))
        {
           $years = $line['years'];
        }
        
        if($years > 0)
        {
           
                            // Allow certain file formats
                            $allowTypes = array('jpg','png','jpeg','gif','pdf');
                            if(in_array($fileType, $allowTypes) ||in_array($certType, $allowTypes)  ){
                                // Upload file to server
                                if(move_uploaded_file($_FILES["id"]["tmp_name"], $targetFilePath) && move_uploaded_file($_FILES["certificates"]["tmp_name"], $certLocation)  ){
                                    // Insert image file name into database 
                                //  $insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
                                /*  if($insert){
                                        $error = "The file ".$fileName. " has been uploaded successfully.";
                                    }else{
                                        $error = "File upload failed, please try again.";
                                    } */
                                  
                                $amountQuery = "SELECT member_id, SUM(amount) as Total
                                        FROM payment 
                                        WHERE member_id = 15
                                        ";

                                $money = mysqli_query($con,$amountQuery) or die(mysqli_error($con));

                                while($data = mysqli_fetch_array($money) )
                                {
                                    $sum = $data['Total'];
                                }
                                
                                if($years >= 1 || $years <= 5)
                                {
                                    $total = $sum - ($sum * 0.15); // 15%
                                }
                                elseif ($years > 5 || $years <= 10) {
                                    $total = $sum - ($sum * 0.1);  // 10%
                                }
                                elseif ($years > 10) {
                                    $total = $sum - ($sum * 0.05);  //5%
                                }

                                $upload = "INSERT INTO claim(amount, status, claim_date, id_copy, proof, member_id) VALUES('$total','Pending','$date','$fileName','$cert',$mid)";
            
                                if(mysqli_query($con,$upload) or die(mysqli_error($con))){
                                    $update ="UPDATE member SET status='InActive' WHERE memberId = $mid";
                                    mysqli_query($con,$update);
            
                                    $subject = "Claim Application Confirmation";
            
                                    $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                    <html xmlns="http://www.w3.org/1999/xhtml">
                                    <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                    </head>
                                    <body>
                                
                                    <div>
                                        
                                        
                                            <p>Your application submitted for review the update will be provided once it is completed. </p>
                                            <p> </p>
                                            <p> </p>
                                            <p>Regards </p>
                                            <p> Admin </p>
                                
                                
                                    </div>
                                    </body>
                                    </html>';
            
                                    if(sendMail($name,$subject,$body))
                                    {
                                        $error = "Application competed awaiting approval";
                                    }
                                    
            
                                }
                                else{
                                    $error = "failed to save db.";
                                }
            
                            }else{
                                $error = "Sorry, there was an error uploading your file.";
                            }
                        }else{
                            $error =  'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
                        }
        }
        else
        {
           
            $error = "You haven't made paymnets for over a year ";
        }
       

        }else{
        $error = 'Make sure you uploaded all required documents';
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
                        <h1 class="mt-4">Claims Application</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Make user Application(Claim)</li>
                        </ol>

                        <div class="card-body">
                                        <form action="application.php" method="post" enctype="multipart/form-data">
                                        <label class="text-center font-weight-bold my-4" style="color:red;"><?php echo $error; ?></label>

                                         <div class="form-group">
                                                <label for="formFileLg" class="form-label">Upload Id Copy</label>
                                                <input class="form-control form-control-lg" id="formFileLg" type="file" name="id"/>
                                            </div>

                                            
                                         <div class="form-group">
                                                <label for="formFileLg" class="form-label">Upload Proof</label>
                                                <input class="form-control form-control-lg" id="formFileLg" type="file" name="certificates"/>
                                            </div>
                                            
                                            <div class="form-group mt-4 mb-0"><button type="submit" name="SAVE" class="btn btn-success">Apply for Claim</button><br></div>
                                            
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

<?php

include("session.php");
include("connection.php");
include("funtions.php");

$name = $_SESSION['name'];


  
if(isset($_POST['word']))
{

    $filename="Payment Report";


    header("Content-type: application/vnd.ms-word");
  header("Content-Disposition: attachment; Filename =".$filename.".doc");
  header("Pragma: no-cache");
  header("Expires: 0");
     echo "<html>";
  
  echo "<body>";
  echo "<table style=\"border:1px solid;\">";
  
  
  echo" <tr >";
  echo "<th style=\"border:1px solid;\">Name </th>";
  echo "<th style=\"border:1px solid;\">Surname </th>";
  echo "<th style=\"border:1px solid;\">ID Number</th>";  
  echo "<th style=\"border:1px solid;\">Phone Number</th>"; 
  echo "<th style=\"border:1px solid;\">Gender</th>"; 
  echo "<th style=\"border:1px solid;\">Payment Date</th>";
  echo "<th style=\"border:1px solid;\">Amount</th>";  
  echo "<th style=\"border:1px solid;\">Option Name</th>";  
  echo "<th style=\"border:1px solid;\">Member Type</th>";              
  echo "</tr>";
  
  $payQuery = "SELECT m.name,m.surname,m.id ,m.cell_no,m.gender,p.payment_date,p.amount,o.name as OptionName,f.name as membershipName
  FROM member m,payment p,payment_option o,membership_fee f
   WHERE m.memberId = p.member_id
   AND o.optionId = p.optionId
    AND p.fee_id = f.fee_id";

$payment = mysqli_query($con,$payQuery);

while($data = mysqli_fetch_array($payment))
{
$name = $data['name'];
$surname = $data['surname'];
$id = $data['id'];
$cell = $data['cell_no'];
$gender = $data['gender'];
$date = $data['payment_date'];
$amount = $data['amount'];
$option = $data['OptionName'];
$membership = $data['membershipName'];
        
            
  
  
  
  echo "<tr>";
   echo"<td style=\"border:1px solid;\" >".$name."</td>";
    echo"<td style=\"border:1px solid;\">".$surname."</td>";
    echo"<td style=\"border:1px solid;\">".$id."</td>";
    echo"<td style=\"border:1px solid;\">".$cell."</td>";
    echo"<td style=\"border:1px solid;\">".$gender."</td>";
    echo"<td style=\"border:1px solid;\">".$date."</td>";
    echo"<td style=\"border:1px solid;\">".$amount."</td>";
    echo"<td style=\"border:1px solid;\">".$option."</td>";
    echo"<td style=\"border:1px solid;\">".$membership."</td>";
    
    
  echo "</tr>";
  
  
    }
  
  echo "</table>";
  echo "<body>";
  echo "</html>";

}

if(isset($_POST['excel']))
{
    $filename="Payment Report";


    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; Filename =".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo "<html>";

    echo "<body>";
    echo "<table style=\"border:1px solid;\">";

    echo" <tr >";
    echo "<th style=\"border:1px solid;\">Name </th>";
    echo "<th style=\"border:1px solid;\">Surname </th>";
    echo "<th style=\"border:1px solid;\">ID Number</th>";  
    echo "<th style=\"border:1px solid;\">Phone Number</th>"; 
    echo "<th style=\"border:1px solid;\">Gender</th>"; 
    echo "<th style=\"border:1px solid;\">Payment Date</th>";
    echo "<th style=\"border:1px solid;\">Amount</th>";  
    echo "<th style=\"border:1px solid;\">Option Name</th>";  
    echo "<th style=\"border:1px solid;\">Member Type</th>";              
    echo "</tr>";
    
    $payQuery = "SELECT m.name,m.surname,m.id ,m.cell_no,m.gender,p.payment_date,p.amount,o.name as OptionName,f.name as membershipName
    FROM member m,payment p,payment_option o,membership_fee f
     WHERE m.memberId = p.member_id
     AND o.optionId = p.optionId
      AND p.fee_id = f.fee_id";
  
  $payment = mysqli_query($con,$payQuery);
  
  while($data = mysqli_fetch_array($payment))
  {
  $name = $data['name'];
  $surname = $data['surname'];
  $id = $data['id'];
  $cell = $data['cell_no'];
  $gender = $data['gender'];
  $date = $data['payment_date'];
  $amount = $data['amount'];
  $option = $data['OptionName'];
  $membership = $data['membershipName'];
          
              
    
    
    
    echo "<tr>";
     echo"<td style=\"border:1px solid;\" >".$name."</td>";
      echo"<td style=\"border:1px solid;\">".$surname."</td>";
      echo"<td style=\"border:1px solid;\">".$id."</td>";
      echo"<td style=\"border:1px solid;\">".$cell."</td>";
      echo"<td style=\"border:1px solid;\">".$gender."</td>";
      echo"<td style=\"border:1px solid;\">".$date."</td>";
      echo"<td style=\"border:1px solid;\">".$amount."</td>";
      echo"<td style=\"border:1px solid;\">".$option."</td>";
      echo"<td style=\"border:1px solid;\">".$membership."</td>";
      
      
    echo "</tr>";

    }

    echo "</table>";
    echo "<body>";
    echo "</html>";
}

if(isset($_POST['pdfxport']))
{

    require("fpdf/fpdf.php");

    class PDF extends FPDF
  
    {
      
      // Page header
      function Header()
      {
        $image1 = "images/tutpng.png";
          // Logo
          $this->Image($image1,10,6,30);
          // Arial bold 15
          $this->SetFont('Arial','B',15);
          // Move to the right
          $this->Cell(80);
          // Title
          $this->Cell(100,10, $this->Image($image1,10,6,30),1,1,'C');
          // Line break
          $this->Ln(20);
          $this->Cell(198,10, "Member List ",1,1,'C');
          $this->Ln();
      }
      
      // Page footer
      function Footer()
      {
          // Position at 1.5 cm from bottom
          $this->SetY(-15);
          // Arial italic 8
          $this->SetFont('Arial','I',8);
          // Page number
          $this->Cell(0,10,'Member List ',0,0,'C');
          $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
      }
      }
      
      // Instanciation of inherited class
      $pdf = new PDF();
      $pdf->AliasNbPages();
      $pdf->AddPage();
      $pdf->SetFont('Times','',8);
       
      
       
      
      
            
        
        $pdf->Ln();
      
        
         
        
        $pdf->Cell(15,10,'name',1,0);
        $pdf->Cell(15,10,'Surname',1,0);
        $pdf->Cell(34,10,'ID Number',1,0);
        $pdf->Cell(34,10,'Phone Number',1,0);
        $pdf->Cell(33,10,'Gender',1,0);
        $pdf->Cell(17,10,'Payment Date',1,0);
        $pdf->Cell(16,10,'Amount',1,0);
        $pdf->Cell(16,10,'Option Name',1,0);
        $pdf->Cell(16,10,'Amount',1,0);
        
  
        $pdf->Ln();
          
                    
        $payQuery = "SELECT m.name,m.surname,m.id ,m.cell_no,m.gender,p.payment_date,p.amount,o.name as OptionName,f.name as membershipName
        FROM member m,payment p,payment_option o,membership_fee f
         WHERE m.memberId = p.member_id
         AND o.optionId = p.optionId
          AND p.fee_id = f.fee_id";
      
      $payment = mysqli_query($con,$payQuery);
      
      while($data = mysqli_fetch_array($payment))
      {
      $name = $data['name'];
      $surname = $data['surname'];
      $id = $data['id'];
      $cell = $data['cell_no'];
      $gender = $data['gender'];
      $date = $data['payment_date'];
      $amount = $data['amount'];
      $option = $data['OptionName'];
      $membership = $data['membershipName'];
              
          
          
         
         
           
            $pdf->Cell(15,10,$name,1,0);
            $pdf->Cell(15,10,$surname,1,0);
            $pdf->Cell(34,10,$id,1,0);
            $pdf->Cell(34,10,$cell,1,0);
            $pdf->Cell(33,10,$gender,1,0);
            $pdf->Cell(17,10,$date,1,0);
            $pdf->Cell(16,10,$amount,1,0);
            $pdf->Cell(16,10,$option,1,0);
            $pdf->Cell(16,10,$membership,1,0);
           
  
            
          
          
        
        $pdf->Ln();
            
           
          
         }
        
        
        $filename = "Members Report.pdf";
      
      $pdf->Output();
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
                        <h1 class="mt-4">User Payments</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Payments data for users</li>
                        </ol>

                        <div class="card-body">
                        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" method ="post" action="paymentReports.php">
                            <div>
                               <button type="submit" name="pdfxport" class="btn btn-success">PDF</button> 
                               <button type="submit" name="excel" class="btn btn-success">Excel</button> 
                               <button type="submit" name="word" class="btn btn-success">Word</button></br>

                            </div>
                        <div class="input-group">
                         <input class="form-control" type="date" name="sDate" aria-label="Search" aria-describedby="basic-addon2" />
                         <input class="form-control" type="date" name="eDate" aria-label="Search" aria-describedby="basic-addon2" />

                          <div class="input-group-append">
                        <button class="btn btn-primary" type="sunmit" name="search">Search</button>
                       
                     </div>
                   </div>
                       </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Payments Data
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
                                                <th>Payment date</th>
                                                <th>Amount</th>
                                                <th>Payment Option</th>
                                                <th>Membership Type</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Surname</th>
                                                <th>ID Number</th>
                                                <th>Phone Number</th>
                                                <th>gender</th>
                                                <th>Payment date</th>
                                                <th>Amount</th>
                                                <th>Payment Option</th>
                                                <th>Membership Type</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
 
                                             <?php
                                               if(isset($_POST['search']))
                                               {
                                                   $sDate = $_POST['sDate'];
                                                   $eDate = $_POST['eDate'];

                                                   echo $eDate;

                                                   if(!empty($sDate) || !empty($eDate))
                                                   {
                                                   list($m1,$d1,$y1) = explode("-",$sDate);
                                                   list($m2,$d2,$y2) = explode("-",$eDate);

                                                   $startDate = "$y1-$m1-$d1";
                                                   $endDate = "$y2-$m2-$d2";
                                                   $payQuery = "SELECT m.name,m.surname,m.id ,m.cell_no,m.gender,p.payment_date,p.amount,o.name as OptionName,f.name membershipName
                                                   FROM member m,payment p,payment_option o,membership_fee f
                                                    WHERE m.memberId = p.member_id
                                                    AND o.optionId = p.optionId
                                                     AND p.fee_id = f.fee_id
                                                     AND p.payment_date BETWEEN '$sDate' AND '$eDate' ";

                                                    $payment = mysqli_query($con,$payQuery);
                                                    

                                                    
                                                    while($data = mysqli_fetch_array($payment))
                                                    {
                                                        $name = $data['name'];
                                                        $surname = $data['surname'];
                                                        $id = $data['id'];
                                                        $cell = $data['cell_no'];
                                                        $gender = $data['gender'];
                                                        $date = $data['payment_date'];
                                                        $amount = $data['amount'];
                                                        $option = $data['OptionName'];
                                                        $membership = $data['membershipName'];


                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $name;  ?>  </td>
                                                        <td> <?php echo $surname;  ?> </td>
                                                        <td> <?php echo $id;  ?> </td>
                                                        <td> <?php echo $cell;  ?> </td>
                                                        <td> <?php echo $gender;  ?> </td>
                                                        <td> <?php echo $date;  ?> </td>
                                                        <td> <?php echo $amount;  ?> </td>
                                                        <td> <?php echo $option;  ?> </td>
                                                        <td> <?php echo $membership;  ?> </td>
                                                    </tr>                                                           

                                                    <?php    
                                                    }                                                 
                                                  }  
                                                  else{
                                                    $payQuery = "SELECT m.name,m.surname,m.id ,m.cell_no,m.gender,p.payment_date,p.amount,o.name as OptionName,f.name membershipName
                                                    FROM member m,payment p,payment_option o,membership_fee f
                                                     WHERE m.memberId = p.member_id
                                                     AND o.optionId = p.optionId
                                                      AND p.fee_id = f.fee_id";

                                       $payment = mysqli_query($con,$payQuery);

                                       while($data = mysqli_fetch_array($payment))
                                       {
                                           $name = $data['name'];
                                           $surname = $data['surname'];
                                           $id = $data['id'];
                                           $cell = $data['cell_no'];
                                           $gender = $data['gender'];
                                           $date = $data['payment_date'];
                                           $amount = $data['amount'];
                                           $option = $data['OptionName'];
                                           $membership = $data['membershipName'];


                                       ?>
                                       <tr>
                                            <td> <?php echo $name;  ?>  </td>
                                            <td> <?php echo $surname;  ?> </td>
                                            <td> <?php echo $id;  ?> </td>
                                            <td> <?php echo $cell;  ?> </td>
                                            <td> <?php echo $gender;  ?> </td>
                                            <td> <?php echo $date;  ?> </td>
                                            <td> <?php echo $amount;  ?> </td>
                                            <td> <?php echo $option;  ?> </td>
                                            <td> <?php echo $membership;  ?> </td>
                                        </tr>                                                           

                                       <?php    
                                       }
                                                  }         

                                               }
                                               else {
                                                   # code...
                                              
                                               $payQuery = "SELECT m.name,m.surname,m.id ,m.cell_no,m.gender,p.payment_date,p.amount,o.name as OptionName,f.name membershipName
                                                            FROM member m,payment p,payment_option o,membership_fee f
                                                             WHERE m.memberId = p.member_id
                                                             AND o.optionId = p.optionId
                                                              AND p.fee_id = f.fee_id";

                                               $payment = mysqli_query($con,$payQuery);

                                               while($data = mysqli_fetch_array($payment))
                                               {
                                                   $name = $data['name'];
                                                   $surname = $data['surname'];
                                                   $id = $data['id'];
                                                   $cell = $data['cell_no'];
                                                   $gender = $data['gender'];
                                                   $date = $data['payment_date'];
                                                   $amount = $data['amount'];
                                                   $option = $data['OptionName'];
                                                   $membership = $data['membershipName'];


                                               ?>
                                               <tr>
                                                    <td> <?php echo $name;  ?>  </td>
                                                    <td> <?php echo $surname;  ?> </td>
                                                    <td> <?php echo $id;  ?> </td>
                                                    <td> <?php echo $cell;  ?> </td>
                                                    <td> <?php echo $gender;  ?> </td>
                                                    <td> <?php echo $date;  ?> </td>
                                                    <td> <?php echo $amount;  ?> </td>
                                                    <td> <?php echo $option;  ?> </td>
                                                    <td> <?php echo $membership;  ?> </td>
                                                </tr>                                                           

                                               <?php    
                                               }
                                              }


                                              ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                               Sum of payments
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                            <th>Year</th>
                                                <th>Premium Total</th>
                                                <th>Food Total</th>
                                                <th>Food & Premium Total</th>
                                                
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
 
                                             <?php

                                                   $payQuery = "SELECT YEAR(payment.payment_date) as Year,
                                                                        SUM(case when (membership_fee.name ='Premium') then payment.amount else 0 end) as 'Premium',
                                                                        SUM(case when (membership_fee.name ='Food') then  payment.amount else 0 end) as 'Food',
                                                                        SUM(case when (membership_fee.name ='Bundle') then payment.amount else 0 end) as 'Bundle'
                                                                        from payment,membership_fee
                                                                        WHERE payment.fee_id = membership_fee.fee_id
                                                                        group by YEAR(payment.payment_date)
                                                                        order by YEAR(payment.payment_date); ";

                                                    $payment = mysqli_query($con,$payQuery);
                                                    

                                                    
                                                    while($data = mysqli_fetch_array($payment))
                                                    {
                                                        $Year = $data['Year'];
                                                        $primium = $data['Premium'];
                                                        $food = $data['Food'];
                                                        $bundle = $data['Bundle'];
                                                      


                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $Year;  ?>  </td>
                                                        <td> <?php echo $primium;  ?> </td>
                                                        <td> <?php echo $food;  ?> </td>
                                                        <td> <?php echo $bundle;  ?> </td>
                                                   
                                                    </tr>                                                           

                                                    <?php    
                                                    }                                                 
                                          


                                              ?>
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

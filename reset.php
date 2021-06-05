<?php
include("session.php");
include("connection.php");
include("funtions.php");

$error ="";
$email = $_GET['email'];

if(isset($_POST['reset']))
{
    $password = mysqli_real_escape_string($con,$_POST['pass']);
    $password2 = mysqli_real_escape_string($con,$_POST['pass2']);


    if($password == $password2)
    {
        $results = mysqli_query($con,"UPDATE `user` SET `password`='' WHERE `email` = '$email' ");

        if($results)
        {
            $error = "Congratulations! Your password has been updated successfully. You can now Login";
            ?>
            <script type="text/javascript">
            alert("Congratulations! Your password has been updated successfully. You can now Login");
            window.location.href = "index.php";
            </script>
            <?php
        }
    }
  /*  else {
        $error = "Password did not match";
        ?>
        <script type="text/javascript">
        alert("Password did not match");
        window.location.href = "reset.php?eamil=<?php echo $email; ?>";
        </script>
        <?php
    }*/
}




?>


<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Society Management System</title>
        <link href="css/styles.css" rel="stylesheet" />
        <style>
    body {
      background-image: url(2.jpg) ;
      filter: blur(8px);
    }
  </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script type = "text/javascript">

         function validate() {
            if( document.form.pass.value == "" ) {
            alert( "Please provide your password!" );
            document.form.pass.focus() ;
            return false;
         }
         /*if( document.form.pass2.value == "" ) {
            alert( "Please provide your confirm  password!" );
            document.myForm.pass2.focus() ;
            return false;
         }*/
         if( document.form.pass.value != document.form.pass2.value ) 
         {
            
            alert( "Password did not match enter again." );
            document.form.pass.focus() ;
            return false;
         }

         }

        </script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Password Recovery</h3></div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Reset your password.</div>
                                        <div> <label class="text-center font-weight-bold my-4" style="color:red;"><?php echo $error; ?></label> </div>
                                        <form  action="reset.php" method="post" name="form" onsubmit = "return(validate());">
                                            <div class="form-group">
                                                <label class="small mb-1" for="pass">Password</label>
                                                <input class="form-control py-4" name="pass" id="pass" type="text" aria-describedby="emailHelp" placeholder="Enter email address" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="pass2">Confirm Password</label>
                                                <input class="form-control py-4" name="pass2" id="pass2" type="text" aria-describedby="emailHelp" placeholder="Enter email address" />
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                               
                                                <button class="btn btn-primary" href="#" type="submit" name="reset">Reset Password</button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
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
    </body>
</html>
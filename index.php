<?php
  include("session.php");
  include("connection.php");

  $error = "";

  if(isset($_POST['login']))
  {
    $username = mysqli_real_escape_string($con,$_POST['username']);
    $password = mysqli_real_escape_string($con,$_POST['password']);

      if(!empty($username) || !empty($password))
      {
        $sql= "SELECT * FROM user WHERE email = '$username' AND password ='$password' ";

        $res = mysqli_query($con,$sql) or die(mysqli_error($con));

        $rows = mysqli_num_rows($res);

        if($rows == 1)
        {

            if(!empty($_POST["remember"])) {
                setcookie ("username", $username,time()+ 3600);
                setcookie ("password", $password,time()+ 3600);
               // echo "Cookies Set Successfuly";
            } else {
                setcookie("username","");
                setcookie("password","");
              //  echo "Cookies Not Set";
            }

            while($row = mysqli_fetch_array($res))
            {
                $id = $row['userId'];

            }

            $role = "SELECT r.name from user_role u, role r where u.role_id = r.role_id and  u.user_id = $id";
            $data = mysqli_query($con,$role)  or die(mysqli_error($con));
            while($col = mysqli_fetch_array($data))
            {
                $userRole = $col['name'];
            }

            if($userRole == "admin")
            {

                mysqli_query($con,"UPDATE user SET active = 'online' WHERE email = '$username' ");
               
                 $_SESSION['name'] = $username;
                
                header("location:admin.php");
            }
            else {
            /*    mysqli_query($con,"UPDATE user SET active = 'online' WHEREemail = '$username' ");
                
                    $_SESSION['name'] = $username;

                */
                $query ="SELECT  member.status
                        FROM member,user
                        WHERE member.user_id = user.userId
                        AND user.email = '$username' ";
                
                $result = mysqli_query($con,$query);

                while($line = mysqli_fetch_array($result)){
                    $stats = $line['status'];
                }
                
                if($stats == "member")
                {
                    $status = "";
                    mysqli_query($con,"UPDATE user SET active = 'online' WHERE email = '$username' ");
                   
                    $_SESSION['name'] = $username;
                    header("location:member.php");
                }
                else{
                    $error= "This account is in active";
                }
               
            }

             
        }
        else{
            $error= "Email or password incorect";
        }


      }
      else{
        $error= "All filed  must be filled";
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

        <style>
    body {
      background-image: url(2.jpg) 
    }
  </style>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
								<div class="card-header"><h3 class="text-center font-weight-light my-4">Society Management System</h3></div>
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <label class="text-center font-weight-bold my-4" style="color:red;"><?php echo $error; ?></label>
                                    <div class="card-body">
                                        <form role="form" action="index.php" method="post" class="login-form"> 
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Username</label>
                                                <input class="form-control py-4" name="username" id="inputEmailAddress" type="text" placeholder="Enter Email" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Enter password" />
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" name="remember" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.php">Forgot Password?</a>
                                                <button type="submit" name="login" class="btn btn-success">Login</button><br>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
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
    </body>
</html>

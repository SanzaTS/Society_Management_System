3<?php
      include("session.php");
      include("connection.php");

      $error = "";

      if(isset($_POST['register']))
      {
          $name = mysqli_real_escape_string($con,$_POST['name']);
          $surname = mysqli_real_escape_string($con,$_POST['surname']);
          $id = mysqli_real_escape_string($con,$_POST['id']);
          $phone = mysqli_real_escape_string($con,$_POST['phone']);
          $email = mysqli_real_escape_string($con,$_POST['email']);
          $password = mysqli_real_escape_string($con,$_POST['password']);
          $password2 = mysqli_real_escape_string($con,$_POST['passwordConfirm']);
          $dob = "";
          $gender = "";

          if(!empty($name)|| !empty($surname) || !empty($id) || !empty($email) || !empty($phone) ||  !empty($password) || !empty($password2) )
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
                                                        if($password == $password2)
                                                        {
                                                            if(strlen($id) == 13)
                                                            {
                                                                if(strlen($phone) == 10)
                                                                {
                                                                    $check1 = mysqli_query($con,"SELECT * FROM user WHERE email = '$email'");
                                                                    if(mysqli_num_rows($check1)== 0)
                                                                    {
                                                                        $date = date("Y-m-d");
                                                                        $sql1 = "INSERT INTO user(email,password,createDate,active) VALUES('$email','$password','$date','online')";
                                                                      if(mysqli_query($con,$sql1) or die(mysqli_error($con)))
                                                                      {
                                                                        $userId = mysqli_insert_id($con);

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
                                                                                header("location:member.php");


                                                                            }
                                                                        }


                                                                      }


                                                                        //$last_id = mysqli_insert_id($link);

                                                                    }
                                                                    else {
                                                                        $error = "Email already exists";
                                                                    }

                                                                }
                                                                else {
                                                                    $error = "Phne Number must be  10 digits";
                                                                }

                                                            }
                                                            else {
                                                                $error = "ID Number must be  13 digits";
                                                            }

                                                        }
                                                        else {
                                                            $error = "Password did not match";
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

   
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Society Management System</h3></div>
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <label class="text-center font-weight-bold my-4" style="color:red;"><?php echo $error; ?></label>
                                    <div class="card-body">
                                        <form action="register.php" method="post">
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
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputPassword">Password</label>
                                                        <input class="form-control py-4"name="password" id="inputPassword" type="password" placeholder="Enter password" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                                                        <input class="form-control py-4" name="passwordConfirm" id="inputConfirmPassword" type="password" placeholder="Confirm password" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4 mb-0"><button type="submit" name="register" class="btn btn-success">Create Account</button><br></div>
                                            
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="index.php">Have an account? Go to login</a></div>
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

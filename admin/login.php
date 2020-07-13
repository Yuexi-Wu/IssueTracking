<?php include "includes/db.php"; ?>
<?php session_start(); ?>
<?php
if(isset($_POST['login'])) {  
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(!empty($email) && !empty($password)) {
        $email = mysqli_real_escape_string($connection, $email);//clean up the harmful data
        $password = mysqli_real_escape_string($connection, $password);

        $query = "SELECT * FROM user WHERE email = '{$email}' ";
        $select_user_query = mysqli_query($connection, $query);
        if(mysqli_num_rows($select_user_query) == 0) {
            $message = "User not Exist!";
        } else {
            if(!$select_user_query) {
                die('QUERY FAILED' . mysqli_error($connection));
            }
            $row = mysqli_fetch_array($select_user_query);
            $db_id = $row['user_id'];
            $db_email = $row['email'];
            $db_pass = $row['password'];
            $db_username = $row['username'];
            $db_displayname = $row['displayname'];

            $password = crypt($password, $db_pass);


            if($password !== $db_pass) {
                $message = "Password not Correct!";
            } else{
                $message = "";
                $_SESSION['user_id'] = $db_id;
                $_SESSION['username'] = $db_username;
                $_SESSION['displayname'] = $db_displayname;
                $_SESSION['email'] = $db_email;
                //can use seesion to get the values of the users. include"session_start()"
                header("Location: index.php"); //locate to the mainpage
            }
        }
        
    } else{
        $message = "";
    }
} else {
    $message = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Issue Tracking System Login</title>
    <link href="/issueTracking/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/issueTracking/css/blog-home.css" rel="stylesheet">
    </head>
    <body>

   <div class="container">
   <div class="container">
       <div class="row">
           <div class="col-xs-6 col-xs-offset-3">
           <div class="form-wrap">
               <h1>Login</h1>
               <form action="login.php" method="post">
               <h4 class="text-center"><?php echo $message; ?></h4>
                <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                </div>

                <input type="submit" name="login" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Submit">
                <div class="form-group">
                    <ul class="list-inline text-right">
                        <li>
                            <a id="reset" href="#">Can't log in?</a>
                        </li>
                        <li>
                            <a id="signup" href="/issueTracking/admin/registration.php">Sign Up for an account</a>
                        </li>
                    </ul>
                </div>
            </form>
           </div>
           </div>
       </div>
   </div>
    
</div>
    
</body>
</html>
<!-- login -->

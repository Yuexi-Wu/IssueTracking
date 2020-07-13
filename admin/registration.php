<?php include "includes/db.php";?>
 
<?php
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $displayname = $_POST['displayname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if(!empty($username) && !empty($displayname) && !empty($email) && !empty($password)) {
        $username = mysqli_real_escape_string($connection, $username);
        $displayname = mysqli_real_escape_string($connection, $displayname);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);

        $query = "SELECT * FROM user WHERE email = '{$email}'";
        $check_email = mysqli_query($connection, $query);
        if(mysqli_num_rows($check_email) == 1) {
            $message = "Email already Used!";
        } else {
            $query = "SELECT randSalt FROM user";
            $select_randsalt_query = mysqli_query($connection, $query);
            if(!$select_randsalt_query) {
                die("QUERY FAILED" . mysqli_error($connection));
            }

            $row = mysqli_fetch_array($select_randsalt_query);
            $salt = $row['randSalt'];
            $password = crypt($password, $salt);

            $query = "INSERT INTO user (email, username, displayname, password) ";
            $query .= "VALUES('{$email}', '{$username}', '{$displayname}', '{$password}' )";
            $register_user_query = mysqli_query($connection, $query);
            if(!$register_user_query) {
                die("QUERY FAILED" . mysqli_error($connection) . ' ' . mysqli_errno($connection));
            }
            $message = "";
            header('location: login.php');
        }
    } else {
        $message = "Fields cannot be Empty";
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

     <title>Issue Tracking System Registration</title>
     <!-- Bootstrap Core CSS -->
    <link href="/issueTracking/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/issueTracking/css/blog-home.css" rel="stylesheet">

    <link href="/issueTracking/css/styles.css" rel="stylesheet">
 </head>
 <body>
     
 


    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                       <h4 class="text-center"><?php echo $message; ?></h4>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                        <div class="form-group">
                            <label for="displayname" class="sr-only">displayname</label>
                            <input type="text" name="displayname" id="displayname" class="form-control" placeholder="Enter Desired Displayname">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Register">
                        
                        <div class="form-group">
                        <ul class="list-inline text-right">
                            <li>
                                <a id="signin" href="/issueTracking/admin/login.php">Already have an account? Log in</a>
                            </li>
                        </ul>
                    </div>
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>


</body>
 </html>


<?php include "includes/header.php"; ?>
<?php
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $query  ="SELECT * FROM user WHERE user_id = '{$user_id}'";
        $select_user_profile = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($select_user_profile)) {
            $username = $row['username'];
            $displayname = $row['displayname'];
            $email = $row['email'];
            $password = $row['password'];
        }
    }
?>
<?php
    if(isset($_POST['edit_user'])) {
        $user_id = $_SESSION['user_id'];
        $username = $_POST['username'];
        $displayname = $_POST['displayname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
  
        $query = "SELECT randSalt FROM user";
        $select_randsalt_query = mysqli_query($connection, $query);
        if(!$select_randsalt_query) {
        die("Query Failed" . mysqli_error($connection));

        }

        $row = mysqli_fetch_array($select_randsalt_query); 
        $salt = $row['randSalt'];
        $hashed_password = crypt($password, $salt);


        $query = "UPDATE user SET ";
        $query .="username = '{$username}', ";
        $query .="displayname = '{$displayname}', ";
        $query .="email = '{$email}', ";
        $query .="password   = '{$hashed_password}' ";
        $query .= "WHERE user_id = '{$user_id}' ";


        $edit_user_query = mysqli_query($connection,$query);

        confirmQuery($edit_user_query);


       }
?>

<div id="wrapper">
   
    <?php include "includes/navigation.php"; ?>
    
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                       <h1 class="page-header">Profile</h1>
                        <form action="" method="post" enctype="multipart/form-data">    
                         <div class="form-group">
                             <label for="post_status">Username</label>
                              <input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
                          </div>
                          
                          <div class="form-group">
                             <label for="title">Displayname</label>
                              <input type="text" value="<?php echo $displayname; ?>" class="form-control" name="displayname">
                          </div>

                    <!--
                          <div class="form-group">
                             <label for="post_image">Post Image</label>
                              <input type="file"  name="image">
                          </div>
                    -->

                          <div class="form-group">
                             <label for="post_content">Email</label>
                              <input type="email" value="<?php echo $email; ?>" class="form-control" name="email">
                          </div>

                          <div class="form-group">
                             <label for="post_content">Password</label>
                              <input type="password" value="<?php echo $password; ?>" class="form-control" name="password">
                          </div>


                           <div class="form-group">
                              <input class="btn btn-primary" type="submit" name="edit_user" value="Update Profile">
                          </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
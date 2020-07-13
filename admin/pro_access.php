<?php include "includes/header.php"; ?>
<?php
if(isset($_POST['addUser'])) {
    $email = $_POST['email'];
    if(!empty($email)) {
        $email = mysqli_escape_string($connection, $email);
        $query = "SELECT * FROM user WHERE email = '{$email}'";
        $select_user = mysqli_query($connection, $query);
        if(mysqli_num_rows($select_user) == 0) {
            $message = "User doesn't Exist!";
        } else {
            if(!$select_user) {
                die("QUERY FAILED" . mysqli_error($connection));
            }
            $row = mysqli_fetch_assoc($select_user);
            $add_user_id = $row['user_id'];
            $check_user = "SELECT * FROM participate WHERE user_id = $add_user_id and pro_id = $pid";
            $check_user_query = mysqli_query($connection, $check_user);
            if(mysqli_num_rows($check_user_query) == 1) {
                $message = "User already Exist!";
            } else {
                $message = "";
                $add_user = "INSERT INTO participate (user_id, pro_id) VALUES('{$add_user_id}', '{$pid}')";
                $add_user_query = mysqli_query($connection, $add_user);
            }
        } 
    }
} else{
    $message = "";
}
?>

   
    <div id="wrapper">

        <!-- Navigation -->
        <?php include "pro_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Project Access
                        </h1>
                        
                        <form action="pro_access.php?pid=<?php echo $pid; ?>" method="post" class="form-inline my-2 my-lg-0">
                         <h5><?php echo $message; ?></h5>
                          <input class="form-control mr-sm-2" type="search" name="email" placeholder="Email Address" aria-label="Search">
                          <input type="submit" name="addUser" class="btn btn-outline-success my-2 my-sm-0" value="Add User">
                          
                        </form>  
                        
                        
                        <form action="pro_access.php?pid<?php echo $pid; ?>" method="post">
                        <table class="table">
                            <thread>
                               <tr>
                                <th>DisplayName</th>
                                <th>Email</th>
                                <th>Role</th>
                               </tr>
                            </thread>
                            <tbody>
                                <?php
if(isset($_GET)) {
    $pid = $_GET['pid'];
    //check if the user is leader of this project
    $user_id = $_SESSION['user_id'];
    $check_user = "SELECT * FROM leader WHERE user_id = $user_id and pro_id = $pid";
    $check_user_query = mysqli_query($connection, $check_user);
    $disable = "";
    if(mysqli_num_rows($check_user_query) == 0) {
        $disable = 'disabled';
    }
    $query = "SELECT * FROM participate WHERE pro_id = $pid";
    $select_user = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_user)) {
        $user_id = $row['user_id'];
        $query = "SELECT * FROM user WHERE user_id = $user_id";
        $select_user_query = mysqli_query($connection, $query);
        $user_row = mysqli_fetch_assoc($select_user_query);
        $displayname = $user_row['displayname'];
        $email = $user_row['email'];
        ?>
        <tr>
            <td><?php echo $displayname; ?></td>
            <td><?php echo $email; ?></td>
            <td>
              <select name="role" <?php echo $disable; ?> >        
               <?php
                $check_leader = "SELECT * FROM leader WHERE user_id = $user_id and pro_id = $pid";
                $check_leader_query = mysqli_query($connection, $check_leader);
                if(mysqli_num_rows($check_leader_query) == 0) {
                    //user
                    echo "<option value='1'>Leader</option>";
                    echo "<option value='2' selected>User</option>";
                } else{
                    //leader
                    echo "<option value='1' selected>Leader</option>";
                    echo "<option value='2'>User</option>";
                }
                ?>
           </select>
            </td>
        </tr>
        <?php
        if(isset($_POST['role'])) {
            $role = $_POST['role'];
            //USER --> LEADER
            if($role == '1') {
//                //delete from participate table
//                $delete_user = "DELETE FROM participate WHERE user_id = $user_id ";
//                $delete_user_query = mysqli_query($connection, $delete_user);
                //add to leader table
                $add_leader = "INSERT INTO leader (user_id, pro_id) VALUES('{$user_id}', '{$pid}')";
                $add_leader_query = mysqli_query($connection, $add_leader);
            } else {
                //delete from leader
                $delete_leader = "DELETE FROM leader WHERE user_id = $user_id ";
                $delete_leader_query = mysqli_query($connection, $delete_leader);
            }
        }
    }

}
?>
                            </tbody>
                            
                        </table>
                            </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/footer.php"; ?>
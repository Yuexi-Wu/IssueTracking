<?php include "includes/header.php"; ?>
<?php
if(isset($_POST['create_pro'])) {
    $uid = $_SESSION['user_id'];
    $pro_name = $_POST['pro_name'];
    $check_query = "SELECT * FROM project WHERE name = '{$pro_name}' ";
    $check = mysqli_query($connection, $check_query);
    if(mysqli_num_rows($check) == 1) {
        $message = "Project Name Exist! Change One.";
    }  else {
        $pro_desc = $_POST['pro_desc'];
        $workflow = $_POST['workflow'];
        if(!empty($pro_name) && !empty($pro_desc)) {
            $message = "";
            $pro_desc = mysqli_real_escape_string($connection, $pro_desc);
            $pro_name = mysqli_real_escape_string($connection, $pro_name);
            $query = "INSERT INTO project (name, description, workflowId) VALUES('{$pro_name}', '{$pro_desc}', {$workflow})";
            $create_project = mysqli_query($connection, $query);
            if(!$create_project ) {
                die("QUERY FALIED" . mysqli_error($connection) . ' ' . mysqli_errno($connection));
            }
            //confirmQuery($create_project);
            //add user to leader of project
            $get_pro = "SELECT * FROM project WHERE name = '{$pro_name}'";
            $get_pro_query = mysqli_query($connection, $get_pro);
            $row = mysqli_fetch_assoc($get_pro_query);
            $pro_id = $row['pro_Id'];
            $insert_leader = "INSERT INTO leader (user_id, pro_id) VALUES({$uid}, {$pro_id})";
            $insert_query = mysqli_query($connection, $insert_leader);
            if(!$insert_query) {
                die("QUERY FALIED" . mysqli_error($connection) . ' ' . mysqli_errno($connection));
            }
            $insert_participate = "INSERT INTO participate (user_id, pro_id) VALUES({$uid}, {$pro_id})";
            $insert_query = mysqli_query($connection, $insert_participate);
            if(!$insert_query) {
                die("QUERY FALIED" . mysqli_error($connection) . ' ' . mysqli_errno($connection));
            }
            header("Location: project.php");
        } else{
            $message = "Fields cannot be Empty!";
        }
        
    }
    
} else {
    $message="";
}
?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Create Project
                        </h1>
                        <form role="form" action="createProject.php" method="post" enctype="multipart/form-data">
                           <h6 class="text-center"><?php echo $message; ?></h6>
                            <div class="form-group">
                                <label for="pro_name">Project Name</label>
                                <input type="text" class="form-control" name="pro_name">
                            </div>
                            <div class="form-group">
                                <label for="pro_desc">Project Description</label>
                                <input type="text" class="form-control" name="pro_desc">
                            </div>
                            <div class="form-group">
                                <label for="pro_workflow">Workflow</label>
                                <select class="form-control" name="workflow">
                                 <?php
                                    $query = "SELECT * FROM workflow";
                                    $select_workflow = mysqli_query($connection, $query);
                                    while($row = mysqli_fetch_assoc($select_workflow)) {
                                        $work_id = $row['workflowId'];
                                        $name = $row['name'];
                                        echo "<option value='{$work_id}'>{$name}</option>";
                                    }
                                    ?>
                                </select>
                              </div>
                            <div class="form-group">
                              <input class="btn btn-primary" type="submit" name="create_pro" value="Create">
                          </div>
                            
                        </form>
                            
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/footer.php"; ?>
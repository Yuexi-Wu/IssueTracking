<?php include "includes/header.php"; ?>
<?php
if(isset($_GET)) {
    $pid = $_GET['pid'];
    $proQuery = "SELECT * FROM project WHERE pro_id = '{$pid}'";
    $proResult = mysqli_query($connection, $proQuery);
    $row = mysqli_fetch_assoc($proResult);
    $pro_name = $row['name'];
    $pro_desc = $row['description'];
    $pro_work = $row['workflowId'];
}
?>
<?php
if(isset($_POST['edit_pro'])) {
    $pid = $_GET['pid'];
    $pro_name = $_POST['pro_name'];
    $pro_desc = $_POST['pro_desc'];
    $pro_work = $_POST['workflow'];
    $query = "UPDATE project SET name = '{$pro_name}', description = '{$pro_desc}', workflowId = {$pro_work} WHERE pro_id = '{$pid}'";
    $edit_project = mysqli_query($connection, $query);
    confirmQuery($edit_project);
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
                            Project Details
                        </h1>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="post_status">Project Name</label>
                                <input type="text" value="<?php echo $pro_name; ?>" class="form-control" name="pro_name">
                            </div>
                            <div class="form-group">
                                <label for="post_status">Project Description</label>
                                <input type="text" value="<?php echo $pro_desc; ?>" class="form-control" name="pro_desc">
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
                                        if($work_id == $pro_work) {
                                            echo "<option value='{$work_id}' selected>{$name}</option>";
                                        } else {
                                            echo "<option value='{$work_id}'>{$name}</option>";
                                        }   
                                    }
                                    ?>
                                </select>
                              </div>
                            <div class="form-group">
                              <input class="btn btn-primary" type="submit" name="edit_pro" value="Update Project">
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
<?php include "includes/header.php"; ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">
                <div class="container-fluid col-md-10">
                <!-- Page Heading -->
                <div class="row">
                    <div class="container-fluid col-lg-10">
                        <h3>Projects</h3>
                        
                        <?php
                            if(isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $query = "SELECT * FROM participate WHERE user_id = '{$user_id}'";
                                $select_participate_query = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_assoc($select_participate_query)) {
                                    $pro_id = $row['pro_id'];
                                    $query = "SELECT * FROM project WHERE pro_id = '{$pro_id}'";
                                    $select_project_query = mysqli_query($connection, $query);
                                    $pro_row = mysqli_fetch_assoc($select_project_query);
                                    $pro_name = $pro_row['name'];
                                    $pro_desc = $pro_row['description'];
                                    ?>
                                    
                                    <div class="card border-dark mb-3" style="max-width: 18rem;">
                                      <a class="text-decoration-none" href="pro_issue.php?pid=<?php echo $pro_id; ?>">
                                        <!-- <?php $_SESSION['pid'] = $pro_id;?> -->
                                      <div class="card-header"><?php echo $pro_name;?></div>
                                      <div class="card-body text-dark">
                                        <h5 class="card-title"><?php echo $pro_desc; ?></h5>
                                      </div>
                                      </a>
                                    </div>
                                    
                                    <?php
                                }
                            }
                            ?>
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
            </div>
        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/footer.php"; ?>
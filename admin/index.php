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
                        <h1 class="page-header">
                            Welcome to Issue Tracking System
                            <small>
                            <?php

                    if(isset($_SESSION['username'])) {
                        echo $_SESSION['username'];

                    }

                    ?>
                            </small>
                        </h1>
                        <h3>Projects</h3>
                        <table class="table table-bordered table-hover">
                            <thread>
                                <tr>
                                    <th>Project Name</th>
                                </tr>
                            </thread>
                            <tbody>
                                <?php
                                $uid = $_SESSION['user_id'];
                                $query = "SELECT * FROM participate WHERE user_id = $uid";
                                $select_query = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_assoc($select_query)) {
                                    $pid = $row['pro_id'];
                                    $query = "SELECT * FROM project WHERE pro_Id = $pid";
                                    $pro_query = mysqli_query($connection, $query);
                                    $pro_row = mysqli_fetch_assoc($pro_query);
                                    $pro_name = $pro_row['name'];
                                    ?>
                                    <tr>
                                        <td><?php echo $pro_name; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <h3>Issues</h3>
                        <table class="table table-bordered table-hover">
                            <thread>
                                <tr>
                                    <th>Issue Title</th>
                                    <th>Reporter</th>
                                    <th>Assignee</th>
                                </tr>
                            </thread>
                            <tbody>
                                <?php
                                $uid = $_SESSION['user_id'];
                                $username = $_SESSION['username'];
                                $query = "SELECT * FROM issue WHERE reporter = $uid";
                                $select_report = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_assoc($select_report)) {
                                    $issueId = $row['issue_id'];
                                    $title = $row['title'];  
                                    $assign_query = "SELECT * FROM assignee WHERE user = $uid and issue = $issueId";
                                    $assign = mysqli_query($connection, $assign_query);
                                    if(mysqli_num_rows($assign) != 0) {
                                    $assign_row = mysqli_fetch_assoc($assign);
                                    $assign_id = $assign_row['user'];
                                    $assign_name_query = "SELECT * FROM user WHERE user_id = $assign_id";
                                    $select_assign_name = mysqli_query($connection, $assign_name_query);
                                    $assign_row = mysqli_fetch_assoc($select_assign_name);
                                    $assignee = $assign_row['displayname'];
                                    ?>
                                    <tr>
                                        <td><?php echo $title; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo $assignee; ?></td>
                                    </tr>
                                    <?php
                                    }
                                }
                                //assignee is this user
                                $query = "SELECT * FROM assignee WHERE user = $uid";
                                $select_assignee = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_assoc($select_assignee)) {
                                    $issue_id = $row['issue'];
                                    $select_issue = "SELECT * FROM issue WHERE issue_id = $issue_id";
                                    $select_issue_query = mysqli_query($connection, $select_issue);
                                    $issue_row = mysqli_fetch_assoc($select_issue_query);
                                    $title = $issue_row['title'];
                                    $reporter = $issue_row['reporter'];
                                    if($uid != $reporter) {
                                        //the issue reporter and assignee is the same person
                                        $report_name_query = "SELECT * FROM user WHERE user_id = $reporter";
                                        $select_report_name = mysqli_query($connection, $report_name_query);
                                        $report_row = mysqli_fetch_assoc($select_report_name);
                                        $report_name = $report_row['displayname'];
                                        ?>
                                        <tr>
                                            <td><?php echo $title; ?></td>
                                            <td><?php echo $report_name; ?></td>
                                            <td><?php echo $username; ?></td>
                                        </tr>
                                        <?php
                                    }                           
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
            </div>
        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/footer.php"; ?>
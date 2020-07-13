<?php include "includes/header.php"; ?>
<?php
if(isset($_GET)) {
    $pid = $_GET['pid'];
    $user_id = $_SESSION['user_id'];
    $proQuery = "SELECT * FROM project WHERE pro_id = '{$pid}'";
    $proResult = mysqli_query($connection, $proQuery);
    $row = mysqli_fetch_array($proResult);
    $pro_name = $row['name'];
}
?>
    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navigation.php"; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
            <?php
            if(isset($_SESSION['response'])){
            ?>
            <div class="alert alert-<?= $_SESSION['res_type']?> alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= $_SESSION['response'];?>
            </div>
            <?php
            }
            unset($_SESSION['response']);
            ?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $pro_name; ?>
                        </h1>
                        
                        <?php
                        $query = "SELECT distinct issue.issue_id as issue, issue.pro_id, title, description, reporter, status.name as status
                        FROM issue left join (select issue_history.issue_id as id, to_status
                                            from issue_history, (select issue_id, max(update_time) as max from issue_history group by issue_id) as latest
                                            where issue_history.issue_id = latest.issue_id and issue_history.update_time = latest.max) as cur_status on cur_status.id = issue.issue_id, status
                        WHERE cur_status.to_status = status.status_id and issue.pro_id = ?";
                        $stmt = $mysqli->prepare($query);
                        $stmt->bind_param("i", $pro_id);
                        $stmt->execute();
                        $result=$stmt->get_result();
                        ?>
                        <h3 class="text-center text-dark">Current Issues:</h3>
                        <p>As project lead:</p>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Issue ID</th>
                                    <th>Project</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Reporter</th>
                                    <th>Assignee</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($row = $result->fetch_assoc()){
                                ?>
                                <tr>
                                    <td><?= $row['issue']; ?></td>
                                    <td><?= $row['pro_id']; ?></td>
                                    <td><?= $row['title']; ?></td>
                                    <td><?= $row['description']; ?></td>
                                    <td><?= $row['reporter']; ?></td>
                                    <td>
                                        <ul>
                                            <?php
                                                $queryAssignee = "SELECT distinct username
                                                FROM assignee, user
                                                WHERE issue = ? and assignee.user = user.user_id";
                                                $stmt = $mysqli->prepare($queryAssignee);
                                                $stmt->bind_param("i", $row['issue']);
                                                $stmt->execute();
                                                $assigneeResult=$stmt->get_result();
                                                while ($assignrow = $assigneeResult->fetch_assoc()) {
                                            ?>
                                            <li>
                                                <?= $assignrow['username']; ?>
                                            </li>
                                            <?php
                                                }
                                            ?>
                                        </ul>
                                    </td>
                                    <td><?= $row['status']; ?></td>
                                </tr>
                                <?php
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
        <!-- /#page-wrapper -->
    <?php include "includes/footer.php"; ?>
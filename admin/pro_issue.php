<?php include "includes/header.php"; ?>
<?php
if(isset($_GET) || isset($_POST)) {
    $pid = $_GET['pid'];
    $_SESSION['pid'] = $pid;
    $user_id = $_SESSION['user_id'];
    $pid = $_SESSION['pid'];
    $proQuery = "SELECT * FROM project WHERE pro_id = '{$pid}'";
    $proResult = mysqli_query($connection, $proQuery);
    $row = mysqli_fetch_array($proResult);
    $pro_name = $row['name'];
}

if(isset($_POST["addIssue"])) {
    $user_id = $_SESSION['user_id'];
    $pro_id = $_POST["pro_id"];
    $pid = $pro_id;
    $issue_title = $_POST["issue_title"];
    $issue_description = $_POST["issue_description"];
    //$reporter = $_POST["reporter"];

    $insertion = "INSERT INTO issue (create_time, title, description, pro_id, reporter) VALUES (NOW(), '".$issue_title."', '".$issue_description."', '".$pro_id."', '".$user_id."')";
    $mysqli->query($insertion);

    $insertHistory = "INSERT INTO issue_history (issue_id, to_status, by_uid) VALUES((select issue_id
    from issue
    order by issue_id desc
    limit 1), 0, '".$user_id."')";

    $stmt = $mysqli->prepare($insertHistory);
    $stmt->execute();

    $_SESSION['response'] = "Successfully submitted an issue! Now start on that!";
    $_SESSION['res_type'] = "success";    
}

if(isset($_POST["assign"])) {
    $issue_id = $_GET['issue'];
    $assignee = $_POST['assignees'];

    $querypro = "SELECT pro_id FROM issue WHERE issue_id = '".$issue_id."'";
    $stmt = $mysqli->prepare($querypro);
    $stmt->execute();
    $result=$stmt->get_result();
    $row = $result->fetch_assoc();
    $pid = $row['pro_id'];
    $query = "INSERT INTO assignee(issue, user) 
    VALUES('".$issue_id."', '".$assignee."')";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $_SESSION['response'] = "Successfully assigned the issue!";
    $_SESSION['res_type'] = "success";
}

if(isset($_POST["nextStatus"])) {
    $user_id = $_SESSION['user_id'];
    $next_status = $_POST['next_status'];
    $issue_id = $_GET['next'];

    $querypro = "SELECT pro_id FROM issue WHERE issue_id = '".$issue_id."'";
    $stmt = $mysqli->prepare($querypro);
    $stmt->execute();
    $result=$stmt->get_result();
    $row = $result->fetch_assoc();
    $pid = $row['pro_id'];

    $query = "INSERT INTO issue_history(issue_id, to_status, update_time, by_uid) VALUES (".$issue_id.", ".$next_status.", NOW(), '".$user_id."')";
    $mysqli->query($query);

    $_SESSION['response'] = "Successfully updated the status!";
    $_SESSION['res_type'] = "success";
}

if(isset($_POST["updateIssue"])) {
    $user_id = $_SESSION['user_id'];
    $issue_id = $_POST["issue"];
    $issue_title = $_POST["issue_title"];
    $issue_description = $_POST["issue_description"];

    $querypro = "SELECT pro_id FROM issue WHERE issue_id = '".$issue_id."'";
    $stmt = $mysqli->prepare($querypro);
    $stmt->execute();
    $result=$stmt->get_result();
    $row = $result->fetch_assoc();
    $pid = $row['pro_id'];

    $update = "UPDATE issue
    SET title = '".$issue_title."', description = '".$issue_description."'
    WHERE issue_id = '".$issue_id."'";

    $stmt = $mysqli->prepare($update);
    $stmt->execute();

    $_SESSION['response'] = "Successfully updated the issue!";
    $_SESSION['res_type'] = "success";    
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
                        
                        <!-- <input type="text" name="search" placeholder="Search.."> -->
                        <?php
                        // echo $user_id;
                        if(isset($_POST["searchIssue"])) {
                            $keyword = $_POST['search_issue'];
                            $query = "SELECT distinct issue.issue_id as issue, project.name as pro_id, title, issue.description, reporter, status.name as status
                            FROM issue left join (select issue_history.issue_id as id, to_status
                            from issue_history, (select issue_id, max(update_time) as max from issue_history group by issue_id) as latest
                            where issue_history.issue_id = latest.issue_id and issue_history.update_time = latest.max) as cur_status on cur_status.id = issue.issue_id, status, leader, project
                            WHERE cur_status.to_status = status.status_id and issue.pro_id = leader.pro_id and leader.user_id = '".$user_id."' and issue.pro_id = '".$pid."' and project.pro_id = issue.pro_id
                            and (issue.title like '%$keyword%' or issue.description like '%$keyword%')";
                            $stmt = $mysqli->prepare($query);
                            // $stmt->bind_param("ss", $keyword, $keyword);
                            $stmt->execute();
                            $result=$stmt->get_result();
                        } else {
                            $query = "SELECT distinct issue.issue_id as issue, project.name as pro_id, title, issue.description, reporter, status.name as status
                            FROM issue left join (select issue_history.issue_id as id, to_status
                            from issue_history, (select issue_id, max(update_time) as max from issue_history group by issue_id) as latest
                            where issue_history.issue_id = latest.issue_id and issue_history.update_time = latest.max) as cur_status on cur_status.id = issue.issue_id, status, leader, project
                            WHERE cur_status.to_status = status.status_id and issue.pro_id = leader.pro_id and leader.user_id = '".$user_id."' and issue.pro_id = '".$pid."' and project.pro_id = issue.pro_id";
                            $stmt = $mysqli->prepare($query);
                            // $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result=$stmt->get_result();
                        }
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
                                    <th>Action</th>
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
                                    <?php
                                            $reporter = $row['reporter'];
                                            $queryReporter = "SELECT username
                                            FROM user
                                            WHERE user_id = ?";
                                            $stmt = $mysqli->prepare($queryReporter);
                                            $stmt->bind_param("i", $row['reporter']);

                                            $stmt->execute();
                                            $reportername=$stmt->get_result();
                                            while ($reportrow = $reportername->fetch_assoc()) {
                                        ?>
                                    <td>   
                                        <?= $reportrow['username']?>       
                                    </td>
                                    <?
                                        }
                                    ?>
                                    <!-- <td><?= $row['reporter']; ?></td> -->
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
                                    <td>
                                        <a href="assign.php?pid=<?php echo $pid; ?>&assign=<?= $row['issue'];?>" class="badge badge-danger p-2">Assign</a>
                                        <a href="nextStatus.php?pid=<?php echo $pid; ?>&next=<?= $row['issue'];?>" class="badge badge-success p-2">NextStatus</a>
                                        <a href="history.php?pid=<?php echo $pid; ?>&history=<?= $row['issue'];?>" class="badge badge-primary p-2">History</a>
                                        <a href="updateIssue.php?pid=<?php echo $pid; ?>&edit=<?= $row['issue'];?>" class="badge badge-danger p-2">Edit</a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        if(isset($_POST["searchIssue"])) {
                            $keyword = $_POST['search_issue'];
                            $query = "SELECT distinct issue.issue_id as issue, project.name as pro_id, title, issue.description, reporter, status.name as status
                            FROM issue left join (select issue_history.issue_id as id, to_status
                            from issue_history, (select issue_id, max(update_time) as max from issue_history group by issue_id) as latest
                            where issue_history.issue_id = latest.issue_id and issue_history.update_time = latest.max) as cur_status on cur_status.id = issue.issue_id, status, assignee, project
                            WHERE cur_status.to_status = status.status_id and issue.issue_id = assignee.issue and assignee.user = '".$user_id."' and issue.pro_id = '".$pid."' and project.pro_id = issue.pro_id
                            and (issue.title like '%$keyword%' or issue.description like '%$keyword%')";
                            $stmt = $mysqli->prepare($query);
                            // $stmt->bind_param("ss", $keyword, $keyword);
                            $stmt->execute();
                            $result=$stmt->get_result();
                        } else {
                            $query = "SELECT distinct issue.issue_id as issue, project.name as pro_id, title, issue.description, reporter, status.name as status
                            FROM issue left join (select issue_history.issue_id as id, to_status
                            from issue_history, (select issue_id, max(update_time) as max from issue_history group by issue_id) as latest
                            where issue_history.issue_id = latest.issue_id and issue_history.update_time = latest.max) as cur_status on cur_status.id = issue.issue_id, status, assignee, project
                            WHERE cur_status.to_status = status.status_id and issue.issue_id = assignee.issue and assignee.user = '".$user_id."' and issue.pro_id = '".$pid."' and project.pro_id = issue.pro_id";
                            $stmt = $mysqli->prepare($query);
                            // $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result=$stmt->get_result();
                        }
                        ?>
                        <p>As assignee:</p>
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
                                    <th>Action</th>
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
                                    <?php
                                            $reporter = $row['reporter'];
                                            $queryReporter = "SELECT username
                                            FROM user
                                            WHERE user_id = ?";
                                            $stmt = $mysqli->prepare($queryReporter);
                                            $stmt->bind_param("i", $row['reporter']);

                                            $stmt->execute();
                                            $reportername=$stmt->get_result();
                                            while ($reportrow = $reportername->fetch_assoc()) {
                                        ?>
                                    <td>   
                                        <?= $reportrow['username']?>       
                                    </td>
                                    <?
                                        }
                                    ?>
                                    <!-- <td><?= $row['reporter']; ?></td> -->
                                    <td>
                                        <!-- <?= $row['assignee']; ?> -->
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
                                    <td>
                                        <a href="nextStatus.php?pid=<?php echo $pid; ?>&next=<?= $row['issue'];?>" class="badge badge-success p-2">NextStatus</a>
                                        <a href="history.php?pid=<?php echo $pid; ?>&history=<?= $row['issue'];?>" class="badge badge-primary p-2">History</a>
                                        <a href="updateIssue.php?pid=<?php echo $pid; ?>&edit=<?= $row['issue'];?>" class="badge badge-danger p-2">Edit</a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>  
                        <?php
                        if(isset($_POST["searchIssue"])) {
                            $keyword = $_POST['search_issue'];
                            $query = "SELECT distinct issue.issue_id as issue, project.name as pro_id, title, issue.description, reporter, status.name as status
                            FROM issue left join (select issue_history.issue_id as id, to_status
                                                from issue_history, (select issue_id, max(update_time) as max from issue_history group by issue_id) as latest
                                                where issue_history.issue_id = latest.issue_id and issue_history.update_time = latest.max) as cur_status on cur_status.id = issue.issue_id, status, user, project
                            WHERE cur_status.to_status = status.status_id and issue.pro_id = '".$pid."' and issue.issue_id not in(select issue_id from leader, issue where user_id = '".$user_id."' and issue.pro_id = leader.pro_id) 
                            and issue.issue_id not in (select issue from assignee where assignee.user = '".$user_id."') and project.pro_id = issue.pro_id
                            and (issue.title like '%$keyword%' or issue.description like '%$keyword%')";
                            $stmt = $mysqli->prepare($query);
                            // $stmt->bind_param("ss", $keyword, $keyword);
                            $stmt->execute();
                            $result=$stmt->get_result();
                        } else {
                            $query = "SELECT distinct issue.issue_id as issue, project.name as pro_id, title, issue.description, reporter, status.name as status
                            FROM issue left join (select issue_history.issue_id as id, to_status
                                                from issue_history, (select issue_id, max(update_time) as max from issue_history group by issue_id) as latest
                                                where issue_history.issue_id = latest.issue_id and issue_history.update_time = latest.max) as cur_status on cur_status.id = issue.issue_id, status, user, project
                            WHERE cur_status.to_status = status.status_id and issue.pro_id = '".$pid."' and issue.issue_id not in(select issue_id from leader, issue where user_id = '".$user_id."' and issue.pro_id = leader.pro_id) 
                            and issue.issue_id not in (select issue from assignee where assignee.user = '".$user_id."') and project.pro_id = issue.pro_id";
                            $stmt = $mysqli->prepare($query);
                            // $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result=$stmt->get_result();
                        }
                        ?>
                        <p>Others:</p>
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
                                    <?php
                                            $reporter = $row['reporter'];
                                            $queryReporter = "SELECT username
                                            FROM user
                                            WHERE user_id = ?";
                                            $stmt = $mysqli->prepare($queryReporter);
                                            $stmt->bind_param("i", $row['reporter']);

                                            $stmt->execute();
                                            $reportername=$stmt->get_result();
                                            while ($reportrow = $reportername->fetch_assoc()) {
                                        ?>
                                    <td>   
                                        <?= $reportrow['username']?>       
                                    </td>
                                    <?
                                        }
                                    ?>
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
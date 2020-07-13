<?php
    include 'includes/header.php';
?>
<div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navigation.php"; ?>

        <div id="page-wrapper">
    <div class="container-fluid">
        <div class="col-md-10">
            <h3 class="text-center text-dark mt-2">  </h3>
            <hr>
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
        </div>
    <div class="container-fluid col-md-6">
        <?php
            $id = $_GET['history'];
        $pid = $_GET['pid'];
            $query = "SELECT issue_id, name as to_status, username, update_time
            FROM issue_history, user, status
            WHERE issue_id = ? and user.user_id = by_uid and status_id = to_status";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result=$stmt->get_result();
        ?>
        <h3 class="text-center text-dark">Update History</h3>
        <br>
        <table class="table table-condensed table-hover text-center">
            <thead>
                <tr>
                    <th>Issue ID</th>
                    <th>Status</th>
                    <th>Update By</th>
                    <th>Update Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($row = $result->fetch_assoc()){
                ?>
                <tr>
                    <td><?= $row['issue_id']; ?></td>
                    <td><?= $row['to_status']; ?></td>
                    <td><?= $row['username']; ?></td>
                    <td><?= $row['update_time']; ?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        <button  onclick="history.go(-1);" class="btn-primary">Back </button>
    </div>
            </div>
    </div>
</body>
</html>

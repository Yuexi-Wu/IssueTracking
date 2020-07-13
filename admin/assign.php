<?php
    include 'includes/header.php';
?>
<div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navigation.php"; ?>

        <div id="page-wrapper">

    <div class="container-fluid">
        <div class="col-md-10">
            <h3 class="text-center text-dark mt-2">Assign the issue to member</h3>
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
        <div class="row">
            <?php
                $id = $_GET['assign'];
            $pid = $_GET['pid'];
                $query = "SELECT user.user_id as user_id, username
                FROM issue, project, participate, user
                WHERE issue.pro_id = project.pro_id and project.pro_id = participate.pro_id and participate.user_id not in (select user 
                            from assignee
                            where issue = ?) 
                and participate.user_id = user.user_id and issue_id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("ii", $id, $id);
                $stmt->execute();
                $result=$stmt->get_result();
            ?>
            <div class="container-fluid col-md-6">
                <h3 class="text-center text-dark">:</h3>
                <form action="pro_issue.php?pid=<?php echo $pid;?>&issue=<?= $id;?>" method="post" enctype="multipart/form-data" id="assign">
                    <input type="hidden" name="issue" value="<?= $issue;?>">
                    <div class="form-group">
                        <label for="assignees">Select project member you want to assign the issue to:</label>
                        <select class="form-control" name="assignees" id="assignees">
                            <?php
                                while($row = $result->fetch_assoc()){
                            ?>
                            <option value="<?= $row['user_id']; ?>"><?= $row['username']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="assign" class="btn btn-success btn-block" value="Assign Issue">
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
    
</body>
</html>

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
        <div class="row">
            <?php
                $id = $_GET['next'];
            $pid = $_GET['pid'];
                $query = "SELECT distinct status.name as next_status, t.next_status as status_id
                FROM issue i, project p, transition t, status
                WHERE p.pro_Id = i.pro_Id and p.workflowId = t.workflowId and status.status_id = t.next_status and t.cur_status = (select to_status
                from issue_history
                where issue_id = ?
                order by update_time desc
                limit 1)";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result=$stmt->get_result();
            ?>
            <div class="container-fluid col-md-6">
                <h3 class="text-center text-dark">Select next status:</h3>
                <form action="pro_issue.php?pid=<?php echo $pid; ?>&next=<?= $id;?>" method="post" enctype="multipart/form-data" id="nextStatus">
                    <div class="form-check">
                        <input type="hidden" name="issue" id="issue" value="$id">
                        <?php
                            while($row = $result->fetch_assoc()){
                        ?>
                        <input class="form-check-input" type="radio" name="next_status" id="next_status" value="<?= $row['status_id']; ?>">
                        <label class="form-check-label" for="next_status">
                            <?= $row['next_status']; ?>
                        </label>
                        <br>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="nextStatus" class="btn btn-success btn-block" value="Change Status">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
    
</body>
</html>

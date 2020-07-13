<?php
    include 'includes/header.php';
?>
<div id="wrapper">
        <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <div id="page-wrapper">
    <div class="container-fluid">
        <div class="col-md-10">
            <h3 class="text-center text-dark mt-2"> </h3>
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
                //$id = $_GET['next'];
            $pid = $_GET['pid'];
                $user_id = $_SESSION['user_id'];
                $query = "SELECT pro_id as project
                FROM participate
                WHERE user_id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result=$stmt->get_result();
            ?>
            <div class="container-fluid col-md-6">
                <h3 class="text-center text-dark">Create a new issue</h3>
                <form action="pro_issue.php?pid=<?php echo $pid; ?>" method="post" enctype="multipart/form-data" id="addIssue">
                    <input type="hidden" name="issue" value="<?= $issue;?>">
                    <div class="form-group">
                        <label for="project">Select project:</label>
                        <select class="form-control" name="pro_id" id="project">
                            <?php
                                while($row = $result->fetch_assoc()){
                            ?>
                            <option><?= $row['project']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="issue_title">Issue Title:</label><br>
                        <input type="text" name="issue_title" class="form-control" placeholder="Enter Title" required>
                    </div>
                    <div class="form-group">
                        <label for="issue_description">Issue Description:</label>
                        <textarea class="form-control" rows="5" name="issue_description" id="issue_description" placeholder="Enter Description" required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="addIssue" class="btn btn-success btn-block" value="Submit Issue">
                    </div>
                </form>
            </div>
        </div>
        </div>
        
    </div>
</div>
    
</body>
</html>

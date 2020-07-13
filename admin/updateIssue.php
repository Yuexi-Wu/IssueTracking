
<?php include "includes/header.php"; ?>
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
            <div class="container-fluid col-md-6">
                <h3 class="text-center text-dark">Edit the issue</h3>
                <?php
                if(isset($_GET["edit"])) {
                    $pid = $_GET['pid'];
                    $issue_id = $_GET['edit'];
                    $issueQuery = "SELECT pro_id, title, description
                    FROM issue
                    WHERE issue_id = '".$issue_id."'";
                    $stmt = $mysqli->prepare($issueQuery);
                    $stmt->execute();
                    $issueresult=$stmt->get_result();
                    $issuerow = $issueresult->fetch_assoc();
                    $proid = $issuerow['pro_id'];
                    $title = $issuerow['title'];
                    $des = $issuerow['description'];
                }
                ?>
                <form action="pro_issue.php?pid=<?php echo $pid; ?>" method="post" enctype="multipart/form-data" id="updateIssue">
                    <input type="hidden" name="issue" value="<?= $issue_id;?>">
                    <div class="form-group">
                        <label for="project">Select project:</label>
                        <select class="form-control" name="pro_id" id="project">
                            <option selected><?= $proid ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="issue_title">Issue Title:</label><br>
                        <input type="text" name="issue_title" class="form-control" placeholder="Enter Title" required value="<?= $title ?>">
                    </div>
                    <div class="form-group">
                        <label for="issue_description">Issue Description:</label>
                        <textarea class="form-control" rows="5" name="issue_description" id="issue_description" placeholder="Enter Description" required value="<?= $des ?>"><?= $des ?></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="updateIssue" class="btn btn-success btn-block" value="Update Issue">
                    </div>
                </form>
            </div>
        </div>
        </div>
        
    </div>
</div>
    
</body>
</html>

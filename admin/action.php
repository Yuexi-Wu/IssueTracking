<?php
    // session_start();
    include "includes/db.php";

    if(isset($_POST["addIssue"])) {
        $user_id = $_SESSION['user_id'];
        $pro_id = $_POST["pro_id"];
        $issue_title = $_POST["issue_title"];
        $issue_description = $_POST["issue_description"];
        $reporter = $_POST["reporter"];

        $insertion = "INSERT INTO issue (create_time, title, description, pro_id, reporter) VALUES (NOW(), '".$issue_title."', '".$issue_description."', '".$pro_id."', '".$user_id."')";
        $mysqli->query($insertion);

        $insertHistory = "INSERT INTO issue_history (issue_id, to_status, by_uid) VALUES((select issue_id
        from issue
        order by issue_id desc
        limit 1), 0, '".$user_id."')";

        $stmt = $mysqli->prepare($insertHistory);
        $stmt->execute();

        header('location:pro_issue.php');
        $_SESSION['response'] = "Successfully submitted an issue! Now start on that!";
        $_SESSION['res_type'] = "success";
        
    }

    if(isset($_POST["nextStatus"])) {
        $user_id = $_SESSION['user_id'];
        $next_status = $_POST['next_status'];
        $issue_id = $_GET['next'];
        $query = "INSERT INTO issue_history(issue_id, to_status, update_time, by_uid) VALUES (".$issue_id.", ".$next_status.", NOW(), '".$user_id."')";
        $mysqli->query($query);

        header('location:pro_issue.php');
        $_SESSION['response'] = "Successfully updated the status!";
        $_SESSION['res_type'] = "success";
    }

    if(isset($_POST["assign"])) {
        $issue_id = $_GET['issue'];
        // $querypro = "SELECT pro_id FROM issue WHERE issue_id = '".$issue_id."'";
        // $stmt = $mysqli->prepare($query);
        // $stmt->execute();
        // $stmt->bind_result($pid);
        $assignee = $_POST['assignees'];
        $query = "INSERT INTO assignee(issue, user) 
        VALUES(?, ?)";

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("is", $issue_id, $assignee);
        $stmt->execute();

        header('location:pro_issue.php');
        $_SESSION['response'] = "Successfully assigned the issue!";
        $_SESSION['res_type'] = "success";
    }

    if(isset($_POST["updateIssue"])) {
        $user_id = $_SESSION['user_id'];
        $issue_id = $_POST["issue"];
        $issue_title = $_POST["issue_title"];
        $issue_description = $_POST["issue_description"];

        $update = "UPDATE issue
        SET title = '".$issue_title."', description = '".$issue_description."'
        WHERE issue_id = '".$issue_id."'";

        $stmt = $mysqli->prepare($update);
        $stmt->execute();

        header('location:pro_issue.php');
        $_SESSION['response'] = "Successfully updated the issue!";
        $_SESSION['res_type'] = "success";
        
    }

?>

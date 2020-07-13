   <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Issue Tracking</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <?php
            if(isset($_GET['pid'])) {
                $pid = $_GET['pid'];
            }
            ?>
            <ul class="navbar-nav mr-auto">
               <li class="nav-item">
                <a class="nav-link" href="pro_issue.php?pid=<?php echo $pid; ?>">Back to Project</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pro_detail.php?pid=<?php echo $pid; ?>">Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pro_access.php?pid=<?php echo $pid; ?>">Access</a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
            </ul>
            
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php

                    if(isset($_SESSION['username'])) {
                        echo $_SESSION['username'];

                    }

                    ?>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="profile.php">Profile</a>
                <a class="dropdown-item" href="login.php">Logout</a>
                
              </div>
            </div>
        </div>
        
        
        
        
    </nav>
           
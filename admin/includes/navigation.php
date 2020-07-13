   <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Issue Tracking</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">My Work</a>
                </li>
               <li class="nav-item">
                <a class="nav-link" href="project.php">Projects</a>
                </li>
                 <li class="nav-item">
                <a class="nav-link" href="createProject.php">Create Project</a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
                <?php
                    if(isset($_GET['pid'])) {
                        $pid = $_GET['pid'];
                        echo "<li class='nav-item'>
                        <a class='nav-link' href='pro_detail.php?pid={$pid}'>Project Settings</a>
                    </li>";
                        echo "<li class='nav-item'>
                        <a class='nav-link' href='createIssue.php?pid={$pid}'>Create Issue</a>
                    </li>";
                        ?>
                        
                      <form action="pro_issue.php?pid=<?php echo $pid; ?>" method="post" id="searchIssue" class="form-inline my-2 my-lg-0">
                          <input class="form-control mr-sm-2" type="search" name="search_issue" placeholder="Search Issue" aria-label="Search">
                          <input type="submit" name="searchIssue" class="btn btn-outline-success my-2 my-sm-0" value="Search">
                          
                        </form>  
                        <?php
                    }
                    ?>
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
           
            
            
            
<?php

require_once( './Includes/DB.php' );
require_once( './Includes/Functions.php' );
require_once( './Includes/Sessions.php' );

$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
Confirm_Login();
?>

<!DOCTYPE html>
<html lang = 'en'>
<head>
<meta charset = 'UTF-8' />
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0' />
<meta http-equiv = 'X-UA-Compatible' content = 'ie=edge' />
<!-- CSS only -->
<link
href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css'
rel = 'stylesheet'
integrity = 'sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1'
crossorigin = 'anonymous'
/>
<!-- css -->
<link rel = 'stylesheet' href = './Css/styles.css'>
<!-- font awesome -->
<script src = 'https://kit.fontawesome.com/918054a49e.js' crossorigin = 'anonymous'></script>
<title>Dashboard</title>
</head>
<body>
<!-- Navbar -->

<nav class = 'navbar navbar-expand-lg navbar-dark bg-dark'>
    <div class = 'container'>
        <a href = '#' class = 'navbar-brand'>Ericcentrik.com</a>
        <button class = 'navbar-toggler' type = 'button' data-bs-toggle = 'collapse' data-bs-target = '#navbarcollapseCMS' aria-controls = 'navbarcollapseCMS' aria-expanded = 'false' aria-label = 'Toggle navigation'>
        <span class = 'navbar-toggler-icon'></span>
        </button>
        <div class = 'collapse navbar-collapse' id = 'navbarcollapseCMS'>
            <ul class = 'navbar-nav mx-auto'>
                <li class = 'nav-item'>
                <a href = 'MyProfile.php' class = 'nav-link'><i class = 'fas fa-user text-success'></i> My Profile</a>
                </li>
                <li class = 'nav-item'>
                <a href = 'Dashboard.php' class = 'nav-link'>Dashboard</a>
                </li>
                <li class = 'nav-item'>
                <a href = 'Posts.php' class = 'nav-link'>Post</a>
                </li>
                <li class = 'nav-item'>
                <a href = 'Categories.php' class = 'nav-link'>Categories</a>
                </li>
                <li class = 'nav-item'>
                <a href = 'Admins.php' class = 'nav-link'>Manage Admins</a>
                </li>
                <li class = 'nav-item'>
                <a href = 'Comments.php' class = 'nav-link'>Comments</a>
                </li>
                <li class = 'nav-item'>
                <a href = 'Blog.php?page=1' class = 'nav-link'>Live Blog</a>
                </li>
            </ul>
            <ul class = 'navbar-nav mx-auto'>
                <li class = 'nav-item'><a href = 'Logout.php' class = 'nav-link text-danger'><i class = 'fas fa-user-times'></i> Logout</a></li>
            </ul>
        </div> <!--ending toggle button-->
    </div>
</nav>
<div style = 'height:10px; background: #27aee1;'></div> <!--end navbar-->

<header class = 'bg-dark text-white py-3'>
    <div class = 'container'>
        <div class = 'row'>
            <div class = 'col-md-12'>
            <h1 class = 'title'><i class = 'fas fa-cog' style = 'color:#27aae1;'></i> Dashboard</h1>
            </div>
            <div class = 'col-lg-3 mb-2'>
            <a href = 'AddNewPost.php' class = 'btn btn-primary d-block'>
            <i class = 'fas fa-edit'>Add New Post</i>
            </a>
            </div>
            <div class = 'col-lg-3 mb-2'>
            <a href = 'Categories.php' class = 'btn btn-info d-block'>
            <i class = 'fas fa-folder-plus'>Add New Category</i>
            </a>
            </div>
            <div class = 'col-lg-3 mb-2'>
            <a href = 'Admins.php' class = 'btn btn-warning d-block'>
            <i class = 'fas fa-user-plus'>Add New Admin</i>
            </a>
            </div>
            <div class = 'col-lg-3 mb-2'>
            <a href = 'Comments.php' class = 'btn btn-success d-block'>
            <i class = 'fas fa-check'>Approved Comments</i>
            </a>
            </div>
        </div>
    </div>
</header> <!--ending header-->

<!-- Main Area -->
<section class = 'container py-2 mb-4'>
    <div class = 'row'>
        <?php
            echo ErrorMessage();
            echo SuccessMessage();
        ?>
        <!-- left side starts  -->
        <div class = 'col-lg-2 d-none d-md-block'>

            <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                    <h1 class="lead">Posts</h1>
                    <h4 class="display-5">
                        <i class="fab fa-readme"></i>
                        <?php 
                            TotalPosts(); 
                            ?>
                    </h4>
                </div>
            </div>
            <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                    <h1 class="lead">Categories</h1>
                    <h4 class="display-5">
                        <i class="fas fa-folder"></i>
                        <?php
                            TotalCategories();
                        ?>
                    </h4>
                </div>
            </div>
            <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                    <h1 class="lead">Admins</h1>
                    <h4 class="display-5">
                        <i class="fas fa-users"></i>
                        <?php
                           TotalAdmin();
                        ?>
                    </h4>
                </div>
            </div>
            <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                    <h1 class="lead">Comments</h1>
                    <h4 class="display-5">
                        <i class="fas fa-comments"></i>
                        <?php
                            TotalComments();
                        ?>
                    </h4>
                </div>
            </div>

        </div><!-- left side ends  -->
        
        <!-- right side starts  -->
        <div class="col-lg-10">
            <h1>Top Posts</h1>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Date&Time</th>
                        <th>Author</th>
                        <th>Comments</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <?php 
                $ConnectingDB;
                $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0, 6";
                $stmt = $ConnectingDB->query($sql);
                $SrNo= 0;
                while($DataRows=$stmt->fetch()){
                    $PostId = $DataRows["id"];
                    $DateTime = $DataRows["datetime"];
                    $Author = $DataRows["author"];
                    $Title = $DataRows["title"];
                    $SrNo++;
                ?>

                <tbody>
                    <tr>
                        <td><?php echo $SrNo;?></td>
                        <td><?php echo $Title;?></td>
                        <td><?php echo $DateTime;?></td>
                        <td><?php echo $Author;?></td>
                        <td>
                                <?php $Total = ApproveCommentsAccordingtoPost($PostId);
                                if ($Total>0) {
                                ?>
                                <span class="badge bg-success">
                                    <?php
                                echo $Total; ?>
                                </span>
                                    <?php  }   ?>
                            <?php $Total = DisApproveCommentsAccordingtoPost($PostId);
                            if ($Total>0) {  ?>
                                <span class="badge bg-danger">
                                <?php
                                echo $Total; ?>
                                </span>
                                    <?php  }  ?>
                       </td>
                        <td>
                            <a href="FullPost.php?id=<?php echo $PostId; ?>" target="_blank"><span class="btn btn-info">Preview</span> </a>
                        </td>
                    </tr>
                </tbody>

                <?php  } ?>
            </table>
        </div> <!-- right side ends  -->

    </div>
</section> <!-- end mai Area -->

<footer class = 'bg-dark text-white'>
<div class = 'container'>
<div class = 'row'>
<div class = 'col'>
<p class = 'lead text-center'>Theme By | <a href = 'https://ericnaiman.com' style = 'color: white;  cursor: pointer;'>Eric Naiman </a>| <span id = 'year'></span> &copy;
'All rights Reserved'
</p>
</div>
</div>
</div>
</footer>
<div style = 'height:10px; background: #27aee1'></div> <!--ending footer-->

<script
src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js'
integrity = 'sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW'
crossorigin = 'anonymous'
></script>
<script>
document.querySelector( '#year' ).innerHTML = new Date().getFullYear();

</script>
</body>
</html>

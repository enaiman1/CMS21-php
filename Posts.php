<?php 
require_once("./Includes/DB.php");  
require_once("./Includes/Functions.php"); 
require_once("./Includes/Sessions.php"); 

$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!-- CSS only -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
      crossorigin="anonymous"
    />
    <!-- css -->
    <link rel="stylesheet" href="./Css/styles.css">
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/918054a49e.js" crossorigin="anonymous"></script>
    <title>Posts</title>
  </head>
  <body>
<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a href="#" class="navbar-brand">Ericcentrik.com</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarcollapseCMS" aria-controls="navbarcollapseCMS" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        <div class="collapse navbar-collapse" id="navbarcollapseCMS">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-success"></i> My Profile</a>
            </li>
            <li class="nav-item">
                <a href="Dashboard.php" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="Posts.php" class="nav-link">Post</a>
            </li>
            <li class="nav-item">
                <a href="Categories.php" class="nav-link">Categories</a>
            </li>
            <li class="nav-item">
                <a href="Admins.php" class="nav-link">Manage Admins</a>
            </li>
            <li class="nav-item">
                <a href="Comments.php" class="nav-link">Comments</a>
            </li>
            <li class="nav-item">
                <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
            </li>
        </ul>
        <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a href="Logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i> Logout</a></li>
        </ul>
    </div> <!--ending toggle button-->
    </div>
</nav> 
<div style="height:10px; background: #27aee1;"></div> <!--end navbar-->

<header class="bg-dark text-white py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
         <h1 class="title"><i class="fas fa-blog" style="color:#27aae1;"></i> Blog Posts</h1>
      </div>
      <div class="col-lg-3 mb-2">
          <a href="AddNewPost.php" class="btn btn-primary d-block">
            <i class="fas fa-edit">Add New Post</i>
          </a>
      </div>
      <div class="col-lg-3 mb-2">
          <a href="Categories.php" class="btn btn-info d-block">
            <i class="fas fa-folder-plus">Add New Category</i>
          </a>
      </div>
      <div class="col-lg-3 mb-2">
          <a href="Admins.php" class="btn btn-warning d-block">
            <i class="fas fa-user-plus">Add New Admin</i>
          </a>
      </div>
      <div class="col-lg-3 mb-2">
          <a href="Comments.php" class="btn btn-success d-block">
            <i class="fas fa-check">Approved Comments</i>
          </a>
      </div>
    </div>
  </div>
</header> <!--ending header-->

<!-- Main Area -->
<section class="container py-2 mb-4">
  <div class="row">
      <div class="col-lg-12">
      <?php 
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <table class="table table-striped table-hover">
        <thead class="table-dark">
           <tr>
              <th>#</th>
              <th>Title</th>
              <th>Category</th>
              <th>Date&Time</th>
              <th>Author</th>
              <th>Banner</th>
              <th>Comments</th>
              <th>Action</th>
              <th>Live Preview</th>
            </tr>
        </thead>
         
            <?php 
              $ConnectingDB;
              $sql = "SELECT * FROM posts";
              $stmt = $ConnectingDB->query($sql);
              $Sr = 0;
              while($DataRows = $stmt->fetch()){
                $Id = $DataRows["id"];
                $DateTime = $DataRows["datetime"];
                $PostTitle = $DataRows["title"];
                $Category = $DataRows["category"];
                $Admin = $DataRows["author"];
                $Image = $DataRows["image"];
                $Post =$DataRows["post"];
                $Sr++;
              ?>
              <tbody>
              <tr>
                <td><?php echo $Sr; ?></td>
                <td>
                <?php 
                if(strlen($PostTitle) > 20) {
                  $PostTitle= substr($PostTitle,0,18)."..";
                } echo $PostTitle; 
                ?>
                </td>
                <td><?php if(strlen($Category) > 8) {
                  $Category= substr($Category,0,8)."..";
                } echo $Category; 
                ?></td>
                <td><?php if(strlen($DateTime) > 11) {
                  $DateTime= substr($DateTime,0,11)."..";
                } echo $DateTime; 
                ?></td>
                <td><?php if(strlen($Admin) > 6) {
                  $Admin= substr($Admin,0,6)."..";
                } echo $Admin; 
                ?></td>
                <td><img src="Upload/<?php echo $Image; ?>" width="170px;" height="50px"></td>
                <td>Comments</td>
                <td>
                <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
                <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
                </td>
                <td>
                <a href="FullPost.php?id=<?php echo $Id;  ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>
                </td>
              </tr>
              </tbody>
            <?php 
             }
            ?>
        
        </table>
      </div>
  </div>


</section>

<!-- end mai Area -->
<footer class="bg-dark text-white">
  <div class="container">
    <div class="row">
      <div class="col">
        <p class="lead text-center">Theme By | <a href="https://ericnaiman.com" style="color: white;  cursor: pointer;">Eric Naiman </a>| <span id="year"></span> &copy; "All rights Reserved"
        </p>
      </div> 
    </div>
  </div>
</footer> 
<div style="height:10px; background: #27aee1"></div> <!--ending footer-->


    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
      crossorigin="anonymous"
    ></script>
  <script>
    document.querySelector('#year').innerHTML= new Date().getFullYear();  
  </script>
  </body>
</html>

<?php 
 require_once( './Includes/DB.php' );
 require_once( './Includes/Functions.php' );
 require_once( './Includes/Sessions.php' ); 
 
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
    <title>Blog Page</title>

    <style>
    .heading {
    font-family: Bitter,Georgia,"Times New Roman", Times, serif;
    font-weight: bold;
    color: #005e90;
}

.heading:hover {
    color: #0090db;
}
    </style>
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
                <a href="Blog.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">About</a>
            </li>
            <li class="nav-item">
                <a href="Blog.php" class="nav-link">Blog</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Contact Us</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Features</a>
            </li>
        </ul>
        <ul class="navbar-nav mx-auto">
            <form class="form-inline d-none d-sm-block" action="Blog.php">
              <div class="from-group">
                <input class="form-control mr-2" type="text" name="Search" placeholder="Search here">
                <button  class="btn btn-primary" name="Searchbutton">Go</button>
              </div>
            </form>
        </ul>
    </div> <!--ending toggle button-->
    </div>
</nav> 
<div style="height:10px; background: #27aee1"></div> <!--end navbar-->


<!-- Main Area -->
<div class="container">
  <!-- Main Content -->
    <div class="row mt-4">
        <div class="col-sm-8">
            <h1>The Complete Responsive CMS Blog</h1>
            <h1 class="lead">The Complete Blog by using PHP by Eric</h1>
            <?php 
               echo ErrorMessage();
               echo SuccessMessage();
            ?>
            <?php 
               $ConnectingDB;
               if(isset($_GET["Searchbutton"])){
                 $Search = $_GET["Search"];
                 $sql = "SELECT * FROM posts 
                 WHERE datetime LIKE :search OR 
                 title LIKE :search OR 
                 category LIKE :search OR
                 post LIKE :search ";
                 $stmt = $ConnectingDB->prepare($sql);
                 $stmt->bindValue(':search','%'.$Search.'%');
                 $stmt->execute();
              }elseif (isset($_GET['page'])) {
                  $Page = $_GET["page"];
                  if($Page == 0 || $Page < 1){
                    $ShowPostFrom=0;
                  } else {
                    $ShowPostFrom = ($Page * 5) - 5;
                  }
                  $sql = "SELECT * FROM posts ORDER by id desc LIMIT $ShowPostFrom ,5";
                  $stmt= $ConnectingDB->query($sql);
                  
                
              }  // Query When Category is active in URL Tab
              elseif (isset($_GET["category"])) {
                $Category = $_GET["category"];
                $sql = "SELECT * FROM posts WHERE category='$Category' ORDER BY id desc";
                $stmt=$ConnectingDB->query($sql);
              }
              //Default SQL Query
              else {

                $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
                $stmt= $ConnectingDB->query($sql);
              }  
              while ($DataRows = $stmt->fetch()){
                $PostId = $DataRows['id'];
                $DateTime = $DataRows['datetime'];
                $PostTitle = $DataRows['title'];
                $Category = $DataRows['category'];
                $Admin = $DataRows["author"];
                $Image = $DataRows['image'];
                $PostDecription = $DataRows['post'];
             
            ?>
            <div class="card">
              <img src="Upload/<?php echo htmlentities($Image); ?>" style="max-height: 450px;" class="img-fluid card-img-top">
              <div class="card-body">
              
                <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
                <small class="text-muted"> Category: 
                 <span class="text-dark"> <a href="Blog.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?> </a> </span> 
                 & Written by  <a href="Profile.php?username=<?php echo htmlentities($Admin); ?>">
                <?php echo htmlentities($Admin); ?>
                </a> 
                On <?php echo htmlentities($DateTime); ?>
                </small>
                <span style="float:right;" class="badge bg-dark text-light" >
                    Comments <?php echo ApproveCommentsAccordingtoPost($PostId);?>
                </span>
                  <hr>
                <p class="card-text">
                  <?php 
                    if(strlen($PostDecription > 150)){
                      $PostDecription = substr($PostDecription,0,150)."...";
                    }
                    echo htmlentities($PostDecription); 
                  ?>
                </p>
                <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right;">
                  <span class="btn btn-info">Read More >> </span>
                </a>
              </div>
            </div>
            <?php  } ?>
            <!-- Pagination starts -->
            <nav>
                <ul class="pagination pagination-lg">
                 <!-- Creating Backward Button -->
                 <?php 
                      if(isset($Page)) { 
                        if($Page >1){
                        ?>
                         <li class="page-item">
                                <a href="Blog.php?page=<?php echo $Page+1; ?>" class="page-link">&laquo;</a>
                          </li>
                     <?php } } ?>
                    <?php 
                      $ConnectingDB;
                      $sql = "SELECT COUNT(*) FROM posts";
                      $stmt = $ConnectingDB->query($sql);
                      $RowPagination =$stmt->Fetch();
                      $TotalPosts=array_shift($RowPagination);
                      $PostPagination=$TotalPosts/5;
                      $PostPagination=ceil($PostPagination);
                      for ($i=1; $i <= $PostPagination ; $i++) { 
                        if(isset($Page)) {
                            if($i == $Page){ ?>
                            <li class="page-item active">
                              <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                            </li>
                          <?php     
                            } else { ?>
                               <li class="page-item">
                                <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                              </li>
                           <?php }
                        
                    } } ?>
                  <!-- Creating Forward Button -->
                    <?php 
                      if(isset($Page) && !empty($Page)) { 
                        if($Page+1 <= $PostPagination){
                        ?>
                         <li class="page-item">
                                <a href="Blog.php?page=<?php echo $Page+1; ?>" class="page-link">&raquo;</a>
                          </li>
                     <?php }} ?>
                    
                </ul>
            </nav>
            
            <!-- Pagination Ends -->

        </div><!--ending main content-->

  <?php 
  require_once("footer.php");
  
  ?>

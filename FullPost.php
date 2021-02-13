<?php 

require_once( './Includes/DB.php' );
 require_once( './Includes/Functions.php' );
 require_once( './Includes/Sessions.php' );
  
?>

<?php 
$SearchQueryParameter = $_GET['id'];
?>

<?php 
if(isset($_POST["Submit"])){
    $Name    = $_POST["CommenterName"];
    $Email   = $_POST["CommenterEmail"];
    $Comment = $_POST["CommenterThoughts"];

    date_default_timezone_set('America/New_York');
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S" , $CurrentTime);
  
  
    if(empty($Name)||empty($Email)||empty($Comment)){
        $_SESSION["ErrorMessage"]= "All fields must be filled out";
        Redirect_to("FullPost.php?id={$SearchQueryParameter}");
    } elseif(strlen($Comment) > 500){
        $_SESSION["ErrorMessage"]= "Comment length should be less than 500 characters";
        Redirect_to("FullPost.php?id={$SearchQueryParameter}");
    }else {
      //query to insert comment into DB
      $ConnectingDB;
      $sql = "INSERT INTO comments(datetime, name, email, comment, approvedby, status, post_id )";
      $sql .= "VALUES(:dateTime,:name,:email,:comment, 'Pending', 'OFF', :post_idFromUrl)";
      $stmt = $ConnectingDB->prepare($sql);
      $stmt->bindValue(':dateTime',$DateTime);
      $stmt->bindValue(':name',$Name);
      $stmt->bindValue(':email',$Email);
      $stmt->bindValue(':comment',$Comment);
      $stmt->bindValue(':post_idFromUrl',$SearchQueryParameter);
      $Execute=$stmt->execute();
    
      if($Execute){
        $_SESSION["SuccessMessage"]="Comment Submitted Successfully";
        Redirect_to("FullPost.php?id=$SearchQueryParameter");
      }else {
        $_SESSION["ErrorMessage"]="Something went wrong. Try Again !";
        Redirect_to("FullPost.php?id=$SearchQueryParameter");
      }
    }
    } 
  


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
<title>Blog Page</title>
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
<a href = 'Blog.php' class = 'nav-link'>Home</a>
</li>
<li class = 'nav-item'>
<a href = '#' class = 'nav-link'>About</a>
</li>
<li class = 'nav-item'>
<a href = 'Blog.php' class = 'nav-link'>Blog</a>
</li>
<li class = 'nav-item'>
<a href = '#' class = 'nav-link'>Contact Us</a>
</li>
<li class = 'nav-item'>
<a href = '#' class = 'nav-link'>Features</a>
</li>
</ul>
<ul class = 'navbar-nav mx-auto'>
<form class = 'form-inline d-none d-sm-block' action = 'Blog.php'>
<div class = 'from-group'>
<input class = 'form-control mr-2' type = 'text' name = 'Search' placeholder = 'Search here'>
<button  class = 'btn btn-primary' name = 'Searchbutton'>Go</button>
</div>
</form>
</ul>
</div> <!--ending toggle button-->
</div>
</nav>
<div style = 'height:10px; background: #27aee1'></div> <!--end navbar-->

<!-- Main Area -->
<div class = 'container'>
<!-- Main Content -->
<div class = 'row mt-4'>
<div class = 'col-sm-8'>
<h1>The Complete Responsive CMS Blog</h1>
<h1 class = 'lead'>The Complete Blog by using PHP by Eric</h1>
<?php 
        echo ErrorMessage();
        echo SuccessMessage();
        ?>

<?php
$ConnectingDB;
if ( isset( $_GET['Searchbutton'] ) ) {
    $Search = $_GET['Search'];
    $sql = "SELECT * FROM posts 
                 WHERE datetime LIKE :search OR 
                 title LIKE :search OR 
                 category LIKE :search OR
                 post LIKE :search ";
    $stmt = $ConnectingDB->prepare( $sql );
    $stmt->bindValue( ':search', '%'.$Search.'%' );
    $stmt->execute();
} else {
    $PostIdFromUrl = $_GET['id'];

    if(!isset($PostIdFromUrl)){
        $_SESSION["ErrorMessage"]="Bad Request !";
        Redirect_to("Blog.php");
    }

    $sql = "SELECT * FROM posts WHERE id= '$PostIdFromUrl'";
    $stmt = $ConnectingDB->query( $sql );
    $Result = $stmt->rowcount();
    if($Result !=1){
        $_SESSION["ErrorMessage"]="Bad Request !";
        Redirect_to("Blog.php?=1");
    }
}

while ( $DataRows = $stmt->fetch() ) {
    $PostId = $DataRows['id'];
    $DateTime = $DataRows['datetime'];
    $PostTitle = $DataRows['title'];
    $Category = $DataRows['category'];
    $Admin = $DataRows['author'];
    $Image = $DataRows['image'];
    $PostDecription = $DataRows['post'];

    ?>
    <div class = 'card'>
    <img src = "Upload/<?php echo htmlentities($Image); ?>" style = 'max-height: 450px;' class = 'img-fluid card-img-top'>
    <div class = 'card-body'>

    <h4 class = 'card-title'><?php echo htmlentities( $PostTitle );
    ?></h4>
   <small class="text-muted"> Category: 
                 <span class="text-dark"> <a href="Blog.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?> </a> </span> 
                 & Written by  <a href="Profile.php?username=<?php echo htmlentities($Admin); ?>">
                <?php echo htmlentities($Admin); ?>
                </a> 
                On <?php echo htmlentities($DateTime); ?>
                </small>
    
    <hr>
    <p class = 'card-text'>
    <?php
        echo nl2br( $PostDecription );
    ?>
    </p>
    </div>
    </div>
    <?php  } ?>


    <!-- comment section starts-->
    <!-- fetching existing comment Start -->
    <br>
    <span class="FieldInfo">Comments</span>
    <br>
    <br>
    <?php  
    
    $ConnectingDB;
    $sql = "SELECT * FROM comments 
    WHERE post_id='$SearchQueryParameter' AND status='ON'";
    $stmt = $ConnectingDB->query($sql);
    while ($DataRows = $stmt->fetch()){
        $CommentDate = $DataRows['datetime'];
        $CommenterName = $DataRows['name'];
        $CommentContent = $DataRows['comment'];
    
    ?>
    <div>
        
        <div class="media CommentBlock">
            <img class="d-block img-fluid float-start" width="100px" src="./Images/comment.png" alt="">
            <div class="media-body ml-2">
                <h6 class="lead"><?php echo $CommenterName; ?></h6>
                <p class="small"><?php echo $CommentDate; ?></p>
                <p><?php echo $CommentContent; ?></p>
            </div>
        </div>
    </div><!-- fetching existing comment END -->
       <hr> 
<?php } ?>
    
    <div class="">
        <form action="FullPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="FieldInfo">Share your Thoughts about this post</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            <input class="form-control" type="email" name="CommenterEmail" placeholder="Email" value="">
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <textarea  class="form-control" name="CommenterThoughts" id="" cols="80" rows="6"></textarea>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-primary" name="Submit" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div> <!--ending Comment section-->

    </div>  <!--ending main content-->
  

 <?php

require_once("footer.php");
 ?>
<?php 
 require_once( './Includes/DB.php' );
 require_once( './Includes/Functions.php' );
 require_once( './Includes/Sessions.php' ); 
 
 $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
 Confirm_Login();
?>

<?php 
if(isset($_POST["Submit"])){
  $Category = $_POST["CategoryTitle"];
  $Admin = $_SESSION["UserName"];
  
date_default_timezone_set('America/New_York');
$CurrentTime=time();
$DateTime=strftime("%B-%d-%Y %H:%M:%S" , $CurrentTime);


  if(empty($Category)){
    $_SESSION["ErrorMessage"]= "All Fields must be filled out";
    Redirect_to("Categories.php");
  } elseif(strlen($Category) < 3){
    $_SESSION["ErrorMessage"]= "Title must be greater then 2 characters";
    Redirect_to("Categories.php");
  }elseif(strlen($Category) > 49){
    $_SESSION["ErrorMessage"]= "Title must be less then 50 characters";
    Redirect_to("Categories.php");
  } else {
    //query to insert into DB
    $sql = "INSERT INTO category(title, author, datetime)";
    $sql .= "VALUES(:categoryName, :adminName, :dateTime)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':categoryName', $Category);
    $stmt->bindValue(':adminName', $Admin);
    $stmt->bindValue(':dateTime', $DateTime);
    $Execute=$stmt->execute();

    if($Execute){
      $_SESSION["SuccessMessage"] = "Category with id : ". $ConnectingDB->lastInsertId()  ." Added Successfully";
      Redirect_to("Categories.php");
    } else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again!";
    Redirect_to("Categories.php");
    }
  }
  } 


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
    <title>Categories</title>
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
<div style="height:10px; background: #27aee1"></div> <!--end navbar-->

<header class="bg-dark text-white py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
         <h1 class="title"><i class="fas fa-edit"></i>Manage Categories</h1>
      </div>
    </div>
  </div>
</header> <!--ending header-->

<!-- main Area -->
<section class="container py-2 mb-4">

    <div class="row">
        <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
        <?php 
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
            <form action="Categories.php" method="post">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-header">
                        <h1>Add New Category</h1>
                    </div>
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo">Category Title:</span></label>
                            <input class="form-control" type="text" name="CategoryTitle", id="title" placeholder="Title" value="">
                        </div>
                        <div class="row">
                          <div class="col-lg-6 mt-2 mb-2">
                            <a href="Dashboard.php" class="btn btn-warning d-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                          </div>
                          <div class="col-lg-6 mt-2 mb-2">
                          
                            <button type="submit" name="Submit" class="btn btn-success btn-block "><i class="fas fa-check"></i>Publish
                          </button>
                          </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>


<!-- end main Area -->

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

<?php 
 require_once( './Includes/DB.php' );
 require_once( './Includes/Functions.php' );
 require_once( './Includes/Sessions.php' ); 

?>

<!-- fetching existing Data -->
<?php 
    $SearchQueryParameter = $_GET["username"];
    $ConnectingDB;
    $sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName";
    $stmt=$ConnectingDB->prepare($sql);
    $stmt->bindValue(':userName', $SearchQueryParameter);
    $stmt->execute();
    $Result = $stmt->rowcount();
    if($Result==1){
        while($DataRows=$stmt->fetch()){
    $ExistingName     = $DataRows["aname"];
    $ExistingBio      = $DataRows["abio"];
    $ExistingImage    = $DataRows["aimage"];
    $ExistingHeadline = $DataRows["aheadline"];
        }
    } else {
        $_SESSION['ErrorMessage'] = "Bad Request!";
        Redirect_to('Blog.php');
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
    <title>My Profile</title>
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

<header class="bg-dark text-white py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
         <h1 class="title"><i class="fas fa-user text-success mr-2"></i><?php echo $ExistingName; ?></h1>
         <h3><?php echo $ExistingHeadline; ?></h3>
      </div>
    </div>
  </div>
</header> <!--ending header-->

<section class="container py-2 mb-4">
    <div class="row">
        <div class="col-md-3">
            <img src="./Images/<?php echo $ExistingImage;  ?>" alt="" class="d-block img-fluid mb-3 rounded-circle">
        </div>
        <div class="col-md-9" style="min-height:500px;">
            <div class="card">
                <div class="card-body">
                    <p class="lead">
                        <?php echo $ExistingBio;  ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


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

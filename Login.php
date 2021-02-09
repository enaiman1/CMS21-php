<?php 
 require_once( './Includes/DB.php' );
 require_once( './Includes/Functions.php' );
 require_once( './Includes/Sessions.php' ); 
?>
<?php 

if(isset($_SESSION["UserId"])){
  Redirect_to("Dashboard.php");
}

if(isset($_POST['Submit'])){
    $UserName = $_POST["Username"];
    $Password = $_POST["Password"];
    if(empty($UserName) || empty($Password)){
        $_SESSION["ErrorMessage"]= "All fields must be filled out";
        Redirect_to("Login.php");
    }else {
      // code for checking username and password from Database
      $Found_Account=Login_Attempt($UserName,$Password);
      if ($Found_Account) {
        $_SESSION["UserId"]=$Found_Account["id"];
        $_SESSION["UserName"]=$Found_Account["username"];
        $_SESSION["AdminName"]=$Found_Account["aname"];
        $_SESSION["SuccessMessage"]= "Wellcome ".$_SESSION["AdminName"]."!";
        if (isset($_SESSION["TrackingURL"])) {
          Redirect_to($_SESSION["TrackingURL"]);
        }else{
        Redirect_to("Dashboard.php");
      }
      }else {
        $_SESSION["ErrorMessage"]="Incorrect Username/Password";
        Redirect_to("Login.php");
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
    <title>Login</title>
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
        
    </div> <!--ending toggle button-->
    </div>
</nav> 
<div style="height:10px; background: #27aee1"></div> <!--end navbar-->

<header class="bg-dark text-white py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
         <h1></h1>
      </div>
    </div>
  </div>
</header> <!--ending header-->
<br>

<!-- Main Area Start -->
<section class="container py-2 mb-4">
    <div class="row">
        <div class="offset-sm-3 col-sm-6" style="min-height:500px;">
        <br><br>
        <?php 
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
            <div class="card bg-secondary text-light">
                <div class="card-header">
                    <h4>Welcome Back!</h4>
                </div>
                <div class="card-body bg-dark">
                    
                    <form action="Login.php" method="post">
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Username:</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend bg-info">
                                    <span class="input-group-text text-white bg-info"><i class="fas fa-user "></i></span>
                                </div>
                                <input type="text" class="form-control" name="Username" id="username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password"><span class="FieldInfo">Password:</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend bg-info">
                                    <span class="input-group-text text-white bg-info"><i class="fas fa-lock "></i></span>
                                </div>
                                <input type="password" class="form-control" name="Password" id="password">
                            </div>
                        </div>
                        <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Main Area Ends -->

<!-- Footer Starts -->
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

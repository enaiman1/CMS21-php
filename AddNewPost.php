<?php 
require_once("./Includes/DB.php"); 
require_once("./Includes/Functions.php");  
require_once("./Includes/Sessions.php"); 
?>

<?php 
if(isset($_POST["Submit"])){
  print "<pre>";
print_r($_POST);
print_r($_FILES);
print "</pre>";

  $PostTitle = $_POST["PostTitle"];
  $Category = $_POST["Category"];
  $Image = $_FILES["Image"]["name"];
  $Target = "Upload/".basename($_FILES["Image"]["name"]); //puts submitted image into upload folder
  $PostDescription = $_POST["PostDescription"];
  $Admin = "Eric";
  
  date_default_timezone_set('America/New_York');
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S" , $CurrentTime);


  if(empty($PostTitle)){
    $_SESSION["ErrorMessage"]= "Title can't be empty";
    Redirect_to("AddNewPost.php");
  } elseif(strlen($PostTitle) < 5){
    $_SESSION["ErrorMessage"]= "Title must be greater then 5 characters";
    Redirect_to("AddNewPost.php");
  }elseif(strlen($PostDescription) > 9999){
    $_SESSION["ErrorMessage"]= "Post Description should be less then 10000 characters";
    Redirect_to("AddNewPost.php");
  } else {
    //query to insert into DB
    $sql = "INSERT INTO posts(datetime,title, category, author, image, post )";
    $sql .= "VALUES(:dateTime, :postTitle, :categoryName, :adminName, :imageName, :postDescription )";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime', $DateTime);
    $stmt->bindValue(':postTitle', $PostTitle);
    $stmt->bindValue(':categoryName', $Category);
    $stmt->bindValue(':adminName', $Admin);
    $stmt->bindValue(':imageName', $Image);
    $stmt->bindValue(':postDescription', $PostDescription);
    $Execute=$stmt->execute();
    move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);

    if($Execute){
      $_SESSION["SuccessMessage"] = "Post with id : ". $ConnectingDB->lastInsertId()  ." Added Successfully";
      Redirect_to("AddNewPost.php");
    } else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again!";
    Redirect_to("AddNewPost.php");
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
         <h1 class="title"><i class="fas fa-edit"></i>Add New Post</h1>
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
            <form action="AddNewPost.php" method="post" enctype="multipart/form-data">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-body bg-dark">
                        <div class="form-group mb-2">
                            <label for="title"><span class="FieldInfo">Post Title:</span></label>
                            <input class="form-control" type="text" name="PostTitle", id="title" placeholder="Title" value="">
                        </div>
                        <div class="form-group mb-2">
                            <label for="CategoryTitle"><span class="FieldInfo">Chose Category</span></label>
                            <select name="Category" class="form-control" id="CategoryTitle">
                                <?php 
                                  //Fetching all categories from the category table
                                  $ConnectingDB;
                                  $sql = "SELECT id,title FROM category";
                                  $stmt = $ConnectingDB->query($sql);
                                  while($DateRows = $stmt->fetch()){
                                    $Id = $DateRows['id'];
                                    $CategoryName = $DateRows['title'];
                                  
                                ?>
                                <option><?php echo $CategoryName;?></option>
                              
                                <?php 
                                } 
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="imageSelect"><span class="FieldInfo">Select Image</span></label>
                        <div class="input-group">
                            <input type="file" name="Image" class="form-control" id="imageselect" aria-describedby="inputGroupFileAddon04" aria-label="Upload" >
                        </div>
                        </div>
                        <div class="form-group mb-2">
                          <label for="Post"><span class="FieldInfo">Post</span></label>
                          <textarea name="PostDescription" id="Post" class="form-control" cols="80" rows="10"></textarea>
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

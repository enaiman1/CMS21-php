<?php
require_once( './Includes/DB.php' );

require_once( './Includes/Functions.php' );

require_once( './Includes/Sessions.php' );

$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
Confirm_Login();
?>

<?php
// fetching the existing Admin Data Start
$AdminId = $_SESSION["UserId"];
$ConnectingDB;
$sql="SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while($DataRows = $stmt->fetch()){
$ExistingName = $DataRows['aname'];
  $ExistingHeadline = $DataRows['aheadline'];
  $ExistingUsername = $DataRows['username'];
  $ExistingBio      = $DataRows['abio'];
  $ExistingImage    = $DataRows['aimage'];

} //Fetch the existing Admin Data end

if ( isset( $_POST['Submit'] ) ) {
    $AName     = $_POST["Name"];
    $AHeadline = $_POST["Headline"];
    $ABio      = $_POST["Bio"];
    $Image     = $_FILES["Image"]["name"];
    $Target    = "Images/".basename($_FILES["Image"]["name"]);

    if (strlen($AHeadline)>50) {
        $_SESSION["ErrorMessage"] = "Headline Should be less than 50 characters";
        Redirect_to("MyProfile.php");
      }elseif (strlen($ABio)>500) {
        $_SESSION["ErrorMessage"] = "Bio should be less than than 500 characters";
        Redirect_to("MyProfile.php");
    } else {
         //query to Update the Admin data in DB
         $ConnectingDB;
         //if image field is not empty update the post else dont change the image
         if (!empty($_FILES["Image"]["name"])) {
            $sql = "UPDATE admins
                    SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
                    WHERE id='$AdminId'";
          }else {
            $sql = "UPDATE admins
                    SET aname='$AName', aheadline='$AHeadline', abio='$ABio'
                    WHERE id='$AdminId'";
          }
          $Execute= $ConnectingDB->query($sql);
          move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
          if($Execute){
            $_SESSION["SuccessMessage"]="Details Updated Successfully";
            Redirect_to("MyProfile.php");
          }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("MyProfile.php");
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
<title>My Profile</title>
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
<div style = 'height:10px; background: #27aee1'></div> <!--end navbar-->

<header class = 'bg-dark text-white py-3'>
<div class = 'container'>
<div class = 'row'>
<div class = 'col-md-12'>
<h1 class = 'title'><i class = 'fas fa-user mr-2 text-success'></i> @<?php echo $ExistingUsername ?>'s Profile</h1>
<small><?php echo $ExistingHeadline; ?></small>
</div>
</div>
</div>
</header> <!--ending header-->

<!-- main Area -->
<section class = 'container py-2 mb-4'>
<div class = 'row'>

<!-- left area -->
<div class="col-md-3">
    <div class="card">
        <div class="card-header bg-dark text-light">
            <h3><?php echo $ExistingName; ?></h3>
        </div>
        <div class="card-body">
            <img src="./Images/<?php echo $ExistingImage; ?>" alt="" class="block img-fluid mb-3">
            <div>
                <p><?php echo $ExistingBio; ?></p>
            </div>
        </div>
    </div>
</div>

<!-- right area -->
<div class = 'col-md-9' style = 'min-height:400px;'>
<?php
echo ErrorMessage();
echo SuccessMessage();
?>
<form action = 'MyProfile.php' method = 'post' enctype = 'multipart/form-data'>
<div class = 'card bg-dark text-light mb-3'>
    <div class="card-header bg-secondary text-light">
        <h4>Edit Profile</h4>
    </div>
<div class = 'card-body'>
<div class = 'form-group mb-2'>
<input class = 'form-control' type = 'text' name = 'Name', id = 'title' placeholder ='Your Name' value = ''>
    
</div>

<div class = 'form-group mb-2'>
<input class = 'form-control' type = 'text' name = 'Headline', id = 'title' placeholder ='Headline' value = ''>
<small class="text-muted">Add a professional headline like, 'Engineer' at XYZ or 'Architect' </small>
    <span class="text-danger">Not more than 50 characters</span>
</div>
<div class = 'form-group mb-2'>
<textarea placeholder="Bio" name = 'Bio' id = 'Post' class = 'form-control' cols = '80' rows = '10'></textarea>
</div>

<div class = 'form-group mb-2'>
    <label for = 'imageSelect'><span class = 'FieldInfo'>Select Image</span></label>
<div class = 'input-group'>
    <input type = 'file' name = 'Image' class = 'form-control' id = 'imageselect' aria-describedby = 'inputGroupFileAddon04' aria-label = 'Upload' >
</div>
</div>

<div class = 'row'>
<div class = 'col-lg-6 mt-2 mb-2'>
<a href = 'Dashboard.php' class = 'btn btn-warning d-block'><i class = 'fas fa-arrow-left'></i> Back to Dashboard</a>
</div>
<div class = 'col-lg-6 mt-2 mb-2'>

<button type = 'submit' name = 'Submit' class = 'btn btn-success btn-block '><i class = 'fas fa-check'></i>Publish
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

<?php require_once( './Includes/DB.php' );
?>
<?php require_once( './Includes/Functions.php' );
?>
<?php require_once( './Includes/Sessions.php' );
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

}

while ( $DataRows = $stmt->fetch() ) {
    $PostId = $DataRows['id'];
    $DateTime = $DataRows['datetime'];
    $PostTitle = $DataRows['title'];
    $Category = $DataRows['category'];
    $admin = $DataRows['author'];
    $Image = $DataRows['image'];
    $PostDecription = $DataRows['post'];

    ?>
    <div class = 'card'>
    <img src = "Upload/<?php echo htmlentities($Image); ?>" style = 'max-height: 450px;' class = 'img-fluid card-img-top'>
    <div class = 'card-body'>

    <h4 class = 'card-title'><?php echo htmlentities( $PostTitle );
    ?></h4>
    <small class = 'text-muted'>Written by <?php echo $Admin ?> On <?php echo htmlentities( $DateTime );
    ?></small>
    <span style = 'float:right;' class = 'badge bg-dark text-light' >Comments 20</span>
    <hr>
    <p class = 'card-text'>
    <?php
        echo htmlentities( $PostDecription );
    ?>
    </p>
    </div>
    </div>
    <?php  }
    ?>

    </div>
    <!--ending main content-->

    <!--ending side area-->
    <div class = 'col-sm-4' style = 'min-height:40px; background:green;'>

    </div>
    <!--ending side area-->
    </div>
    </div>

    <br>

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

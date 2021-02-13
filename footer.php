<!--side area start-->
<div class="col-sm-4">
            <div class="card mt-4">
                <div class="card-body">
                  <img src="./Images/startblog.PNG" class="d-block img-fluid mb-3" alt="">
                  <div class="text-center">
                       Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, numquam quae? Aut consequatur asperiores molestias! Numquam cumque esse vel animi, eos optio ea iste facere! At laboriosam voluptas a beatae? 
                  </div>
                </div>
            </div>
            <br>
            <div class="card">
            <div class="card">
                    <div class="card-header bg-dark text-light">
                          <h2 class="lead text-center">Sign Up!</h2>
                    </div>
                </div>
                <div class="card-body d-grid">
                     <button class="btn btn-success text-center text-white mb-4" name="button">
                      Join the Forum
                     </button>
                     <button class="btn btn-danger text-center text-white mb-4" name="button">
                      Login
                     </button>
                     <div class="input-group">
                        <div class="input-group-text bg-info" id="btnGroupAddon2">Subscribe now</div>
                        <input type="text" class="form-control" placeholder="Enter your emai" aria-label="Input group example" aria-describedby="btnGroupAddon2">
                    </div>
                </div>
            </div>
            <br> 
            <div class="card mt-4">
                <div class="card-header bg-primary text-light">
                  <h2 class="lead">Categories</h2>
                </div>
                <div class="card-body">
                        <?php 
                        
                        $sql = "SELECT * FROM category ORDER BY id desc";
                        $stmt = $ConnectingDB->query($sql);
                        while($DataRows = $stmt->fetch()){
                          $CategoryId= $DataRows['id'];
                          $CategoryName= $DataRows['title'];
                        ?>
                          <a href="Blog.php?category=<?php echo $Category; ?>">
                            <span class="heading"><?php echo $CategoryName; ?></span><br>
                          </a>

                        <?php } ?>
                </div>
            </div>

            <br>

             <div class="card">
                <div class="card-header bg-info text-white">
                      <h2 class="lead text-center">Recent Posts</h2>    
                </div>
                <div class="card-body">
                    <?php 
                      $ConnectingDB;
                      $sql= "SELECT * FROM posts ORDER BY id desc Limit 0,5";
                      $stmt = $ConnectingDB->query($sql);
                      while($DataRows=$stmt->fetch()){
                        $Id = $DataRows['id'];
                        $Title = $DataRows['title'];
                        $DateTime = $DataRows['datetime'];
                        $Image = $DataRows['image'];
                    ?>

                   <div class="media">
                        <img src="./Upload/<?php echo htmlentities($Image); ?>" width="90px" height="94px" alt="" class="d-block image-fluid align-self-start">
                        <div class="media-body ml-2">
                            <a href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank">
                              <h6 class="lead"><?php echo htmlentities($Title); ?></h6>
                            </a>
                              <p class="small"><?php echo htmlentities($DateTime); ?></p>
                        </div>
                   </div>
                   <hr>
                   
                   <?php } ?>
                </div>
             </div>

        </div>
        
        <br>
        
      
    </div><!--side area ends-->
</div>

<br>


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

// check if user is logged in
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
  header("location: login system/login_form/login_form.php");
  exit;
}

echo '<p>You are logged in as '.$_SESSION['user_name'].'.</p>';

$like_count = "SELECT COUNT(*) as total_likes FROM tbllike WHERE postId = {$row['pid']} AND `like` = 1";
                    $dislike_count = "SELECT COUNT(*) as total_likes FROM tbllike WHERE postId = {$row['pid']} AND `dislike` = 1";




<body>
 
    <!-- Navigation -->
      <?php include('includes/header.php');?>

              <!-- Page Content -->
        <div class="container">
          <div class="row" style="margin-top: 4%">

                  <!-- Blog Entries Column -->
            <div class="col-md-8">

                    <!-- Blog Post -->
              <?php 
                if (isset($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                    } else {
                        $pageno = 1;
                    }
                    
                    $no_of_records_per_page = 8;
                    $offset = ($pageno-1) * $no_of_records_per_page;


                    $total_pages_sql = "SELECT COUNT(*) FROM tblposts";
                    $result = mysqli_query($con,$total_pages_sql);
                    $total_rows = mysqli_fetch_array($result)[0];
                    $total_pages = ceil($total_rows / $no_of_records_per_page);
                 

                $query=mysqli_query($con,"select tblposts.id as pid,tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId LEFT JOIN tbllike ON tbllike.postId = tblposts.id 
                where tblposts.Is_Active=1 order by tblposts.id desc  LIMIT $offset, $no_of_records_per_page");
                $liked = false;
                while ($row=mysqli_fetch_array($query)) {
                
              ?>

              <div class="card mb-4">
                <img class="card-img-top" src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>" width="300" height="400" alt="<?php echo htmlentities($row['posttitle']);?>">
                <div class="card-body">
                  <h2 class="card-title"><?php echo htmlentities($row['posttitle']);?></h2>
                  <p><!--category-->
                  <a class="badge bg-secondary text-decoration-none link-light" href="category.php?catid=<?php echo htmlentities($row['cid'])?>" style="color:#fff"><?php echo htmlentities($row['category']);?></a>
                  <!--Subcategory--->
                  <a class="badge bg-secondary text-decoration-none link-light"  style="color:#fff"><?php echo htmlentities($row['subcategory']);?></a></p>
                  
                  <a href="news-details.php?nid=<?php echo htmlentities($row['pid'])?>" class="btn btn-primary">Read More &rarr;</a>
                </div>
  <!-- In the while loop that displays the blog posts -->
  <div class="card-footer text-muted">
    <!-- Posted on <?php echo htmlentities($row['postingdate']);?> -->
    <button class="btn btn-primary like-btn" data-postid="<?php echo htmlentities($row['pid']); ?>">Like</button>
    <button class="btn btn-danger dislike-btn" data-postid="<?php echo htmlentities($row['pid']); ?>">Dislike</button>
  </div>
              </div> 
              <?php } ?>
                    <!-- Pagination -->
              <ul class="pagination justify-content-center mb-4">
                  <li class="page-item"><a href="?pageno=1"  class="page-link">First</a></li>
                  <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?> page-item">
                      <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>" class="page-link">Prev</a>
                  </li>
                  <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> page-item">
                      <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?> " class="page-link">Next</a>
                  </li>
                  <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
              </ul>

            </div>

Felix, [3/23/2023 9:49 PM]
<!-- Sidebar Widgets Column -->
                <?php include('includes/sidebar.php');?>
          </div>
                <!-- /.row -->

        </div>
<!-- Footer -->
        <?php include('includes/footer.php');?>


              <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

<!-- At the end of the PHP code -->
<script>
  $(document).ready(function() {
    $(".like-btn, .dislike-btn").click(function(e) {
      e.preventDefault();
      var postId = $(this).data('postid');
      var type = $(this).hasClass('like-btn') ? 'like' : 'dislike';
      $.ajax({
        type: 'POST',
        url: 'like-dislike.php',
        data: { postId: postId, type: type },
        success: function(data) {
          // Update the UI to show the updated like and dislike counts
          var counts = JSON.parse(data);
          $(".like-btn[data-postid='" + postId + "']").text("Like (" + counts.likes + ")");
          $(".dislike-btn[data-postid='" + postId + "']").text("Dislike (" + counts.dislikes + ")");
        }
      });
    });
  });
</script>









<!-- <div class="post">
               
                 <div class="btn-group">
                    <form action="like.php" method="POST">
                        <input type="hidden" name="postId" value="<?php echo $row['pid']; ?>">
                        <button type="submit" width="300" height="400" name="like" class="btn btn-outline-secondary">
                            <i class="fa fa-thumbs-up"></i> 
                            <?php
                              // $postid = ($row['pid']);
                              // $result1 = mysqli_query($con,"SELECT * FROM tbllike WHERE postId = $postid");
                              // while ($row=mysqli_fetch_array($result1)) {
                              //   echo $row['like_count'];
                              // }?>Likes
                             
                        </button>
                    </form><br/>
                    <form action="like.php" method="POST">
                        <input type="hidden" name="postId" value="<?php echo $row['pid']; ?>">
                        <button type="submit" name="dislike" class="btn btn-outline-secondary">
                            <i class="fa fa-thumbs-down"></i> 
                            <?php echo $row['dislike_count']; ?> Dislikes
                        </button>
                    </form>
                 </div>

                 
                 <input type= "hidden" name='hidden' value=".$row['id'].">
                <input type="hidden" name='hidden' value=".$row['id'].">-->
                <!--<i class="fa-solid fa-thumbs-up"></i><span></span> <i class="fa-solid fa-thumbs-down"></i>-->

                <!-- <div >
                  <p>This is a post</p>
                  <button class="like-button" data-post-id="1">Like</button>
                  <span class="like-count">0 likes</span>
                </div> -->
                <!-- <div>
                    <button class="like-button" data-post-id="echo htmlentities($row['pid']); ">Like</button>
                </div> -->
                

<?php include('includes/server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <div class="posts-wrapper">
   <?php foreach ($posts as $post): ?>
   	<div class="post">
      <?php echo $post['text']; ?>
      <div class="post-info">
	    <!-- if user likes post, style button differently -->
      	<i <?php if (userLiked($post['id'])): ?>
      		  class="fa fa-thumbs-up like-btn"
      	  <?php else: ?>
      		  class="fa fa-thumbs-o-up like-btn"
      	  <?php endif ?>
      	  data-id="<?php echo $post['id'] ?>"></i>
      	<span class="likes"><?php echo getLikes($post['id']); ?></span>
      	
      	&nbsp;&nbsp;&nbsp;&nbsp;

	    <!-- if user dislikes post, style button differently -->
      	<i 
      	  <?php if (userDisliked($post['id'])): ?>
      		  class="fa fa-thumbs-down dislike-btn"
      	  <?php else: ?>
      		  class="fa fa-thumbs-o-down dislike-btn"
      	  <?php endif ?>
      	  data-id="<?php echo $post['id'] ?>"></i>
      	<span class="dislikes"><?php echo getDislikes($post['id']); ?></span>
      </div>
   	</div>
   <?php endforeach ?>
  </div>
  <script src="js/scripts.js"></script>
</body>
</html>





<?php $sql2 = "SELECT * from tblike WHERE postId = '$id' and username = '$username'";
                      $data= mysqli_query ($con,$sql2);
                       $numrows2 = mysqli_num_rows($data);                 

                  
                  if ($numrows2){
                      echo"
                        <div>
                        <form action='index.php method='POST'>
                        
                
                        <button name='Dislike'>Dislike</button>
                    </form></div>";
                    echo"
                    <p>$numrows2 likes</p>";
                    
                      }else
                      echo"
                    
                      <div><form action='index.php method='POST'>
                      
                      <button name='like'>like</button>
                    </form></div> ";
                    echo"
                    <p>$numrows2 likes</p>"; ?>
                    
<?php
if(isset($_POST['like'])){
  $postId = $_POST['hidden'];
  $name = $_SESSION['name'];//getting from session

  $sql="INSERT INTO tbllike (name,postid) VALUES ('$postId','$name')";
  $query = mysqli_query($con,$sql);
   if ($query ==1){

     echo"<script>location.replace('index.php');</script>";
   }
}
if(isset($_POST['Dislike'])){
  $postId = $_POST['hidden'];
  $username = $_SESSION['name'];

  $sql= "DELETE FROM tbllike WHERE username='$name' AND postId='$postId'";
  $query = mysqli_query($con,$sql);
  if ($query ==1){

    echo"<script>location.replace('index.php');</script>";
 }
}
?>
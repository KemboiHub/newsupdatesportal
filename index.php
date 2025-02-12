<?php 
session_start();
include('includes/config.php');
// check if user is logged in
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
  header("location: login system/login_form/login_form.php");
  exit;
}

echo '<p>You are logged in as '.$_SESSION['user_name'].'.</p>';
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>NewsUpdatesPortal | Home Page</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link rel = "stylesheet" href = "js\fontawesome-free-6.3.0-web\css\solid.min.css" >
    <link rel = "stylesheet" href = "js\fontawesome-free-6.3.0-web\css\fontawesome.min.css" >
  </head>

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
                    $like_count = "SELECT COUNT(*) as total_likes FROM tbllike WHERE postId =  AND `like` = 1";
                    $dislike_count = "SELECT COUNT(*) as total_likes FROM tbllike WHERE postId = AND `dislike` = 1";


                    $query=mysqli_query($con,"select tblposts.id as pid,tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.Is_Active=1 order by tblposts.id desc  LIMIT $offset, $no_of_records_per_page");
                    $liked = false;
                    while ($row=mysqli_fetch_array($query)) {
                // $id = $row['id'];
                // $email= $_SESSION['email'];
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

      
                
                <div>
                  <button class="btn btn-primary like-btn" data-postid="<?php echo htmlentities($row['pid']); ?>">Like</button>
                  <button class="btn btn-danger dislike-btn" data-postid="<?php echo htmlentities($row['pid']); ?>">Dislike</button>

                </div>

                   

                <div class="card-footer text-muted">
                  <!-- Posted on <?php echo htmlentities($row['postingdate']);?> -->
                      
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

                  <!-- Sidebar Widgets Column -->
                <?php include('includes/sidebar.php');?>
          </div>
                <!-- /.row -->

        </div>
              <!-- /.container -->

              <!-- Footer -->
        <?php include('includes/footer.php');?>


              <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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
  

</body>
</html>

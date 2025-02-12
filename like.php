 <?php// Establish MySQL connection
 session_start();
 include('includes/config.php');
 
 $postId = $_POST['postId'];
 $email = $_SESSION['email'];
 
 if (isset($_POST['like'])) {
     // increment the likes count for this post in the database
     mysqli_query($con, "UPDATE tbllike SET like_count = like_count + 1 WHERE postId = $postId");
     
     // record the user's action in the database
     mysqli_query($con, "INSERT INTO tbllike (email, postId, action) VALUES ('$email', $postId, 'like')");
 } elseif (isset($_POST['dislike'])) {
     // increment the dislikes count for this post in the database
     mysqli_query($con, "UPDATE tbllike SET dislike_count = dislike_count + 1 WHERE postId = $postId");
     
     // record the user's action in the database
     mysqli_query($con, "INSERT INTO tbllike (email, postId, action) VALUES ('$email', $postId, 'dislike')");
 }
 
 // redirect back to the previous page
 header("location:../index.php");
 exit();
 ?>
<!-- // define('DB_SERVER','localhost');
// define('DB_USER','root');
// define('DB_PASS' ,'');
// define('DB_NAME','newsportal');
// $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }

// // Handle Ajax request
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $postId = $_POST['postId'];

//   // Update count in database
//   $sql = "UPDATE tbllike SET like_count = like_count + 1 WHERE id = $postId";

//   if ($conn->query($sql) === TRUE) {
//     echo "success";
//   } else {
//     echo "error";
//   }
// }

// $conn->close();

?> 


// // Handle Ajax request
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $postId = $_POST['postId'];
//   $action = $_POST['action'];

//   // Update count in database
//   if ($action === 'like') {
//     $sql = "UPDATE tbllike SET like_count = like_count + 1 WHERE id = $postId";
//   } else if ($action === 'dislike') {
//     $sql = "UPDATE tbllike SET dislike_count = dislike_count + 1 WHERE id = $postId";
//   }

//   if ($conn->query($sql) === TRUE) {
//     $likeCount = getLikeCount($postId);
//     $dislikeCount = getDislikeCount($postId);
//     $result = array('success' => true, 'likeCount' => $likeCount, 'dislikeCount' => $dislikeCount);
//     echo json_encode($result);
//   } else {
//     $result = array('success' => false, 'message' => 'Error updating database');
//     echo json_encode($result);
//   }
// }

// // Function to get the current like count for a post
// function getLikeCount($postId) {
//   global $conn;
//   $sql = "SELECT like_count FROM tbllike WHERE id = $postId";
//   $result = $conn->query($sql);
//   if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();
//     return $row['like_count'];
//   } else {
//     return 0;
//   }
// }

// // Function to get the current dislike count for a post
// function getDislikeCount($postId) {
//   global $conn;
//   $sql = "SELECT dislike_count FROM tbllike WHERE id = $postId";
//   $result = $conn->query($sql);
//   if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();
//     return $row['dislike_count'];
//   } else {
//     return 0;
//   }
// }

//  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//      $postId = $_POST['postId'];
//      $email = $_SESSION['email'];
 
//      // Check if user has already liked the post
//      $query = "SELECT * FROM tbllike WHERE postId = $postId AND email = $email";
//      $result = mysqli_query($con, $query);
 
//      if (mysqli_num_rows($result) > 0) {
//          // User has already liked the post, so unlike the post
//          $query = "DELETE FROM tbllike WHERE postId = $postId AND email = $email";
//          mysqli_query($con, $query);
//      } else {
//          // User has not liked the post, so like the post
//          $query = "INSERT INTO tbllike (postId, email) VALUES ($postId, $email)";
//          mysqli_query($con, $query);
//      }
 
//      // Get new like count for the post
//      $query = "SELECT COUNT(*) FROM tbllike WHERE postId = $postId";
//      $result = mysqli_query($con, $query);
//      $like_count = mysqli_fetch_array($result)[0];
 
//      // Update like count for the post in 'tbllike' table
//     //  $query = "UPDATE tblposts SET Likes = $like_count WHERE id = $postId";
//     //  mysqli_query($con, $query);
 
//      // Return new like count to client-side
//      echo json_encode(array('status' => 'success', 'like_count' => $like_count));
//  } else {
//      // Invalid request method
//      echo json_encode(array('status' => 'error', 'message' => 'Invalid request method.'));
//      exit;
//  } 

// function handle_like_button_click($postId, $email) {
//     $db = new PDO('mysql:host=localhost;dbname=newsportal', 'root', '');
//     $stmt = $db->prepare('SELECT COUNT(*) FROM tbllike WHERE postId = ? AND email = ?');
//     $stmt->execute([$postId, $email]);
//     $count = $stmt->fetchColumn();

//     if ($count == 0) {
//         // User hasn't liked the post yet, insert a new record
//         $stmt = $db->prepare('INSERT INTO tbllike (postId, email) VALUES (?, ?)');
//         $stmt->execute([$postId, $email]);
//     } else {
//         // User has already liked the post, delete the existing record
//         $stmt = $db->prepare('DELETE FROM tbllike WHERE postId = ? AND email = ?');
//         $stmt->execute([$postId, $email]);
//     }

//     // Get the updated like count for the post
//     $stmt = $db->prepare('SELECT COUNT(*) FROM tbllike WHERE postId = ?');
//     $stmt->execute([$postId]);
//     $like_count = $stmt->fetchColumn();

//     return $like_count;
// }
// function handle_like_click() {
//     // Check if the user is logged in
//     // if (!isset($_SESSION['email'])) {
//     //     header('Location: login.php');
//     //     exit;
//     // }
    
//     // Get the postId and email from the session or from the input parameters
//     $postId = $_POST['postId'];
//     $email = $_SESSION['email'];
    
//     // Check if the user has already liked the post
//     $result = mysqli_query($con, "SELECT * FROM likes WHERE postId = $postId AND email = $email");
//     if (mysqli_num_rows($result) > 0) {
//         // User has already liked the post, so remove the like
//         mysqli_query($con, "DELETE FROM likes WHERE postId = $postId AND email = $email");
//         mysqli_query($con, "UPDATE tblposts SET likes = likes - 1 WHERE id = $postId");
//         $liked = false;
//     } else {
//         // User has not liked the post, so add the like
//         mysqli_query($con, "INSERT INTO likes (postId, email) VALUES ($postId, $email)");
//         mysqli_query($con, "UPDATE tblposts SET likes = likes + 1 WHERE id = $postId");
//         $liked = true;
//     }
    
//     // Get the updated likes count
//     $result = mysqli_query($con, "SELECT likes FROM tblposts WHERE id = $postId");
//     $likes_count = mysqli_fetch_array($result)[0];
    
//     // Return the updated likes count and whether the user has liked the post
//     echo json_encode(array('likes_count' => $likes_count, 'liked' => $liked));
//}

// function render_like_button($postId, $con) {
//     // Get the current user ID, assuming it's stored in a session variable
//     $email = $_SESSION['email'];

//     // Check if the current user has liked this post
//     $likedSql = "SELECT COUNT(*) FROM tbllike WHERE postId = $postId AND user_id = $userId";
//     $likedResult = mysqli_query($con, $likedSql);
//     $liked = mysqli_fetch_array($likedResult)[0] > 0;

//     // Get the total number of likes for this post
//     $likesSql = "SELECT COUNT(*) FROM tllike WHERE post_id = $postId";
//     $likesResult = mysqli_query($con, $likesSql);
//     $likes = mysqli_fetch_array($likesResult)[0];

//     // Render the like button with appropriate classes and data attributes
//     $likeButtonClasses = 'like-button btn btn-primary' . ($liked ? ' liked' : '');
//     $likeButtonData = $liked ? 'unlike' : 'like';
//     $likeButtonText = $liked ? 'Liked' : 'Like';
//     echo "<button class=\"$likeButtonClasses\" data-post-id=\"$postId\" data-action=\"$likeButtonData\">$likeButtonText</button>";

//     // Render the total number of likes for this post
//     echo "<span class=\"like-count\">$likes likes</span>";
// }  -->
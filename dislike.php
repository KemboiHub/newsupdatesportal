<?php

<?php// Establish MySQL connection
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME','newsportal');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle Ajax request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $postId = $_POST['postId'];

  // Update count in database
  $sql = "UPDATE tbllike SET dislike_count = dislike_count + 1 WHERE id = $postId";

  if ($conn->query($sql) === TRUE) {
    echo "success";
  } else {
    echo "error";
  }
}

$conn->close();

?>

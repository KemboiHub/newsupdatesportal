<?php
// Start the session and connect to the database
session_start();
include('includes/config.php');

if (isset($_POST['postId']) && isset($_POST['type'])) {
  $postId = $_POST['postId'];
  $type = $_POST['type'];

  // Check if the user is logged in
  // if (!isset($_SESSION['id'])) {
  //   die("You must be logged in to like or dislike a post.");
  // }

  // Check if the user has already liked or disliked the post
  $userId = $_SESSION['id'];
  $checkSql = "SELECT * FROM tbllike WHERE userId = ? AND postId = ?";
  $checkStmt = $mysqli->prepare($checkSql);
  $checkStmt->bind_param("ii", $userId, $postId);
  $checkStmt->execute();
  $result = $checkStmt->get_result();

  // If the user has already liked or disliked the post, update the existing record
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['type'] == $type) {
      die("You have already " . ($type == 1 ? "liked" : "disliked") . " this post.");
    }
    $updateSql = "UPDATE tbllike SET type = ? WHERE id = ?";
    $updateStmt = $mysqli->prepare($updateSql);
    $updateStmt->bind_param("ii", $type, $row['id']);
    $updateStmt->execute();
  } else {
    // If the user has not yet liked or disliked the post, insert a new record
    $insertSql = "INSERT INTO tbllike (userId, postId, type) VALUES (?, ?, ?)";
    $insertStmt = $mysqli->prepare($insertSql);
    $insertStmt->bind_param("iii", $userId, $postId, $type);
    $insertStmt->execute();
  }

  // Update the like and dislike counts for the post
  $likeSql = "SELECT COUNT(*) as likes FROM tbllike WHERE postId = ? AND type = 1";
  $likeStmt = $mysqli->prepare($likeSql);
  $likeStmt->bind_param("i", $postId);
  $likeStmt->execute();
  $likeResult = $likeStmt->get_result();
  $likeCount = $likeResult->fetch_assoc()['likes'];

  $dislikeSql = "SELECT COUNT(*) as dislikes FROM tbllike WHERE postId = ? AND type = -1";
  $dislikeStmt = $mysqli->prepare($dislikeSql);
  $dislikeStmt->bind_param("i", $postId);
  $dislikeStmt->execute();
  $dislikeResult = $dislikeStmt->get_result();
  $dislikeCount = $dislikeResult->fetch_assoc()['dislikes'];

  // Update the post record with the new like and dislike counts
  $updatePostSql = "UPDATE tblpost SET likes = ?, dislikes = ? WHERE id = ?";
  $updatePostStmt = $mysqli->prepare($updatePostSql);
  $updatePostStmt->bind_param("iii", $likeCount, $dislikeCount, $postId);
  $updatePostStmt->execute();

  // Return the updated like and dislike counts as a JSON response
  $response = array('likes' => $likeCount, 'dislikes' => $dislikeCount);
  echo json_encode($response);
}
?>
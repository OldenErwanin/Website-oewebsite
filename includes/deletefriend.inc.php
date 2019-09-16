<?php
session_start();
if(!empty($_POST["submit-DeleteFriend"])){
	require 'database.inc.php';

  $sql = ' DELETE FROM friends WHERE fID = '.$_POST["submit-DeleteFriend"];

  if (mysqli_query($conn, $sql)) {
    header("Location: ../subpages/friends.php?page=list");
    exit();
   } else {
      echo "Error deleting record: " . mysqli_error($conn);
   }
   mysqli_close($conn);
}
else {
  header("Location: ../news.php");
  exit();
}

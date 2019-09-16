<?php
session_start();
if(!empty($_POST["submit-ReadMessage"])){
	require 'database.inc.php';

  $sql = 'UPDATE messages SET mRead = 1 WHERE mID = '.$_POST["submit-ReadMessage"];

  if (mysqli_query($conn, $sql)) {
    header("Location: ../subpages/messages.php?page=recieved");
    exit();
   } else {
      echo "Error update record: " . mysqli_error($conn);
   }
   mysqli_close($conn);
}
else {
  header("Location: ../news.php");
  exit();
}

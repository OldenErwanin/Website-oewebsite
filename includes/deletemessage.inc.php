<?php
session_start();
if(!empty($_POST["submit-DeleteMessage"])){
	require 'database.inc.php';
  $sqlGet = "SELECT * FROM messages WHERE mID = ".$_POST["submit-DeleteMessage"];
  $resultGet = mysqli_query($conn, $sqlGet);
  while ($rowGet = mysqli_fetch_assoc($resultGet)) {
    $authorID = $rowGet["authorID"];
    $toID = $rowGet["toID"];
  }
  if ($authorID == $_SESSION["uID"]) {
    $sql = 'UPDATE messages SET authorDelete = 1 WHERE mID = '.$_POST["submit-DeleteMessage"];
  } else if ($toID == $_SESSION["uID"]) {
    $sql = 'UPDATE messages SET toDelete = 1 WHERE mID = '.$_POST["submit-DeleteMessage"];
  }

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

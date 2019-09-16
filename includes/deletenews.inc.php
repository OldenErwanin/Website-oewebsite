<?php
session_start();
if(!empty($_POST["submit-DeleteNews"]) && $_SESSION["uAdmin"] > 0){
	require 'database.inc.php';

  $sql = ' DELETE FROM news WHERE nID = '.$_POST["submit-DeleteNews"];

  if (mysqli_query($conn, $sql)) {
    header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=news");
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

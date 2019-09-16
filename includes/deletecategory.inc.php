<?php
session_start();
if(!empty($_POST["submit-DeleteCategory"]) && $_SESSION["uAdmin"] > 0){
	require 'database.inc.php';
	$sqlCurr = 'SELECT * FROM categories WHERE cID='.$_POST["submit-DeleteCategory"];
	$resultCurr = mysqli_query($conn, $sqlCurr);
	while ($rowCurr = mysqli_fetch_assoc($resultCurr)) {
		$fileName = $rowCurr["cPicName"];
		$fileType = $rowCurr["cPicType"];
	}
	$path = "../img/categories/".$fileName.".".$fileType;
	unlink($path);

  $sql = ' DELETE FROM categories WHERE cID = '.$_POST["submit-EditCategory"];

  if (mysqli_query($conn, $sql)) {
    header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=categories");
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

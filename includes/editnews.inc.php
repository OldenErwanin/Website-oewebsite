<?php
session_start();
if (isset($_POST["submit-Editnews"]) && $_SESSION["uAdmin"] > 0) {
  require 'database.inc.php';

  $nID = $_POST["submit-Editnews"];
  $nTitle = $_POST["editnews-Title"];
  $nCategory = $_POST["editnews-Category"];
  $nText = $_POST["editnews-Text"];
  $nFeatured = $_POST["editnews-Featured"];
  $nFDate = "0000-00-00";
  $nHide = $_POST["editnews-Hide"];
  if ($nFeatured == "1") {
    $nFDate = $_POST["editnews-FeaturedDate"];
  }
  $nFeaturedDate = date('Y-m-d', strtotime($nFDate));
  $nComments = $_POST["editnews-Comments"];
  if (empty($nTitle) || empty($nText)) {
    header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=news&error=emptyfields");
    exit();
  } else {
    $sql = "UPDATE news SET nTitle=?, nText=?, cID=?, nFeatured=?, nFeaturedDate=?, nEnableComm=?, nHide=? WHERE nID=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=news&error=".$stmt->error);
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ssiisiii", $nTitle, $nText, $nCategory, $nFeatured, $nFeaturedDate, $nComments, $nHide, $nID);
        mysqli_stmt_execute($stmt);
        header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=news");
        exit();
    }
  }
} else {
  header("Location: ../news.php");
  exit();
}

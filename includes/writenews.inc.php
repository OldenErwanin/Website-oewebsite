<?php
session_start();
if (isset($_POST["submit-Writenews"]) && $_SESSION["uAdmin"] > 0) {
  require 'database.inc.php';

  $nTitle = $_POST["news-Title"];
  $nCategory = $_POST["news-Category"];
  $nText = $_POST["news-Text"];
  $nFeatured = $_POST["news-Featured"];
  $nFDate = "0000-00-00";
  $nHide = $_POST["news-Hide"];
  if ($nFeatured == "1") {
    $nFDate = $_POST["news-FeaturedDate"];
  }
  $nFeaturedDate = date('Y-m-d', strtotime($nFDate));
  $nComments = $_POST["news-Comments"];
  $date = date("Y-m-d");

  if (empty($nTitle) || empty($nText)) {
    header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=news&eleje=".$stmt->error);
    exit();
  } else {
    $sql = "INSERT INTO news (nTitle, nAuthor, nAuthorID, nDate, nText, cID, nFeatured, nFeaturedDate, nEnableComm, nHide) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=news&kozben=".$stmt->error);
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ssissiisii", $nTitle, $_SESSION["uName"], $_SESSION["uID"], $date, $nText, $nCategory, $nFeatured, $nFeaturedDate, $nComments, $nHide);
        mysqli_stmt_execute($stmt);
        header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=news&vege=".$stmt->error);
        exit();
    }
  }
} else {
  header("Location: ../news.php");
  exit();
}

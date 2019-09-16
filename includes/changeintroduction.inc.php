<?php
session_start();
if (isset($_POST["submit-Changeintroduction"])) {
  require 'database.inc.php';

  $iTitle = $_POST["changeintro-Title"];
  $iText = $_POST["changeintro-Text"];
  $uID = $_SESSION["uID"];

  if (empty($iTitle) || empty($iText)) {
    header("Location: ../subpages/settings.php?id=".$uID."&page=changeintro&error=emptyfields");
    exit();
  } else {
    $sql = "UPDATE users SET uIntroductionTitle=?, uIntroductionText=? WHERE uID=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../subpages/settings.php?id=".$uID."&page=changeintro&error=".$stmt->error);
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ssi", $iTitle, $iText, $uID);
        mysqli_stmt_execute($stmt);
        header("Location: ../subpages/settings.php?id=".$uID."&page=main");
        exit();
    }
  }
} else {
  header("Location: ../news.php");
  exit();
}

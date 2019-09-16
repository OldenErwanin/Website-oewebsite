<?php
session_start();
if (isset($_POST["submit-Writecomment"]) && isset($_SESSION["uID"])) {
  require 'database.inc.php';

  $cAuthorName = $_SESSION["uName"];
  $cAuthorID = $_SESSION["uID"];
  $cToID = $_POST["submit-Writecomment"];
  $cText = $_POST["writecomment-Text"];

  if (empty($cText)) {
    header("Location: ../subpages/viewcomment.php?nid=".$cToID);
    exit();
  } else {
    $sql = "INSERT INTO comments (nID, commAuthorName, commAuthorID, commText) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../subpages/viewcomment.php?nid=".$cToID);
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "isis", $cToID, $cAuthorName, $cAuthorID, $cText);
        mysqli_stmt_execute($stmt);
        $sqlNews = "UPDATE news SET commentCount = commentCount+1 WHERE nID=".$cToID;
        mysqli_query($conn, $sqlNews);
        header("Location: ../subpages/viewcomment.php?nid=".$cToID);
        exit();
    }
  }
} else {
  header("Location: ../news.php");
  exit();
}

<?php
session_start();
if (isset($_POST["submit-Writemessage"]) && $_GET["writemessage-ToName"] != $_SESSION["uName"]) {
  require 'database.inc.php';

  $mAuthorID = $_SESSION["uID"];
  $mAuthorName = $_SESSION["uName"];

  $mToName = $_POST["writemessage-ToName"];

  $sqlTo = "SELECT * FROM users WHERE uName='".$mToName."'";
  $resultTo = mysqli_query($conn, $sqlTo);
  while ($rowTo = mysqli_fetch_assoc($resultTo)) {
    $mToID = $rowTo["uID"];
  }

  $mText = $_POST["writemessage-Text"];
  $mSubject = $_POST["writemessage-Subject"];

  $mDate = date("Y-m-d H:i:s");
  $other = 0;

  $mAdmin = 0;
  if ($_SESSION["uAdmin"] > 0 && $_POST["writemessage-Admin"]) {
    $mAdmin = 1;
    if (empty($mText) || empty($mSubject)) {
      header("Location: ../subpages/messages.php?page=recieved");
      exit();
    } else {
      $sqlUsers = "SELECT * FROM users";
      $resultUsers = mysqli_query($conn, $sqlUsers);
      while ($rowUsers = mysqli_fetch_assoc($resultUsers)) {
        $sql = "INSERT INTO messages (authorID, authorName, toID, toName, mDate, mSubject, mText, mAdmin, mRead, authorDelete, toDelete) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_bind_param($stmt, "isissssiiii", $mAuthorID, $mAuthorName, $rowUsers["uID"], $rowUsers["uName"], $mDate, $mSubject, $mText, $mAdmin, $other, $other, $other);
        mysqli_stmt_execute($stmt);
      }
      header("Location: ../subpages/messages.php?page=sent&error=".$stmt->error);
      exit();
    }
  } else {
    if (empty($mToName) || empty($mText) || empty($mSubject)) {
      header("Location: ../subpages/messages.php?page=recieved");
      exit();
    } else {
      $sql = "INSERT INTO messages (authorID, authorName, toID, toName, mDate, mSubject, mText, mAdmin, mRead, authorDelete, toDelete) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../subpages/messages.php?page=sent");
          exit();
      } else {
          mysqli_stmt_bind_param($stmt, "isissssiiii", $mAuthorID, $mAuthorName, $mToID, $mToName, $mDate, $mSubject, $mText, $mAdmin, $other, $other, $other);
          mysqli_stmt_execute($stmt);
          header("Location: ../subpages/messages.php?page=sent&error=".$stmt->error);
          exit();
      }
    }
  }


} else {
  header("Location: ../news.php");
  exit();
}

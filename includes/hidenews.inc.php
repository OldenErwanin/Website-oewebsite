<?php
session_start();
if (isset($_POST["submit-HideNews"]) && $_SESSION["uAdmin"] > 0) {
  require 'database.inc.php';
  $sql = "UPDATE news SET nHide = '1' WHERE nID=".$_POST["submit-HideNews"];
  $result = mysqli_query($conn, $sql);
  header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=news");
} else if (isset($_POST["submit-ShowNews"]) && $_SESSION["uAdmin"] > 0) {
  require 'database.inc.php';
  $sql = "UPDATE news SET nHide = '0' WHERE nID=".$_POST["submit-ShowNews"];
  $result = mysqli_query($conn, $sql);
  header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=news");
} else {
  header("Location: ../news.php");
  exit();
}

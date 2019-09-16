<?php
if (isset($_POST['submit-Logout'])) {
  session_start();
  session_unset();
  session_destroy();
  header("Location: ../news.php");
} else {
  header("Location: ../news.php");
  exit();
}

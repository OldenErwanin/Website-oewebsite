<?php
if (isset($_POST['submit-Login'])) {
  require 'database.inc.php';

  $uid = $_POST['login-Uid'];
  $password = $_POST['login-Pwd'];

  if (empty($uid) || empty($password)) {
    header("Location: ../news.php?logerror=emptyfields");
    exit();
  }
  else {
    $sql = "SELECT * FROM users WHERE uName=? OR uEmail=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../news.php?logerror=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "ss", $uid, $uid);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($result)) {
        $pwdcheck = password_verify($password, $row['uPwd']);
        if ($pwdcheck == false) {
          header("Location: ../news.php?logerror=wrongpwd");
          exit();
        }
        else if ($pwdcheck == true){
          session_start();

          $_SESSION['uID'] = $row['uID'];
          $_SESSION['uName'] = $row['uName'];
          $_SESSION['uEmail'] = $row['uEmail'];
          $_SESSION['uAdmin'] = $row['uAdmin'];

          $getAvatar = "SELECT * FROM avatars WHERE uID=".$_SESSION["uID"];
          $getResult = mysqli_query($conn, $getAvatar);

          while ($getRow = mysqli_fetch_assoc($getResult)) {
            $_SESSION['aStatus'] = $getRow['aStatus'];
            $_SESSION['aType'] = $getRow['aType'];
            $_SESSION['aAdded'] = $getRow['aAdded'];
            $_SESSION['aSize'] = $getRow['aSize'];
          }

          header("Location: ../news.php?login=success");
          exit();
        }
        else {
          header("Location: ../news.php?logerror=wrongpwd");
          exit();
        }
      }
      else {
        header("Location: ../news.php?logerror=nouser");
        exit();
      }
    }
  }
}
else {
  header("Location: ../news.php");
  exit();
}

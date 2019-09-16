<?php
if (isset($_POST['submit-Changepwd'])) {
  session_start();
  require 'database.inc.php';

  $user = $_SESSION["uName"];
  $original = $_POST['changepwd-original'];
  $new = $_POST['changepwd-new'];
  $new2 = $_POST['changepwd-new2'];

  if (empty($original) || empty($new) || empty($new2)) {
    header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=changepwd&error=emptyfields");
    exit();
  }
  else {
    $sql = "SELECT * FROM users WHERE uName=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=changepwd&error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $user);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($result)) {
        $pwdcheck = password_verify($original, $row['uPwd']);
        if ($pwdcheck == false) {
          header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=changepwd&error=wrongpwd");
          exit();
        }
        else if ($pwdcheck == true){
          if ($new != $new2) {
            header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=changepwd&error=wrongpwd");
            exit();
          } else {
            $sql = ("UPDATE users SET uPwd = ? WHERE uName = ?");
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=changepwd&error=sqlerror");
                exit();
            } else {
              $hashedpwd = password_hash($new, PASSWORD_DEFAULT);
              mysqli_stmt_bind_param($stmt, "ss", $hashedpwd, $user);
              mysqli_stmt_execute($stmt);
              header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=changepwd&change=success");
              exit();
            }
          }
        }
        else {
          header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=changepwd&error=wrongpwd");
          exit();
        }
      }
      else {
        header("Location: ../subpages/settings.php?id=".$_SESSION["uID"]."&page=changepwd&error=nouser");
        exit();
      }
    }
  }
}
else {
  header("Location: ../news.php");
  exit();
}

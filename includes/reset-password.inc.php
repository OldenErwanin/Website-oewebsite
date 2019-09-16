<?php
if (isset($_POST["submit-ResetPwd"])) {
  $selector = $_POST["selector"];
  $validator = $_POST["validator"];
  $password = $_POST["reset-Pwd"];
  $password2 = $_POST["reset-Pwd2"];

  if (empty($password)) {
    echo 'Empty fields!';
    exit();
  } else if ($password != $password2) {
    echo 'Have to be the same';
    exit();
  }

  $currentDate = date("U");

  require "database.inc.php";

  $sql = "SELECT * FROM pwdreset WHERE pwdResetSelector = ? AND pwdResetExpires >= '".$currentDate."'";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "Mysql error!";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $selector);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if (!$row = mysqli_fetch_assoc($result)) {
      echo "Mysql error!";
      exit();
    } else {
      $tokenBin = hex2bin($validator);
      $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);
      if ($tokenCheck === false) {
        echo "Mysql error!";
        exit();
      } elseif ($tokenCheck === true) {
        $tokenEmail = $row["pwdResetEmail"];

        $sql = "SELECT * FROM users WHERE uEmail=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          echo "Mysql error!";
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          if (!$row = mysqli_fetch_assoc($result)) {
            echo "There was an error!";
            exit();
          } else {
              $sql = "UPDATE users SET uPwd=? WHERE uEmail=?";
              $stmt = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "Mysql error!";
                exit();
              } else {
                $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $tokenEmail);
                mysqli_stmt_execute($stmt);

                $sql = "DELETE FROM pwdreset WHERE pwdResetEmail = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                  header("Location: ../news.php");
                  exit();
                } else {
                  mysqli_stmt_bind_param($stmt, "s", $userEmail);
                  mysqli_stmt_execute($stmt);
                  
                  header("Location: ../news.php");
                  exit();
                }
              }
          }
        }
      }
    }
  }
} else {
  header("Location: ../news.php");
  exit();
}

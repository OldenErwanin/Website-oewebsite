<?php
if (isset($_POST["submit-Request"])) {
  $selector = bin2hex(random_bytes(8));
  $token = random_bytes(32);

  $url = "http://localhost/subpages/createnewpwd.php?selector=".$selector."&validator=".bin2hex($token);

  $expires = date("U") + 1800;

  require 'database.inc.php';

  $userEmail = $_POST["request-Uid"];

  $sql = "DELETE FROM pwdreset WHERE pwdResetEmail = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../news.php");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $userEmail);
    mysqli_stmt_execute($stmt);
  }

  $sql = "INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../news.php");
    exit();
  } else {
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
    mysqli_stmt_execute($stmt);
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

  $to = $userEmail;
  $subject = "Reset your password for oldenerwanin.com";
  $message = "<p>We recieved a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email.</p>";
  $message .= "<p>Here is your password reset link:</br>";
  $message .= "<a href=".$url.">".$url."</a></p>";

  $headers = "From: oldenerwanin <oldenerwanin@gmail.com>\r\n";
  $headers .= "Reply-To: oldenerwanin@gmail.com\r\n";
  $headers .= "Content-type: text/html\r\n";

  mail($to, $subject, $message, $headers);

  header("Location: ../news.php?request=success");
} else {
  header("Location: ../news.php");
  exit();
}

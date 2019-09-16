<?php
if (isset($_POST["submit-Changeavatar"])) {
  session_start();
  require 'database.inc.php';
  $file = $_FILES["changeavatar-pic"];

  $fileName = $file["name"];
  $fileTmpName = $file["tmp_name"];
  $fileSize = $file["size"];
  $fileError = $file["error"];
  $fileType = $file["type"];
  $date = date("Y-m-d");
  $user = $_SESSION["uID"];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('jpg', 'jpeg', 'png');

  if (in_array($fileActualExt, $allowed)) {
    if ($fileError === 0) {
      if ($fileSize < 1000000) {
        $currFile = "profile".$_SESSION["uID"].".".$_SESSION["aType"];
        $path = "../img/avatars/".$currFile;
      	unlink($path);

        $fileNameNew = $user.".".$fileActualExt;
        $fileDestination = '../img/avatars/profile'.$fileNameNew;
        move_uploaded_file($fileTmpName, $fileDestination);
        $sql = "UPDATE avatars SET aStatus=0, aType='".$fileActualExt."', aSize='".$fileSize."', aAdded='".$date."' WHERE uID=".$_SESSION["uID"];
        $_SESSION['aStatus'] = 0;
        $_SESSION['aType'] = $fileActualExt;
        $_SESSION['aAdded'] = $date;
        $_SESSION['aSize'] = $fileSize;
        $result = mysqli_query($conn, $sql);

        header("Location: ../subpages/settings.php?id=".$_SESSION['uID']."&page=changeavatar");
      }
    }
  }
} else {
  header("Location: ../news.php");
  exit();
}

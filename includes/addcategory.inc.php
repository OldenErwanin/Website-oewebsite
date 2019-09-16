<?php
if (isset($_POST["submit-AddCategory"])) {
  session_start();
  require 'database.inc.php';

  $name = $_POST["category-Name"];
  $file = $_FILES["category-Avatar"];
  $fName = strtolower($name);
  $fileName = $file["name"];
  $fileTmpName = $file["tmp_name"];
  $fileSize = $file["size"];
  $fileError = $file["error"];
  $fileType = $file["type"];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('jpg', 'jpeg', 'png');

  if (in_array($fileActualExt, $allowed)) {
    if ($fileError === 0) {
      if ($fileSize < 1000000) {

        $fileNameNew = $fName.".".$fileActualExt;
        $fileDestination = '../img/categories/'.$fileNameNew;
        move_uploaded_file($fileTmpName, $fileDestination);
        $sql = "INSERT INTO categories (cName, cPicName, cPicType) VALUES ('$name', '$fName', '$fileActualExt')";
        $result = mysqli_query($conn, $sql);

        header("Location: ../subpages/settings.php?id=".$_SESSION['uID']."&page=categories");
      }
    }
  }
} else {
  header("Location: ../news.php");
  exit();
}

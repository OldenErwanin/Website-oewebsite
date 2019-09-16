<?php
session_start();
if (isset($_POST["submit-EditCategory"]) && $_SESSION["uAdmin"] > 0) {
  require 'database.inc.php';

  $categoryName = $_POST["category-Name"];
  if (isset($_FILES["category-Avatar"])) {
    $file = $_FILES["category-Avatar"];

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
          $currSql = "SELECT * FROM categories WHERE cID=".$_POST["submit-EditCategory"];
          $currResult = mysqli_query($conn, $currSql);
          while ($currRow = mysqli_fetch_assoc($currResult)) {
            $oldFileName = $currRow["cPicName"];
            $oldFileType = $currRow["cPicType"];
          }
          $currFile = $oldFileName.".".$oldFileType;
          $path = "../img/categories/".$currFile;
        	unlink($path);

          $fileNameNew = strtolower($categoryName).".".$fileActualExt;
          $fileDestination = '../img/categories/'.$fileNameNew;

          $lowerName = strtolower($categoryName);
          move_uploaded_file($fileTmpName, $fileDestination);
          $sql = "UPDATE categories SET cName='".$categoryName."', cPicName='".$lowerName."', cPicType='".$fileActualExt."' WHERE cID=".$_POST["submit-EditCategory"];
          $result = mysqli_query($conn, $sql);
          header("Location: ../subpages/settings.php?id=".$_SESSION['uID']."&page=categories");
        }
      }
    }
  } else {
    header("Location: ../subpages/settings.php?id=".$_SESSION['uID']."&page=categories");
    exit();
  }

} else {
  header("Location: ../news.php");
  exit();
}

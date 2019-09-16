<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>OldenErwanin's website - Settings page</title>
    <meta name="description" content="OldenErwanin website">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900|Cormorant+Garamond:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
  </head>
  <body>
    <?php
      require "../header.php";
      require '../includes/database.inc.php';
      if ($_SESSION["uAdmin"] < 1) {
        exit();
      }
      $sql = "SELECT * FROM categories WHERE cID=".$_GET["cid"];
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        $cID = $row["cID"];
        $cName = $row["cName"];
        $cPicName = $row["cPicName"];
        $cPicType = $row["cPicType"];
      }
    ?>

    <main class="pageEditCategory">
      <div class="wrapper">
        <h1 class="block-title">Edit category</h1>
        <form action="../includes/editcategory.inc.php" method="post" enctype="multipart/form-data">
          <input type="text" name="category-Name" value="<?php echo $cName; ?>">
          <input name="category-Avatar" type="file">
          <button type="submit" name="submit-EditCategory" value="<?php echo $cID; ?>">Edit category</button>
        </form>
      </div>
    </main>
    <script>
      var tooltips = document.querySelectorAll('.tooltip span');

      window.onmousemove = function (e) {
        var x = (e.clientX + 20) + 'px',
            y = (e.clientY + 20) + 'px';
        for (var i = 0; i < tooltips.length; i++) {
            tooltips[i].style.top = y;
            tooltips[i].style.left = x;
        }
      };
    </script>
  </body>
</html>

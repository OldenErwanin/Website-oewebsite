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
    ?>

    <main class="pageAddCategory">
      <div class="wrapper">
        <h1 class="block-title">Add new category</h1>
        <form action="../includes/addcategory.inc.php" method="post" enctype="multipart/form-data">
          <input type="text" name="category-Name" placeholder="Category name">
          <input name="category-Avatar" type="file">
          <button type="submit" name="submit-AddCategory">Add category</button>
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

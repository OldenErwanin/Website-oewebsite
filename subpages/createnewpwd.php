<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OldenErwanin's website - Sign up page</title>
    <meta name="description" content="OldenErwanin website">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900|Cormorant+Garamond:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <div class='wrapper'>
      <?php
        $select = $_GET["selector"];
        $validator = $_GET["validator"];

        if (empty($selector) || empty($validator)) {
          header("Location: ../news.php");
          exit();
        } else {
          if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
            ?>
            <form action="../includes/reset-password.inc.php" method="post">
              <input type="hidden" name="selector" value="<?php echo $selector; ?>">
              <input type="hidden" name="validator" value="<?php echo $validator; ?>">
              <input type="password" name="reset-Pwd" placeholder="New password">
              <input type="password" name="reset-Pwd2" placeholder="New password again">
              <button type="submit" name="submit-ResetPwd">Reset password</button>
            </form>
            <?php
          }
        }
      ?>
    </div>
</body>

</html>

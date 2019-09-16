<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>OldenErwanin's website - User page</title>
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
      if (!isset($_SESSION["uID"])) {
        exit();
      }
    ?>
    <main class="profilePage">
      <div class="wrapper">
        <?php
        require '../includes/database.inc.php';
        $sql = "SELECT * FROM users WHERE uID = ".$_GET['id'];
        $rs = $conn->query($sql);
        $uName = $rs->fetch_assoc()['uName'];
        ?>
        <div class="block-title">Profile: <?php echo $uName; ?></div>

        <section class="profile-Menu">
          <p>Menu</p>
          <ul>
            <?php
              $viewID = $_GET["id"];
              if ($_GET["page"] == "pdata") {
                echo '
                  <li class="active"><a href="../subpages/user.php?id='.$viewID.'&page=pdata"><img src="../img/icons/profile/personal-data.png"> Personal data</a></li>
                  <li><a href="../subpages/user.php?id='.$viewID.'&page=intro"><img src="../img/icons/profile/introduction.png"> Introduction</a></li>
                  <li><a href="../subpages/user.php?id='.$viewID.'&page=achiv"><img src="../img/icons/profile/achivement.png"> Achivements</a></li>
                  <li><a href="../subpages/user.php?id='.$viewID.'&page=message"><img src="../img/icons/profile/messages.png"> Messages</a></li>
                ';
              } else if ($_GET["page"] == "intro") {
                echo '
                  <li><a href="../subpages/user.php?id='.$viewID.'&page=pdata"><img src="../img/icons/profile/personal-data.png"> Personal data</a></li>
                  <li class="active"><a href="../subpages/user.php?id='.$viewID.'&page=intro"><img src="../img/icons/profile/introduction.png"> Introduction</a></li>
                  <li><a href="../subpages/user.php?id='.$viewID.'&page=achiv"><img src="../img/icons/profile/achivement.png"> Achivements</a></li>
                  <li><a href="../subpages/user.php?id='.$viewID.'&page=message"><img src="../img/icons/profile/messages.png"> Messages</a></li>
                ';
              } else if ($_GET["page"] == "achiv") {
                echo '
                  <li><a href="../subpages/user.php?id='.$viewID.'&page=pdata"><img src="../img/icons/profile/personal-data.png"> Personal data</a></li>
                  <li><a href="../subpages/user.php?id='.$viewID.'&page=intro"><img src="../img/icons/profile/introduction.png"> Introduction</a></li>
                  <li class="active"><a href="../subpages/user.php?id='.$viewID.'&page=achiv"><img src="../img/icons/profile/achivement.png"> Achivements</a></li>
                  <li><a href="../subpages/user.php?id='.$viewID.'&page=message"><img src="../img/icons/profile/messages.png"> Messages</a></li>
                ';
              } else if ($_GET["page"] == "message") {
                echo '
                  <li><a href="../subpages/user.php?id='.$viewID.'&page=pdata"><img src="../img/icons/profile/personal-data.png"> Personal data</a></li>
                  <li><a href="../subpages/user.php?id='.$viewID.'&page=intro"><img src="../img/icons/profile/introduction.png"> Introduction</a></li>
                  <li><a href="../subpages/user.php?id='.$viewID.'&page=achiv"><img src="../img/icons/profile/achivement.png"> Achivements</a></li>
                  <li class="active"><a href="../subpages/user.php?id='.$viewID.'&page=message"><img src="../img/icons/profile/messages.png"> Messages</a></li>
                ';
              }
            ?>
          </ul>
        </section>
        <section class="profile-Main">
          <?php
            require '../includes/database.inc.php';
            $sql = "SELECT * FROM users WHERE uID = ".$_GET['id'];
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
              $uID = $row['uID'];
              $uName = $row['uName'];
              $uEmail = $row['uEmail'];
              $uBirth = $row['uBirth'];
              $uReg = $row['uRegistred'];
              $uIntroductionTitle = $row['uIntroductionTitle'];
              $uIntroductionText = $row['uIntroductionText'];
            }
            if ($_GET["page"] == "pdata") {
              echo '
                <section class="personal-data">
                  <div class="row">
                    <div class="text">Username</div>
                    <div class="data">'.$uName.'</div>
                  </div>
                  <div class="row">
                    <div class="text">E-mail</div>
                    <div class="data">'.$uEmail.'</div>
                  </div>
                  <div class="row">
                    <div class="text">Birthday</div>
                    <div class="data">'.$uBirth.'</div>
                  </div>
                  <div class="row">
                    <div class="text">Registered</div>
                    <div class="data">'.$uReg.'</div>
                  </div>
                </section
              ';
            } else if ($_GET["page"] == "intro") {
              echo '
                <section class="introduction">
                  <div class="title">
                    <h1>'.$uIntroductionTitle.'</h1>
                  </div>
                  <div class="text">
                    '.$uIntroductionText.'
                  </div>
                </section
              ';
            }
          ?>
        </section>
      </div>
    </main>
  </body>
</html>

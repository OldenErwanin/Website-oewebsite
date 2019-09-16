<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>OldenErwanin's website - Edit news page</title>
    <meta name="description" content="OldenErwanin website">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900|Cormorant+Garamond:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="../ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/editor.css">
  </head>
  <body>
    <?php
      require "../header.php";
      require "../includes/database.inc.php";
      if (!isset($_SESSION["uID"])) {
        header("Location: ../news.php");
        exit();
      }
      if (isset($_GET["deletef"])) {
        echo '
          <section id="aPageConfirmFriendDelete">
            <div class="container">
              <p>Are you sure, that you want to delete friend with the ID: '.$_GET["deletef"].'</p>
              <form class="yes" action="../includes/deletefriend.inc.php" method="post">
                <button type="submit" name="submit-DeleteFriend" value="'.$_GET["deletef"].'">Yes</button>
              </form>
              <form class="no" action="?page=list" method="post">
                <button type="submit">No</button>
              </form>
            </div>
          </section>
        ';
      }
    ?>

    <main class="friendsPage">
      <div class="wrapper">
        <h1 class="block-title">Manage friends</h1>
        <section class="friends-Menu">
          <p>Menu</p>
          <ul>
            <?php
              if ($_GET["page"] == "list") {
                echo '
                  <li class="active"><a href="../subpages/friends.php?page=list"><img src="../img/icons/friends/list.png"> Friends list</a></li>
                  <li><a href="../subpages/friends.php?page=add"><img src="../img/icons/friends/add.png"> Add friend</a></li>
                ';
              } else if ($_GET["page"] == "add") {
                echo '
                <li><a href="../subpages/friends.php?page=list"><img src="../img/icons/friends/list.png"> Friends list</a></li>
                <li class="active"><a href="../subpages/friends.php?page=add"><img src="../img/icons/friends/add.png"> Add friend</a></li>
                ';
              }
            ?>
          </ul>
        </section>
        <section class="friends-Main">
          <?php
          $sqlList = "SELECT * FROM friends WHERE uID = '".$_SESSION["uID"]."' OR toID = '".$_SESSION["uID"]."' ORDER BY fID DESC";
          $resultList = mysqli_query($conn, $sqlList);
          $numberFriends = mysqli_num_rows($resultList);

          if ($_GET["page"] == "list") {
            echo '
            <div class="title">
              <p>Friends list | Friends: <span><?php echo $numberFriends; ?></span></p>
            </div>
            <div class="friends-List">
              <div class="table">
                <div class="header">
                  <div class="column cName"><p>Friend name</p></div>
                  <div class="column cDate"><p>Date</p></div>
                  <div class="column cState"><p>State</p></div>
                  <div class="column cManage"><p>Manage</p></div>
                </div>
            ';
          while ($rowList = mysqli_fetch_assoc($resultList)) {
            if ($rowList["uID"] == $_SESSION["uID"]) {
              $friendName = $rowList["toName"];
              $friendID = $rowList["toID"];
              if ($rowList["fState"] == 1) {
                $stateName = "Waiting for answer...";
              } else {
                $stateName = "Friend";
              }
            } else {
              $friendName = $rowList["uName"];
              $friendID = $rowList["uID"];
              if ($rowList["fState"] == 1) {
                $stateName = "Arrived friend request";
              } else {
                $stateName = "Friend";
              }
            }
            if ($rowList["fState"] == 1) {
              echo '
                <div class="row bold">
                  <div class="column cName"><p>' . $friendName . '</p></div>
                  <div class="column cDate"><p>' . date("Y.m.d", strtotime($rowList["fDate"])) . '</p></div>
                  <div class="column cState"><p>' . $stateName . '</p></div>
                  <div class="column cManage">
                  ';
                  if ($rowList["toID"] == $_SESSION["uID"]) {
                    echo '
                      <form style="margin-left:40px;" action="../includes/friendanswer.inc.php" method="post">
                        <input type="hidden" value="'.$rowList["fID"]. '" name="friendanswer-ID">
                        <button type="submit" name="submit-FriendAnswer" value="refuse">Refuse |</button>
                      </form>
                      <form action="../includes/friendanswer.inc.php" method="post">
                        <input type="hidden" value="' . $rowList["fID"] . '" name="friendanswer-ID">
                        <button type="submit" name="submit-FriendAnswer" value="accept">Accept</button>
                      </form>
                    ';
                  }
                  echo '
                  </div>
                </div>
              ';
            } elseif ($rowList["fState"] == 2) {
              echo '
                <div class="row">
                  <div class="column cName"><p>' . $friendName . '</p></div>
                  <div class="column cDate"><p>' . date("Y.m.d", strtotime($rowList["fDate"])) . '</p></div>
                  <div class="column cState"><p>' . $stateName . '</p></div>
                  <div class="column cManage">
                    <form action="?page=list&deletef=' . $rowList["fID"] . '" method="post" style="margin-left: 8px;">
                      <button type="submit" name="submit-DeleteFriend">Delete |</button>
                    </form>
                    <form action="../subpages/user.php?id=' . $friendID . '&page=pdata" method="post">
                      <button type="submit">Profile |</button>
                    </form>
                    <form action="../subpages/messages.php?page=write&to=' . $friendName . '" method="post">
                      <button type="submit">Message</button>
                    </form>
                  </div>
                </div>
              ';
            }
          }
          ?>
            </div>
          </div>
        </section>
      <?php } else if ($_GET["page"] == "add") {
        echo '
          <div class="title">
            <p>Send friend request</p>
          </div>
          <div class="friends-Add">
            <form action="../includes/addfriend.inc.php" method="post">
              <input type="text" name="addfriend-Name" placeholder="User name">
              <button type="submit" name="submit-AddFriend">Send request</button>
            </form>
          </div>
        ';

      }?>
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

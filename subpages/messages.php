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
      if (isset($_GET["deletem"])) {
        echo '
          <section id="aPageConfirmMessageDelete">
            <div class="container">
              <p>Are you sure, that you want to delete the message with the ID: '.$_GET["deletem"].'</p>
              <form class="yes" action="../includes/deletemessage.inc.php" method="post">
                <button type="submit" name="submit-DeleteMessage" value="'.$_GET["deletem"].'">Yes</button>
              </form>
              <form class="no" action="?page=recieved" method="post">
                <button type="submit">No</button>
              </form>
            </div>
          </section>
        ';
      }
    ?>

    <main class="messagesPage">
      <div class="wrapper">
        <h1 class="block-title">Private messages</h1>
        <section class="messages-Menu">
          <p>Menu</p>
          <ul>
            <?php
              if ($_GET["page"] == "recieved") {
                echo '
                  <li class="active"><a href="../subpages/messages.php?page=recieved"><img src="../img/icons/messages/got.png"> Recieved</a></li>
                  <li><a href="../subpages/messages.php?page=sent"><img src="../img/icons/messages/sent.png"> Sent</a></li>
                  <li><a href="../subpages/messages.php?page=write"><img src="../img/icons/messages/write.png"> Write</a></li>
                ';
              } else if ($_GET["page"] == "sent") {
                echo '
                <li><a href="../subpages/messages.php?page=recieved"><img src="../img/icons/messages/got.png"> Recieved</a></li>
                <li class="active"><a href="../subpages/messages.php?page=sent"><img src="../img/icons/messages/sent.png"> Sent</a></li>
                <li><a href="../subpages/messages.php?page=write"><img src="../img/icons/messages/write.png"> Write</a></li>
                ';
              } else if ($_GET["page"] == "write") {
                echo '
                <li><a href="../subpages/messages.php?page=recieved"><img src="../img/icons/messages/got.png"> Recieved</a></li>
                <li><a href="../subpages/messages.php?page=sent"><img src="../img/icons/messages/sent.png"> Sent</a></li>
                <li class="active"><a href="../subpages/messages.php?page=write"><img src="../img/icons/messages/write.png"> Write</a></li>
                ';
              } else if ($_GET["page"] == "read") {
                echo '
                <li><a href="../subpages/messages.php?page=recieved"><img src="../img/icons/messages/got.png"> Recieved</a></li>
                <li><a href="../subpages/messages.php?page=sent"><img src="../img/icons/messages/sent.png"> Sent</a></li>
                <li><a href="../subpages/messages.php?page=write"><img src="../img/icons/messages/write.png"> Write</a></li>
                ';
              }
            ?>
          </ul>
        </section>
        <section class="messages-Main">

          <!--
                RECIEVED PAGE
                              -->
          <?php
          if ($_GET["page"] == "recieved" && !isset($_GET["read"])) {
            $sqlGot = "SELECT * FROM messages WHERE toDelete = 0 AND toID='".$_SESSION["uID"]."' ORDER BY mID DESC";
            $resultGot = mysqli_query($conn, $sqlGot);
            $numberGot = mysqli_num_rows($resultGot);

            $sqlGotUnread = "SELECT * FROM messages WHERE mRead = 0 AND toDelete = 0 AND toID=".$_SESSION["uID"];
            $resultGotUnread = mysqli_query($conn, $sqlGotUnread);
            $numberGotUnread = mysqli_num_rows($resultGotUnread);
            echo '
              <div class="title">
                <p>Recieved messages: <span>'.$numberGot.'</span> | Unread: <span>'.$numberGotUnread.'</span></p>
              </div>
              <div class="messages-Got">
                <div class="table">
                  <div class="header">
                    <div class="column cDate"><p>Date</p></div>
                    <div class="column cAuthor"><p>Author</p></div>
                    <div class="column cSubject"><p>Subject</p></div>
                    <div class="column cManage"><p>Manage</p></div>
                  </div>
                  ';
                  while ($rowGot = mysqli_fetch_assoc($resultGot)) {
                    if ($rowGot["mRead"] == 0 && $rowGot["mAdmin"] == 0) {
                      echo '
                      <div class="row">
                        <div class="column cDate" style="background-color: #ffc299; border-color: #ffa366;"><p>'.date("Y.m.d - H:i", strtotime($rowGot["mDate"])).'</p></div>
                        <div class="column cAuthor" style="background-color: #ffc299; border-color: #ffa366;"><p>'.$rowGot["authorName"].'</p></div>
                        <div class="column cSubject" style="background-color: #ffc299; border-color: #ffa366;"><p>'.$rowGot["mSubject"].'</p></div>
                        <div class="column cManage">
                          <form action="?page=recieved&deletem='.$rowGot["mID"].'" method="post">
                            <button type="submit" name="submit-DeleteMessage">Delete |</button>
                          </form>
                          <form action="?page=recieved&read='.$rowGot["mID"].'" method="post">
                            <button type="submit">View |</button>
                          </form>
                          <form action="../includes/readmessage.inc.php" method="post">
                            <button type="submit" name="submit-ReadMessage" value="'.$rowGot["mID"].'">Read</button>
                          </form>
                        </div>
                      </div>
                      ';
                    } else if ($rowGot["mRead"] == 0 && $rowGot["mAdmin"] == 1) {
                      echo '
                      <div class="row">
                        <div class="column cDate" style="background-color: #ff8080; border-color: #ff4d4d;"><p>'.date("Y.m.d - H:i", strtotime($rowGot["mDate"])).'</p></div>
                        <div class="column cAuthor" style="background-color: #ff8080; border-color: #ff4d4d;"><p>'.$rowGot["authorName"].'</p></div>
                        <div class="column cSubject" style="background-color: #ff8080; border-color: #ff4d4d;"><p>'.$rowGot["mSubject"].'</p></div>
                        <div class="column cManage">
                          <form action="?page=recieved&deletem='.$rowGot["mID"].'" method="post">
                            <button type="submit" name="submit-DeleteMessage">Delete |</button>
                          </form>
                          <form action="?page=recieved&read='.$rowGot["mID"].'" method="post">
                            <button type="submit">View |</button>
                          </form>
                          <form action="../includes/readmessage.inc.php" method="post">
                            <button type="submit" name="submit-ReadMessage" value="'.$rowGot["mID"].'">Read</button>
                          </form>
                        </div>
                      </div>
                      ';
                    } else if ($rowGot["mRead"] == 1) {
                      echo '
                      <div class="row">
                        <div class="column cDate"><p>'.date("Y.m.d - H:i", strtotime($rowGot["mDate"])).'</p></div>
                        <div class="column cAuthor"><p>'.$rowGot["authorName"].'</p></div>
                        <div class="column cSubject"><p>'.$rowGot["mSubject"].'</p></div>
                        <div class="column cManage">
                          <form style="margin-left: 20px; action="?page=recieved&deletem='.$rowGot["mID"].'" method="post">
                            <button type="submit" name="submit-DeleteMessage">Delete |</button>
                          </form>
                          <form action="?page=recieved&read='.$rowGot["mID"].'" method="post">
                            <button type="submit">View</button>
                          </form>
                        </div>
                      </div>
                      ';
                    }
                  }

                  echo '
                </div>
              </div>
            ';
          // ---------
          // SENT PAGE
          // ---------
        } else if ($_GET["page"] == "sent" && !isset($_GET["read"])) {
          $sqlSent = "SELECT * FROM messages WHERE authorDelete = 0 AND authorID='".$_SESSION["uID"]."' ORDER BY mID DESC";
          $resultSent = mysqli_query($conn, $sqlSent);
          $numberSent = mysqli_num_rows($resultSent);
          echo '
            <div class="title">
              <p>Sent messages: <span>'.$numberSent.'</span></p>
            </div>
            <div class="messages-Sent">
              <div class="table">
                <div class="header">
                  <div class="column cDate"><p>Date</p></div>
                  <div class="column cAuthor"><p>Adressee</p></div>
                  <div class="column cSubject"><p>Subject</p></div>
                  <div class="column cManage"><p>Manage</p></div>
                </div>
                ';
                while ($rowSent = mysqli_fetch_assoc($resultSent)) {
                  if ($rowSent["authorDelete"] == 0) {
                    echo '
                    <div class="row">
                      <div class="column cDate"><p>'.date("Y.m.d - H:i", strtotime($rowSent["mDate"])).'</p></div>
                      <div class="column cAuthor"><p>'.$rowSent["toName"].'</p></div>
                      <div class="column cSubject"><p>'.$rowSent["mSubject"].'</p></div>
                      <div class="column cManage">
                        <form style="margin-left: 20px;" action="?page=sent&deletem='.$rowSent["mID"].'" method="post">
                          <button type="submit" name="submit-DeleteMessage">Delete |</button>
                        </form>
                        <form action="?page=sent&read='.$rowSent["mID"].'" method="post">
                          <button type="submit">View</button>
                        </form>
                      </div>
                    </div>
                    ';
                  }
                }

                echo '
              </div>
            </div>
          ';
          // ----------
          // WRITE PAGE
          // ----------
        } else if ($_GET["page"] == "write") {
          $msgToName = "";
          if (isset($_GET["to"])) {
            $msgToName = $_GET["to"];
          }
          echo '
          <div class="title">
            <p>Write new message</p>
          </div>
          <div class="messages-Write">
            <form action="../includes/writemessage.inc.php" method="post">
              <input type="text" name="writemessage-ToName" value="'.$msgToName.'" placeholder="Addressee" list="friends">
                <datalist id="friends">
                ';
                $sqlFriendlist = "SELECT * FROM friends WHERE uID = '".$_SESSION["uID"]."' OR toID = '".$_SESSION["uID"]."' ORDER BY fID DESC";
                $resultFriendlist = mysqli_query($conn, $sqlFriendlist);
                while ($rowFriendlist = mysqli_fetch_assoc($resultFriendlist)) {
                  if ($rowFriendlist["uID"] == $_SESSION["uID"]) {
                    $friendName = $rowFriendlist["toName"];
                  } else {
                    $friendName = $rowFriendlist["uName"];
                  }
                  echo '
                    <option value="'.$friendName.'">
                  ';
                }
                echo '
                </datalist>
              <input type="text" name="writemessage-Subject" placeholder="Subject">
              <textarea name="writemessage-Text"></textarea>
              ';
              //if ($_SESSION["uAdmin"] > 0) {
              //  echo '
              //    <table>
              //      <tr>
              //        <td class="ck">
              //          <input type="checkbox" name="writemessage-Admin">
              //        </td>
              //        <td>
              //          Admin message to all
              //        </td>
              //      </tr>
              //    </table>
              //  ';
              //}
              echo '
              <button type="submit" name="submit-Writemessage">Send message</button>
            </form>
          </div>
          ';
        } else if ($_GET["page"] == "recieved" && isset($_GET["read"])) {
          $sqlRead = "SELECT * FROM messages WHERE mID = ".$_GET["read"];
          $resultRead = mysqli_query($conn, $sqlRead);
          while ($rowRead = mysqli_fetch_assoc($resultRead)) {
            $readAuthor = $rowRead["authorName"];
            $readID = $rowRead["authorID"];
            $readDate = $rowRead["mDate"];
            $readSubject = $rowRead["mSubject"];
            $readText = $rowRead["mText"];

            if ($rowRead["toID"] == $_SESSION["uID"] && $rowRead["mRead"] == 0) {
              $sqlSetRead = "UPDATE messages SET mRead = 1 WHERE mID = ".$_GET["read"];
              mysqli_query($conn, $sqlSetRead);
            }
          }
          echo '
            <div class="title">
              <p>Recieved message</p>
            </div>
            <div class="messages-Read">
              <div class="info">
                <div class="subjectText">
                  From
                </div>
                <div class="subjectData">
                  '.$readAuthor.'
                </div>
                <div class="subjectText">
                  Sent date
                </div>
                <div class="subjectData">
                  '.date("Y.m.d - H:i", strtotime($readDate)).'
                </div>
              </div>
              <div class="message">
                <div class="subjectText">
                  Subject
                </div>
                <div class="subjectData">
                  '.$readSubject.'
                </div>
                <div class="textText">
                  Text
                </div>
                <div class="textData">
                  '.$readText.'
                </div>
              </div>
            </div>
          ';

          echo '
            </div>
          ';
        } else if ($_GET["page"] == "sent" && isset($_GET["read"])) {
          $sqlRead = "SELECT * FROM messages WHERE mID = ".$_GET["read"];
          $resultRead = mysqli_query($conn, $sqlRead);
          while ($rowRead = mysqli_fetch_assoc($resultRead)) {
            $readAuthor = $rowRead["toName"];
            $readID = $rowRead["toID"];
            $readDate = $rowRead["mDate"];
            $readSubject = $rowRead["mSubject"];
            $readText = $rowRead["mText"];
          }
          echo '
            <div class="title">
              <p>Sent message</p>
            </div>
            <div class="messages-Read">
              <div class="info">
                <div class="subjectText">
                  To
                </div>
                <div class="subjectData">
                  '.$readAuthor.'
                </div>
                <div class="subjectText">
                  Sent date
                </div>
                <div class="subjectData">
                  '.date("Y.m.d - H:i", strtotime($readDate)).'
                </div>
              </div>
              <div class="message">
                <div class="subjectText">
                  Subject
                </div>
                <div class="subjectData">
                  '.$readSubject.'
                </div>
                <div class="textText">
                  Text
                </div>
                <div class="textData">
                  '.$readText.'
                </div>
              </div>
            </div>
          ';

          echo '
            </div>
          ';
        }
          ?>
        </section>
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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>OldenErwanin's website - View comments</title>
    <meta name="description" content="OldenErwanin website">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900|Cormorant+Garamond:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="../ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
  </head>
  <body>
    <?php
      require '../includes/database.inc.php';
      require "../header.php";
      if (!isset($_SESSION["uID"])) {
        exit();
      }
      if (isset($_POST["viewCommentButton"]) && !isset($_SESSION["visited".$_GET["nid"]])) {
        $sqlUpdateNews = "UPDATE news SET viewCount = viewCount+1 WHERE nID=".$_GET["nid"];
        mysqli_query($conn, $sqlUpdateNews);
        $_SESSION["visited".$_GET["nid"]] = 1;
      }
      if (isset($_GET['pageno'])) {
          $pageno = $_GET['pageno'];
      } else {
          $pageno = 1;
      }
      $no_of_records_per_page = 5;
      $offset = ($pageno-1) * $no_of_records_per_page;

      $total_pages_sql = "SELECT COUNT(*) FROM comments WHERE nID = ".$_GET["nid"];
      $result = mysqli_query($conn,$total_pages_sql);
      $total_rows = mysqli_fetch_array($result)[0];
      $total_pages = ceil($total_rows / $no_of_records_per_page);
    ?>
    <main class="writenewsPage">
      <div class="wrapper">
        <h1 class="block-title">View comments</h1>
        <?php
          $sqlNews = "SELECT * FROM news WHERE nID=".$_GET["nid"];
          $resultNews = mysqli_query($conn, $sqlNews);
          while ($rowNews = mysqli_fetch_assoc($resultNews)) {
            $newsTitle = $rowNews["nTitle"];
            $newsCategory = $rowNews["cID"];
            $newsText = $rowNews["nText"];
            $newsDate = $rowNews["nDate"];
          }
          $sqlCategory = "SELECT * FROM categories WHERE cID=".$newsCategory;
          $resultCategory = mysqli_query($conn, $sqlCategory);
          while ($rowCategory = mysqli_fetch_assoc($resultCategory)) {
            $cName = $rowCategory["cName"];
            $cPicName = $rowCategory["cPicName"];
            $cPicType = $rowCategory["cPicType"];
          }
        ?>
        <section class="news-main">
          <article class="news-body">
            <div class="bg">
                <div class="data">
                    <table>
                        <tr>
                            <td class="left">
                                <img class="tumblr" src="../img/categories/<?php echo $cPicName.'.'.$cPicType; ?>" alt="Category picture">
                                <h2>asd</h2>
                                <h3><span class="category">Category:</span> <?php echo $cName; ?></h3>
                            </td>
                            <td class="right">
                                <span class="other"><?php echo date("m. d.", strtotime($newsDate)); ?></span>
                                <span class="year"><?php echo date("Y", strtotime($newsDate)); ?></span><br>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="text">
                    <?php echo $newsText; ?>
                </div>
            </div>
          </article>
        </section>
        <div class="pageManager">
          <ul class="pagination">
              <li  class="tooltip"><span>Last page</span><a href="<?php echo '?nid='.$_GET["nid"].'&pageno='.$total_pages; ?>"><i class="fas fa-angle-double-right"></i></a></li>
              <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> tooltip">
                  <span>Next page</span>
                  <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?nid=".$_GET['nid']."&pageno=".($pageno + 1); } ?>"><i class="fas fa-angle-right"></i></a>
              </li>
              <?php
                if ($total_pages == 1) {
                  echo '
                    <li class="active">
                      <a href="#">'.($pageno).'</a>
                    </li>
                  ';
                } else if ($total_pages == 2) {
                  if ($pageno == 1) {
                    echo '
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno + 1).'">'.($pageno + 1).'</a>
                      </li>
                      <li class="active">
                        <a href="#">'.($pageno).'</a>
                      </li>
                    ';
                  } else if ($pageno == 2) {
                    echo '
                      <li class="active">
                        <a href="#">'.($pageno).'</a>
                      </li>
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno - 1).'">'.($pageno - 1).'</a>
                      </li>
                    ';
                  }
                } else if ($total_pages >= 3) {
                  if ($pageno == $total_pages) {
                    echo '
                      <li class="active">
                        <a href="#">'.($pageno).'</a>
                      </li>
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno - 1).'">'.($pageno - 1).'</a>
                      </li>
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno - 2).'">'.($pageno - 2).'</a>
                      </li>
                    ';
                  } else if ($pageno > 1 && $pageno < $total_pages) {
                    echo '
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno + 1).'">'.($pageno + 1).'</a>
                      </li>
                      <li class="active">
                        <a href="#">'.($pageno).'</a>
                      </li>
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno - 1).'">'.($pageno - 1).'</a>
                      </li>
                    ';
                  }  else if ($pageno == 1) {
                    echo '
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno + 2).'">'.($pageno + 2).'</a>
                      </li>
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno + 1).'">'.($pageno + 1).'</a>
                      </li>
                      <li class="active">
                        <a href="#">'.($pageno).'</a>
                      </li>
                    ';
                  }
                }
              ?>
              <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?> tooltip">
                  <span>Previous page</span>
                  <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?nid=".$_GET['nid']."&pageno=".($pageno - 1); } ?>"><i class="fas fa-angle-left"></i></a>
              </li>
              <li class="tooltip"><span>First page</span><a href="<?php echo "?nid=".$_GET['nid']."&pageno=1"; ?>"><i class="fas fa-angle-double-left"></i></a></li>
          </ul>
        </div>
        <div class="commentsMainBody">
          <div class="header">
            <h2>Comments for the news: <span><?php echo $newsTitle; ?></span></h2>
          </div>
          <?php
            $sqlComments = "SELECT * FROM comments WHERE nID='".$_GET["nid"]."' ORDER BY commID ASC LIMIT $offset, $no_of_records_per_page";
            $resultComments = mysqli_query($conn, $sqlComments);
            while ($rowComments = mysqli_fetch_assoc($resultComments)) {
              $commentAuthorID = $rowComments["commAuthorID"];
              $commentAuthorName = $rowComments["commAuthorName"];
              $commentDate = $rowComments["commDate"];
              $commentText = $rowComments["commText"];

              $sqlAuthor = "SELECT * FROM avatars WHERE uID=".$rowComments["commAuthorID"];
              $resultAuthor = mysqli_query($conn, $sqlAuthor);
              while ($rowAuthor = mysqli_fetch_assoc($resultAuthor)) {
                $avatarStatus = $rowAuthor["aStatus"];
                $avatarID = $rowAuthor["uID"];
                $avatarType = $rowAuthor["aType"];

              }
              echo '
                <div class="row">
                  <div class="commentBody">
                    <div class="authorProfile">
                      <p class="commentDate">'.date("Y.m.d.", strtotime($commentDate)).'<br>'.date("H:i", strtotime($commentDate)).'</p>
                      ';
                      if ($avatarStatus == 0) {
                        echo '
                        <img src="../img/avatars/profile'.$avatarID.'.'.$avatarType.'">
                        ';
                      } else {
                        echo '
                        <img src="../img/avatars/default.png">
                        ';
                      }
                      echo '
                      <p class="authorName">'.$commentAuthorName.'</p>
                      <form action="../subpages/user.php?id='.$commentAuthorID.'&page=pdata" method="post">
                        <button type="submit">Profile page</button>
                      </form>
                      <form action="../subpages/messages?page=write&to='.$commentAuthorName.'" method="post">
                        <button type="submit">Private message</button>
                      </form>
                    </div>
                    <div class="commentText">
                      '.$commentText.'
                    </div>
                  </div>
                </div>
              ';
            }
            ?>
        </div>
        <div class="pageManager nTwo">
          <ul class="pagination">
              <li  class="tooltip"><span>Last page</span><a href="<?php echo '?nid='.$_GET["nid"].'&pageno='.$total_pages; ?>"><i class="fas fa-angle-double-right"></i></a></li>
              <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> tooltip">
                  <span>Next page</span>
                  <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?nid=".$_GET['nid']."&pageno=".($pageno + 1); } ?>"><i class="fas fa-angle-right"></i></a>
              </li>
              <?php
                if ($total_pages == 1) {
                  echo '
                    <li class="active">
                      <a href="#">'.($pageno).'</a>
                    </li>
                  ';
                } else if ($total_pages == 2) {
                  if ($pageno == 1) {
                    echo '
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno + 1).'">'.($pageno + 1).'</a>
                      </li>
                      <li class="active">
                        <a href="#">'.($pageno).'</a>
                      </li>
                    ';
                  } else if ($pageno == 2) {
                    echo '
                      <li class="active">
                        <a href="#">'.($pageno).'</a>
                      </li>
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno - 1).'">'.($pageno - 1).'</a>
                      </li>
                    ';
                  }
                } else if ($total_pages >= 3) {
                  if ($pageno == $total_pages) {
                    echo '
                      <li class="active">
                        <a href="#">'.($pageno).'</a>
                      </li>
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno - 1).'">'.($pageno - 1).'</a>
                      </li>
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno - 2).'">'.($pageno - 2).'</a>
                      </li>
                    ';
                  } else if ($pageno > 1 && $pageno < $total_pages) {
                    echo '
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno + 1).'">'.($pageno + 1).'</a>
                      </li>
                      <li class="active">
                        <a href="#">'.($pageno).'</a>
                      </li>
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno - 1).'">'.($pageno - 1).'</a>
                      </li>
                    ';
                  }  else if ($pageno == 1) {
                    echo '
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno + 2).'">'.($pageno + 2).'</a>
                      </li>
                      <li>
                        <a href="?nid='.$_GET["nid"].'&pageno='.($pageno + 1).'">'.($pageno + 1).'</a>
                      </li>
                      <li class="active">
                        <a href="#">'.($pageno).'</a>
                      </li>
                    ';
                  }
                }
              ?>
              <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?> tooltip">
                  <span>Previous page</span>
                  <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?nid=".$_GET['nid']."&pageno=".($pageno - 1); } ?>"><i class="fas fa-angle-left"></i></a>
              </li>
              <li class="tooltip"><span>First page</span><a href="<?php echo "?nid=".$_GET['nid']."&pageno=1"; ?>"><i class="fas fa-angle-double-left"></i></a></li>
          </ul>
        </div>
        <div class="writeComment">
          <div class="header">
            <h2>Write comment for the news: <span><?php echo $newsTitle; ?></span></h2>
          </div>
          <div class="body">
            <form action="../includes/writecomment.inc.php" method="post">
              <textarea name="writecomment-Text" id="editor1" rows="10" cols="80"></textarea>
              <button type="submit" name="submit-Writecomment" value="<?php echo $_GET["nid"]; ?>">Write new comment</button>
            </form>
          </div>
        </div>
      </div>
    </main>
    <script>
      function showFeaturedDate() {
        var x = document.getElementById("featuredDate");
        x.style.display = "block";
      }
      function hideFeaturedDate() {
        var x = document.getElementById("featuredDate");
        x.style.display = "none";
      }

      CKEDITOR.replace( 'writecomment-Text' );

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

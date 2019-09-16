<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>OldenErwanin's website - Settings page</title>
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
      require "../header.php";
      if (!isset($_SESSION["uID"]) || $_GET["id"] != $_SESSION["uID"]) {
        exit();
      }
      if (isset($_GET["nid"]) && $_SESSION["uAdmin"] > 0) {
        echo '
          <section id="aPageConfirmNewsDelete">
            <div class="container">
              <p>Are you sure, that you want to delete the news with the ID: '.$_GET["nid"].'</p>
              <form class="yes" action="../includes/deletenews.inc.php" method="post">
                <button type="submit" name="submit-DeleteNews" value="'.$_GET["nid"].'">Yes</button>
              </form>
              <form class="no" action="../subpages/settings.php?id='.$_SESSION["uID"].'&page=news" method="post">
                <button type="submit">No</button>
              </form>
            </div>
          </section>
        ';
      } else if (isset($_GET["cid"]) && $_SESSION["uAdmin"] > 0) {
        echo '
          <section id="aPageConfirmCategoryDelete">
            <div class="container">
              <p>Are you sure, that you want to delete the category with the ID: '.$_GET["cid"].'</p>
              <form class="yes" action="../includes/deletecategory.inc.php" method="post">
                <button type="submit" name="submit-DeleteCategory" value="'.$_GET["cid"].'">Yes</button>
              </form>
              <form class="no" action="../subpages/settings.php?id='.$_SESSION["uID"].'&page=categories" method="post">
                <button type="submit">No</button>
              </form>
            </div>
          </section>
        ';
      }
    ?>
    <main class="settingsPage">
      <div class="wrapper">
        <?php
        require '../includes/database.inc.php';
        $sql = "SELECT * FROM users WHERE uID = ".$_GET['id'];
        $rs = $conn->query($sql);
        $uName = $rs->fetch_assoc()['uName'];
        ?>
        <div class="block-title">Profile settings</div>

        <?php
          if ($_GET["page"] == "main") {
            echo '
              <section class="settings-Main">
                <div class="row personal">
                  <div class="title">
                    <h1>Personal settings</h1>
                  </div>
                  <div class="buttons">
                    <form class="tooltip" action="../subpages/settings.php?id='.$_SESSION["uID"].'&page=pdata" method="post">
                      <input type="image" src="../img/icons/settings/personal-data.png">
                      <span>Personal data</span>
                    </form>
                    <form class="tooltip" action="../subpages/settings.php?id='.$_SESSION["uID"].'&page=changepwd" method="post">
                      <input type="image" src="../img/icons/settings/change-password.png">
                      <span>Change password</span>
                    </form>
                    <form class="tooltip" action="" method="post">
                      <input type="image" src="../img/icons/settings/change-email.png">
                      <span>Change e-mail</span>
                    </form>
                    <form class="tooltip" action="../subpages/settings.php?id='.$_SESSION["uID"].'&page=changeavatar" method="post">
                      <input type="image" src="../img/icons/settings/change-avatar.png">
                      <span>Change avatar</span>
                    </form>
                    <form class="tooltip" action="../subpages/settings.php?id='.$_SESSION["uID"].'&page=changeintro" method="post">
                      <input type="image" src="../img/icons/settings/edit-introduction.png">
                      <span>Edit introduction</span>
                    </form>
                  </div>
                </div>
                <div class="row lists">
                  <div class="title">
                    <h1>General lists</h1>
                  </div>
                  <div class="buttons">
                    <form class="tooltip" action="" method="post">
                      <input type="image" src="../img/icons/settings/users.png">
                      <span>Registered users</span>
                    </form>
                    <form class="tooltip" action="" method="post">
                      <input type="image" src="../img/icons/settings/blacklist.png">
                      <span>Blacklisted users</span>
                    </form>
                    <form class="tooltip" action="" method="post">
                      <input type="image" src="../img/icons/settings/achivements.png">
                      <span>All achivements</span>
                    </form>
                    <form class="tooltip" action="" method="post">
                      <input type="image" src="../img/icons/settings/statistics.png">
                      <span>Website statictics</span>
                    </form>
                  </div>
                </div>
                ';
                if ($_SESSION["uAdmin"] > 0) {
                  echo '
                    <div class="row admin">
                      <div class="title">
                        <h1>Admin settings</h1>
                      </div>
                      <div class="buttons">
                        <form class="tooltip" action="" method="post">
                          <input type="image" src="../img/icons/settings/admin-manageadmin.png">
                          <span>Manage admins</span>
                        </form>
                        <form class="tooltip" action="" method="post">
                          <input type="image" src="../img/icons/settings/admin-removeuser.png">
                          <span>Delete user</span>
                        </form>
                        <form class="tooltip" action="../subpages/settings.php?id='.$_SESSION["uID"].'&page=news" method="post">
                          <input type="image" src="../img/icons/settings/admin-news.png">
                          <span>Manage news</span>
                        </form>
                        <form class="tooltip" action="../subpages/settings.php?id='.$_SESSION["uID"].'&page=categories" method="post">
                          <input type="image" src="../img/icons/settings/admin-category.png">
                          <span>Manage news categories</span>
                        </form>
                      </div>
                    </div>
                  ';
                }
                echo '
                <div class="row delete">
                  <div class="title">
                    <h1>Delete account</h1>
                  </div>
                  <div class="buttons">
                    <form class="tooltip" action="" method="post">
                      <input type="image" src="../img/icons/settings/delete.png">
                      <span>Delete account request</span>
                    </form>
                  </div>
                </div>
              </section>
            ';
          } else if ($_GET["id"] == $_SESSION["uID"] && $_GET["page"] == "pdata") {
            echo '
              <section class="settings-Personal">
                <a class="btn-back" href="../subpages/settings.php?id='.$_SESSION["uID"].'&page=main"><img src="../img/icons/settings/back.png"></a>
                <div class="title">
                  <h1>Personal settings</h1>
                </div>
              </section>
            ';
          } else if ($_GET["id"] == $_SESSION["uID"] && $_GET["page"] == "changepwd") {
            echo '
              <section class="settings-ChangePwd">
                <a class="btn-back" href="../subpages/settings.php?id='.$_SESSION["uID"].'&page=main"><img src="../img/icons/settings/back.png"></a>
                <div class="title">
                  <h1>Change password</h1>
                </div>
                <form action="../includes/changepwd.inc.php" method="post">
                  <input name="changepwd-original" class="original" type="password" placeholder="Current password">
                  <input name="changepwd-new" class="new" type="password" placeholder="New password">
                  <input name="changepwd-new2" class="new" type="password" placeholder="New password again">
                  <button name="submit-Changepwd"type="submit">Change</button>
                </form>
              </section>
            ';
          } else if ($_GET["id"] == $_SESSION["uID"] && $_GET["page"] == "changeavatar") {
            echo '
              <section class="settings-ChangeAvatar">
                <a class="btn-back" href="../subpages/settings.php?id='.$_SESSION["uID"].'&page=main"><img src="../img/icons/settings/back.png"></a>
                <div class="title">
                  <h1>Upload new avatar picture</h1>
                </div>
                <form action="../includes/changeavatar.inc.php" method="post" enctype="multipart/form-data">
                  ';
                  if ($_SESSION["aStatus"] == 0) {
                    $aSize =  $_SESSION["aSize"] / 1024;
                    echo '
                      <img class="currAvatar" src="../img/avatars/profile'.$_SESSION["uID"].'.'.$_SESSION["aType"].'?'.mt_rand().'" alt="Avatar"><br>
                      <div class="row">
                        <p class="text">File size</p>
                        <p class="data">'.round($aSize).' Kb</p>
                      </div><br>
                      <div class="row">
                        <p class="text">File type</p>
                        <p class="data">.'.$_SESSION["aType"].'</p>
                      </div><br>
                      <div class="row">
                        <p class="text">File added</p>
                        <p class="data">'.date("Y.m.d", strtotime($_SESSION["aAdded"])).'</p>
                      </div>
                    ';
                  } else if ($_SESSION["aStatus"] == 1) {
                    echo '<img class="currAvatar" src="../img/avatars/default.png?'.mt_rand().'" alt="Avatar"><br><p>Default</p>';
                  }
                  echo '
                  <input name="changeavatar-pic" type="file">
                  <button name="submit-Changeavatar"type="submit">Upload</button>
                </form>
              </section>
            ';
          } else if ($_GET["id"] == $_SESSION["uID"] && $_GET["page"] == "changeintro") {
            echo '
              <section class="settings-ChangeIntroduction">
                <a class="btn-back" href="../subpages/settings.php?id='.$_SESSION["uID"].'&page=main"><img src="../img/icons/settings/back.png"></a>
                <div class="title">
                  <h1>Change profile introduction</h1>
                </div>
                <form action="../includes/changeintroduction.inc.php" method="post" enctype="multipart/form-data">

                ';
                  $sqlIntro = "SELECT * FROM users WHERE uID=".$_SESSION["uID"];
                  $resultIntro = mysqli_query($conn, $sqlIntro);
                  while ($rowIntro = mysqli_fetch_assoc($resultIntro)) {
                    $introTitle = $rowIntro["uIntroductionTitle"];
                    $introText = $rowIntro["uIntroductionText"];
                  }

                echo '
                  <input name="changeintro-Title" type="text" value="'.$introTitle.'">
                  <textarea name="changeintro-Text">'.$introText.'</textarea>
                  <button name="submit-Changeintroduction"type="submit">Save changes</button>
                </form>
              </section>
            ';
          } else if ($_SESSION["uAdmin"] > 0 && $_GET["id"] == $_SESSION["uID"] && $_GET["page"] == "news") {
            echo '
              <section class="settings-ManageNews">
                <a class="btn-back" href="../subpages/settings.php?id='.$_SESSION["uID"].'&page=main"><img src="../img/icons/settings/back.png"></a>
                <div class="title">

                  <h1>Manage news</h1>
                </div>
                <a class="btn-add" href="../subpages/writenews.php"><img src="../img/icons/settings/add.png"></a>
                <div class="table">
                  <div class="header">
                    <div class="column Cid"><p>ID</p></div>
                    <div class="column Ctitle"><p>Title</p></div>
                    <div class="column Ccategory"><p>Category</p></div>
                    <div class="column Cauthor"><p>Author</p></div>
                    <div class="column Cadded"><p>Added</p></div>
                    <div class="column Cfeatured"><p>Featured</p></div>
                    <div class="column Cmanage"><p>Manage</p></div>
                  </div>
                  ';
                  $sqlNews = "SELECT * FROM news ORDER BY nID DESC";
                  $resultNews = mysqli_query($conn, $sqlNews);
                  while ($rowNews = mysqli_fetch_assoc($resultNews)) {
                    $sqlCategory = "SELECT * FROM categories WHERE cID=".$rowNews["cID"];
                    $resultCategory = mysqli_query($conn, $sqlCategory);
                    while ($rowCategory = mysqli_fetch_assoc($resultCategory)) {
                      $cName = $rowCategory["cName"];
                    }
                    $featured = "No";
                    if ($rowNews["nFeatured"] == 1) {
                      $featured = $rowNews["nFeaturedDate"];
                    }

                    if ($rowNews["nHide"] == 0) {
                      echo '
                        <div class="row">
                          <div class="column Cid"><p>'.$rowNews["nID"].'</p></div>
                          <div class="column Ctitle"><p>'.$rowNews["nTitle"].'</p></div>
                          <div class="column Ccategory"><p>'.$cName.'</p></div>
                          <div class="column Cauthor"><p>'.$rowNews["nAuthor"].'</p></div>
                          <div class="column Cadded"><p>'.$rowNews["nDate"].'</p></div>
                          <div class="column Cfeatured"><p>'.$featured.'</p></div>
                          <div class="column Cmanage">
                            <form action="../subpages/settings.php?id='.$_SESSION["uID"].'&page=news&nid='.$rowNews["nID"].'" method="post">
                              <button type="submit" name="submit-DeleteNews">Delete |</button>
                            </form>
                            <form action="../subpages/editnews.php?nid='.$rowNews["nID"].'" method="post">
                              <button type="submit" name="submit-EditNews">Edit |</button>
                            </form>
                            <form action="../includes/hidenews.inc.php" method="post">
                              <button type="submit" name="submit-HideNews" value="'.$rowNews["nID"].'">Hide</button>
                            </form>
                          </div>
                        </div>
                      ';
                    } else {
                      echo '
                        <div class="rowHided">
                          <div class="column Cid"><p>'.$rowNews["nID"].'</p></div>
                          <div class="column Ctitle"><p>'.$rowNews["nTitle"].'</p></div>
                          <div class="column Ccategory"><p>'.$cName.'</p></div>
                          <div class="column Cauthor"><p>'.$rowNews["nAuthor"].'</p></div>
                          <div class="column Cadded"><p>'.$rowNews["nDate"].'</p></div>
                          <div class="column Cfeatured"><p>'.$featured.'</p></div>
                          <div class="column Cmanage">
                            <form action="../subpages/settings.php?id='.$_SESSION["uID"].'&page=news&nid='.$rowNews["nID"].'" method="post">
                              <button type="submit" name="submit-DeleteNews">Delete |</button>
                            </form>
                            <form action="../subpages/editnews.php?nid='.$rowNews["nID"].'" method="post">
                              <button type="submit" name="submit-EditNews">Edit |</button>
                            </form>
                            <form action="../includes/hidenews.inc.php" method="post">
                              <button type="submit" name="submit-ShowNews" value="'.$rowNews["nID"].'">Show</button>
                            </form>
                          </div>
                        </div>
                      ';
                    }
                  }

                  echo '
                    </div>
                  </section>
                ';
          }  else if ($_SESSION["uAdmin"] > 0 && $_GET["id"] == $_SESSION["uID"] && $_GET["page"] == "categories") {
            echo '
              <section class="settings-ManageCategories">
                <a class="btn-back" href="../subpages/settings.php?id='.$_SESSION["uID"].'&page=main"><img src="../img/icons/settings/back.png"></a>
                <div class="title">

                  <h1>Manage news categories</h1>
                </div>
                <a class="btn-add" href="../subpages/addcategory.php"><img src="../img/icons/settings/add.png"></a>
                <div class="table">
                  <div class="header">
                    <div class="column Cid"><p>ID</p></div>
                    <div class="column Cpicture"><p>Picture</p></div>
                    <div class="column Cname"><p>Name</p></div>
                    <div class="column Cmanage"><p>Manage</p></div>
                  </div>
                  ';
                  $sqlCategory = "SELECT * FROM categories ORDER BY cID DESC";
                  $resultCategory = mysqli_query($conn, $sqlCategory);
                  while ($rowCategory = mysqli_fetch_assoc($resultCategory)) {
                    echo '
                      <div class="row">
                        <div class="column Cid"><p>'.$rowCategory["cID"].'</p></div>
                        <div class="column Cpicture tooltip"><span><img style="width: 80px;" src="../img/categories/'.$rowCategory["cPicName"].'.'.$rowCategory["cPicType"].'"></span><p class="hoverme">Hover me</p></div>
                        <div class="column Cname"><p>'.$rowCategory["cName"].'</p></div>
                        <div class="column Cmanage">
                          <a href="../subpages/settings.php?id='.$_SESSION["uID"].'&page=categories&cid='.$rowCategory["cID"].'">Delete</a> |
                          <a href="../subpages/editcategory.php?id='.$_SESSION["uID"].'&page=categories&cid='.$rowCategory["cID"].'">Edit</a>
                        </div>
                      </div>
                    ';
                  }

                  echo '
                    </div>
                  </section>
                ';
          }
        ?>
      </div>
    </main>
    <script>
      CKEDITOR.replace( 'changeintro-Text');

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

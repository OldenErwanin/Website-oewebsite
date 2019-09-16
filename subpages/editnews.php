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
      require '../includes/database.inc.php';
      require "../header.php";
      if ($_SESSION["uAdmin"] < 1) {
        exit();
      }
      $sqlEdit = "SELECT * FROM news WHERE nID=".$_GET["nid"];
      $resultEdit = mysqli_query($conn, $sqlEdit);
      while ($row = mysqli_fetch_assoc($resultEdit)) {
        $nID = $row["nID"];
        $nTitle = $row["nTitle"];
        $cID = $row["cID"];
        $nText = $row["nText"];
        $nFeatured = $row["nFeatured"];
        $nFeaturedDate = $row["nFeaturedDate"];
        $nEnableComm = $row["nEnableComm"];
        $nHide = $row["nHide"];
        $nDate = $row["nDate"];
      }

      $sqlC = "SELECT * FROM categories WHERE cID=".$cID;
      $resultC = mysqli_query($conn, $sqlC);
      while ($rowC = mysqli_fetch_assoc($resultC)) {
        $cPicName = $rowC["cPicName"];
        $cPicType = $rowC["cPicType"];
      }
    ?>
    <main class="editnewsPage">
      <div class="wrapper">
        <h1 class="block-title">Edit news</h1>
        <div class="container">
          <form action="../includes/editnews.inc.php" method="post">
            <section class="news-main">
              <article class="news-body">
                  <div class="bg">
                      <div class="data">
                          <table>
                              <tr>
                                  <td class="left">
                                      <img class="tumblr" src="../img/categories/<?php echo $cPicName.'.'.$cPicType; ?>" alt="Category picture">
                                      <h2><input type="text" name="editnews-Title" value="<?php echo $nTitle; ?>"></h2>
                                      <h3>
                                        <span class="category">Category:</span>
                                        <select name="editnews-Category">
                                          <?php
                                            $sqlCategory = "SELECT * FROM categories";
                                            $resultCategory = mysqli_query($conn, $sqlCategory);
                                            while ($rowCategory = mysqli_fetch_assoc($resultCategory)) {
                                              if ($rowCategory["cID"] == $cID) {
                                                echo '
                                                  <option value="'.$rowCategory["cID"].'" selected>'.$rowCategory["cName"].'</option>
                                                ';
                                              } else {
                                                echo '
                                                  <option value="'.$rowCategory["cID"].'">'.$rowCategory["cName"].'</option>
                                                ';
                                              }
                                            }
                                          ?>
                                        </select>
                                      </h3>
                                  </td>
                                  <td class="right">
                                      <span class="other"><?php echo date("m. d.", strtotime($nDate)); ?></span>
                                      <span class="year"><?php echo date("Y", strtotime($nDate)); ?></span><br>
                                  </td>
                              </tr>
                          </table>
                      </div>
                      <div class="text">
                          <textarea name="editnews-Text" id="editor1" rows="10" cols="80">
                            <?php echo $nText; ?>
                          </textarea>
                      </div>
                  </div>
              </article>
            </section>
            <table>
              <tr>
                <td class="title">
                  <label>Featured:</label>
                </td>
                <td class="text"><label>Yes</label></td>
                <td class="data">
                  <input <?php if ($nFeatured == 1) { echo 'checked="checked"'; } ?> type="radio" name="editnews-Featured" value="1" onclick="showeFeaturedDate()">
                </td>
                <td class="text"><label>No</label></td>
                <td class="data">
                  <input <?php if ($nFeatured == 0) { echo 'checked="checked"'; } ?> type="radio" name="editnews-Featured" value="0" onclick="hideeFeaturedDate()">
                </td>
              </tr>
            </table>
            <input <?php if ($nFeatured == 1) { echo 'style="display:block;" value="'.date("Y-m-d", strtotime($nFeaturedDate)).'"'; } ?> type="date" id="efeaturedDate" min="<?php $date = date('Y-m-d', strtotime("+1 day")); echo $date; ?>" name="editnews-FeaturedDate" >
            <br><table>
              <tr>
                <td class="title">
                  <label>Enable comments:</label>
                </td>
                <td class="text"><label>Yes</label></td>
                <td class="data">
                  <input <?php if ($nEnableComm == 1) { echo 'checked="checked"'; } ?> type="radio" name="editnews-Comments" value="1">
                </td>
                <td class="text"><label>No</label></td>
                <td class="data">
                  <input <?php if ($nEnableComm == 0) { echo 'checked="checked"'; } ?> type="radio" name="editnews-Comments" value="0">
                </td>
              </tr>
            </table>
            <br><table>
              <tr>
                <td class="title">
                  <label>Hide news:</label>
                </td>
                <td class="text"><label>Yes</label></td>
                <td class="data">
                  <input <?php if ($nHide == 1) { echo 'checked="checked"'; } ?> type="radio" name="editnews-Hide" value="1">
                </td>
                <td class="text"><label>No</label></td>
                <td class="data">
                  <input <?php if ($nHide == 0) { echo 'checked="checked"'; } ?> type="radio" name="editnews-Hide" value="0">
                </td>
              </tr>
            </table>
            <button type="submit" name="submit-Editnews" value="<?php echo $nID; ?>">Done</button>
          </form>
        </div>
      </div>
    </main>
    <script>
      function showeFeaturedDate() {
        var x = document.getElementById("efeaturedDate");
        x.style.display = "block";
      }
      function hideeFeaturedDate() {
        var x = document.getElementById("efeaturedDate");
        x.style.display = "none";
      }

    CKEDITOR.replace( 'editnews-Text');

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

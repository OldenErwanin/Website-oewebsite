<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>OldenErwanin's website - Write news page</title>
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
    ?>
    <main class="writenewsPage">
      <div class="wrapper">
        <h1 class="block-title">Write news</h1>
        <div class="container">
          <!--<div class="editorButtons">
            <input type="image" src="../img/icons/editor/left-align.png" onclick="insertSurround('editor', '[left]', '[/left]');return false;">
            <input type="image" src="../img/icons/editor/right-align.png" onclick="insertSurround('editor', '[right]', '[/right]');return false;">
            <input type="image" src="../img/icons/editor/center-align.png" onclick="insertSurround('editor', '[center]', '[/center]');return false;">
            <input type="image" src="../img/icons/editor/justify.png" onclick="insertSurround('editor', '[justify]', '[/justify]');return false;">
            <input type="image" src="../img/icons/editor/bold.png" onclick="insertSurround('editor', '<b>', '</b>');return false;">
            <input type="image" src="../img/icons/editor/italic.png" onclick="insertSurround('editor', '<i>', '</i>');return false;">
            <input type="image" src="../img/icons/editor/underline.png" onclick="insertSurround('editor', '<u>', '</u>');return false;">
            <input type="image" src="../img/icons/editor/strikethrough.png" onclick="insertSurround('editor', '<strike>', '</strike>');return false;">

            <input type="image" src="../img/icons/editor/font.png" onclick="insertSurround('editor', '[b]', '[/b]');return false;">
            <input type="image" src="../img/icons/editor/color.png" onclick="insertSurround('editor', '[b]', '[/b]');return false;">
            <input type="image" src="../img/icons/editor/text-height.png" onclick="insertSurround('editor', '[b]', '[/b]');return false;">

            <input type="image" src="../img/icons/editor/list.png" onclick="insertSurround('editor', '[b]', '[/b]');return false;">
            <input type="image" src="../img/icons/editor/link.png" onclick="insertSurround('editor', '[b]', '[/b]');return false;">
            <input type="image" src="../img/icons/editor/file.png" onclick="insertSurround('editor', '[b]', '[/b]');return false;">
          </div>-->
          <form action="../includes/writenews.inc.php" method="post">
            <section class="news-main">
              <article class="news-body">
                  <div class="bg">
                      <div class="data">
                          <table>
                              <tr>
                                  <td class="left">


                                      <img class="tumblr" src="../img/categories/default.png" alt="Category picture">
                                      <h2><input type="text" name="news-Title" placeholder="News title"></h2>
                                      <h3>
                                        <span class="category">Category:</span>
                                        <select name="news-Category">
                                          <?php
                                            $sqlCategory = "SELECT * FROM categories";
                                            $resultCategory = mysqli_query($conn, $sqlCategory);
                                            while ($rowCategory = mysqli_fetch_assoc($resultCategory)) {
                                              echo '
                                                <option value="'.$rowCategory["cID"].'">'.$rowCategory["cName"].'</option>
                                              ';
                                            }
                                          ?>
                                        </select>
                                      </h3>
                                  </td>
                                  <td class="right">
                                      <span class="other"><?php echo date("m. d."); ?></span>
                                      <span class="year"><?php echo date("Y"); ?></span><br>
                                  </td>
                              </tr>
                          </table>
                      </div>
                      <div class="text">
                          <textarea name="news-Text" id="editor1" rows="10" cols="80"></textarea>
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
                  <input type="radio" name="news-Featured" value="1" onclick="showFeaturedDate()">
                </td>
                <td class="text"><label>No</label></td>
                <td class="data">
                  <input checked="checked" type="radio" name="news-Featured" value="0" onclick="hideFeaturedDate()">
                </td>
              </tr>
            </table>
            <input type="date" id="featuredDate" min="<?php $date = date('Y-m-d', strtotime("+1 day")); echo $date; ?>" name="news-FeaturedDate" >
            <br><table>
              <tr>
                <td class="title">
                  <label>Enable comments:</label>
                </td>
                <td class="text"><label>Yes</label></td>
                <td class="data">
                  <input checked="checked" type="radio" name="news-Comments" value="1">
                </td>
                <td class="text"><label>No</label></td>
                <td class="data">
                  <input type="radio" name="news-Comments" value="0">
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
                  <input type="radio" name="news-Hide" value="1">
                </td>
                <td class="text"><label>No</label></td>
                <td class="data">
                  <input checked="checked" type="radio" name="news-Hide" value="0">
                </td>
              </tr>
            </table>
            <button type="submit" name="submit-Writenews">Done</button>
          </form>
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



    CKEDITOR.replace( 'news-Text' );

    function insertSurround(areaId, text1, text2) {
      var txtarea = document.getElementById(areaId);
      if (!txtarea) {
        return;
      }

      var scrollPos = txtarea.scrollTop;
      var strPos = 0;
      var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
        "ff" : (document.selection ? "ie" : false));
      if (br == "ie") {
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart('character', -txtarea.value.length);
        strPos = range.text.length;
      } else if (br == "ff") {
        strPos = txtarea.selectionStart;
      }

      var selectedText = '';
      if (window.getSelection) {
        selectedText = window.getSelection();
      }
      // document.getSelection
      else if (document.getSelection) {
          selectedText = document.getSelection();
      }
      // document.selection
      else if (document.selection) {
          selectedText =
          document.selection.createRange().text;
      } else return;

      var front = (txtarea.value).substring(0, strPos);
      var back = (txtarea.value).substring(strPos, txtarea.value.length - selectedText);

      txtarea.value = front + text1 + selectedText + text2 + back;
      strPos = strPos + text1.length;

      if (br == "ie") {
        txtarea.focus();
        var ieRange = document.selection.createRange();
        ieRange.moveStart('character', -txtarea.value.length);
        ieRange.moveStart('character', strPos);
        ieRange.moveEnd('character', 0);
        ieRange.select();
      } else if (br == "ff") {
        txtarea.selectionStart = strPos;
        txtarea.selectionEnd = strPos;
        txtarea.focus();
      }

      txtarea.scrollTop = scrollPos;
    }

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

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OldenErwanin's website</title>
    <meta name="description" content="OldenErwanin website">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900|Cormorant+Garamond:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <?php
    require "header.php";
    ?>
    <div class="wrapper">
        <!--<section class="slider">
            <div class="w3-content w3-display-container">
                <img class="mySlides" src="https://images.pexels.com/photos/67636/rose-blue-flower-rose-blooms-67636.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" style="width:100%">
                <img class="mySlides" src="https://cdn.pixabay.com/photo/2017/02/08/17/24/butterfly-2049567__340.jpg" style="width:100%">
                <img class="mySlides" src="https://cdn.pixabay.com/photo/2015/12/01/20/28/road-1072823__340.jpg" style="width:100%">
                <img class="mySlides" src="https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" style="width:100%">
            </div>
        </section>-->
        <main>
            <h1 class="block-title">Latest news</h1>
            <section class="news-main">
                <?php
                require 'includes/database.inc.php';
                $sqlFeatured = "SELECT * FROM news WHERE nHide = 0 AND nFeaturedDate > NOW() AND nFeatured = 1 ORDER BY nID DESC";
                $resultFeatured = mysqli_query($conn, $sqlFeatured);
                while ($rowFeatured = mysqli_fetch_assoc($resultFeatured)) {
                    $sqlCategory = "SELECT * FROM categories WHERE cID=" . $rowFeatured["cID"];
                    $resultCategory = mysqli_query($conn, $sqlCategory);
                    while ($rowCategory = mysqli_fetch_assoc($resultCategory)) {
                        $cName = $rowCategory["cName"];
                        $cPicName = $rowCategory["cPicName"];
                        $cPicType = $rowCategory["cPicType"];
                    }
                    echo '
                        <article class="news-body">
                            <div class="bg">
                                <div class="data">
                                    <table>
                                        <tr>
                                            <td class="left">
                                                <img class="tumblr" src="../img/categories/' . $cPicName . '.' . $cPicType . '" alt="Category picture">
                                                <h2>' . $rowFeatured["nTitle"] . '</h2>
                                                <h3><span class="category">Category:</span> ' . $cName . '</h3>
                                            </td>
                                            <td class="right">
                                                <span class="featured">FEATURED</span><br>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="text">
                                    ' . $rowFeatured["nText"] . '
                                </div>
                            </div>
                            <div class="buttons">
                                                ';
                    if ($rowFeatured["nEnableComm"] == 0 || !isset($_SESSION["uID"])) {
                        echo '
                            <button class="continue" disabled>Continue</button>
                        ';
                    } else {
                        echo '
                            <form action="../subpages/viewcomment.php?nid=' . $rowFeatured["nID"] . '&pageno=1" method="post">
                            <button class="continue" type="submit" name="viewCommentButton">Continue</button>
                            </form>
                        ';
                    }
                    echo '
                        <span class="comments">' . $rowFeatured["commentCount"] . ' comments</span>
                        <span class="views">' . $rowFeatured["viewCount"] . ' views</span>
                    ';
                    if (isset($_SESSION["uID"])) {
                        echo '
                            <span class="author">Author: <a href="../subpages/user.php?id=' . $rowFeatured["nAuthorID"] . '&page=pdata">' . $rowFeatured["nAuthor"] . '</a></span>
                        ';
                    } else {
                        echo '
                            <span class="author">Author: ' . $rowFeatured["nAuthor"] . '</a></span>
                        ';
                    }
                    echo '
                            </div>
                        </article>
                    ';
                }

                $sqlSimple = "SELECT * FROM news WHERE nHide = 0 AND nFeaturedDate < NOW() ORDER BY nID DESC";
                $resultSimple = mysqli_query($conn, $sqlSimple);
                while ($rowSimple = mysqli_fetch_assoc($resultSimple)) {
                    $sqlCategory = "SELECT * FROM categories WHERE cID=" . $rowSimple["cID"];
                    $resultCategory = mysqli_query($conn, $sqlCategory);
                    while ($rowCategory = mysqli_fetch_assoc($resultCategory)) {
                        $cName = $rowCategory["cName"];
                        $cPicName = $rowCategory["cPicName"];
                        $cPicType = $rowCategory["cPicType"];
                    }
                    echo '
                        <article class="news-body">
                            <div class="bg">
                                <div class="data">
                                    <table>
                                        <tr>
                                            <td class="left">
                                                <img class="tumblr" src="../img/categories/' . $cPicName . '.' . $cPicType . '" alt="Category picture">
                                                <h2>' . $rowSimple["nTitle"] . '</h2>
                                                <h3><span class="category">Category:</span> ' . $cName . '</h3>
                                            </td>
                                            <td class="right">
                                                <span class="other">' . date("m. d.", strtotime($rowSimple["nDate"])) . '</span>
                                                <span class="year">' . date("Y", strtotime($rowSimple["nDate"])) . '</span><br>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="text">
                                    ' . $rowSimple["nText"] . '
                                </div>
                            </div>
                            <div class="buttons">
                                ';
                    if ($rowSimple["nEnableComm"] == 0 || !isset($_SESSION["uID"])) {
                        echo '
                                    <button class="continue" disabled>Continue</button>
                                  ';
                    } else {
                        echo '
                                    <form action="../subpages/viewcomment.php?nid=' . $rowSimple["nID"] . '&pageno=1" method="post">
                                      <button class="continue" type="submit" name="viewCommentButton">Continue</button>
                                    </form>
                                  ';
                    }
                    echo '
                                <span class="comments">' . $rowSimple["commentCount"] . ' comments</span>
                                <span class="views">' . $rowSimple["viewCount"] . ' views</span>
                                ';
                    if (isset($_SESSION["uID"])) {
                        echo '
                                  <span class="author">Author: <a href="../subpages/user.php?id=' . $rowSimple["nAuthorID"] . '&page=pdata">' . $rowSimple["nAuthor"] . '</a></span>
                                  ';
                    } else {
                        echo '
                                    <span class="author">Author: ' . $rowSimple["nAuthor"] . '</a></span>
                                  ';
                    }
                    echo '
                            </div>
                        </article>
                    ';
                }
                ?>
            </section>
        </main>
    </div>

    <script>
        var slideIndex = 0;
        carousel();

        function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlides");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > x.length) {
                slideIndex = 1
            }
            x[slideIndex - 1].style.display = "block";
            setTimeout(carousel, 5000);
        }
    </script>
</body>

</html>
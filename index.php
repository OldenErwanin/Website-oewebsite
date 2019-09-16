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
        <section class="slider">
            <div class="w3-content w3-display-container">
                <img class="mySlides" src="https://images.pexels.com/photos/67636/rose-blue-flower-rose-blooms-67636.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" style="width:100%">
                <img class="mySlides" src="https://cdn.pixabay.com/photo/2017/02/08/17/24/butterfly-2049567__340.jpg" style="width:100%">
                <img class="mySlides" src="https://cdn.pixabay.com/photo/2015/12/01/20/28/road-1072823__340.jpg" style="width:100%">
                <img class="mySlides" src="https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" style="width:100%">
            </div>
        </section>
        <main class="index">
          <div class="header">
            <h1>Hi! My name is <span>OldenErwanin</span>.</h1>
          </div>
          <p>This is one of my portfolio websites. I'm still working on it, but there are some part of the website which is working. And these are:</p>
          <ul>
            <li>Account</li>
            <ul>
              <li>Can sign up to the website</li>
              <li>Sign in, logout</li>
              <li>Forgotten password</li>
              <li>Change password, avatar or introduction</li>
              <li>Check other users profile page</li>
            </ul>
            <li>Admin</li>
            <ul>
              <li>Manage the news</li>
              <li>Manage the news categories</li>
            </ul>
            <li>Messages</li>
            <ul>
              <li>Can send or recieve private messages</li>
            </ul>
            <li>Friends</li>
            <ul>
              <li>Can send friend requests to users</li>
              <li>Manage the friends</li>
            </ul>
            <li>News</li>
            <ul>
              <li>Write, edit or delete news as admin</li>
              <li>There are featured and simple news</li>
              <li>Dinamic categories for the news</li>
              <li>Can comment under the news(if it's not disabled)</li>
              <li>Pagination for the comments</li>
              <li>Count the views and comments</li>
            </ul>
          </ul>
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

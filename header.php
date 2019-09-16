<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OldenErwanin's website</title>
    <link rel="shortcut icon" type="image/png" href="/favicon.ico" />
    <meta name="description" content="OldenErwanin website">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900|Cormorant+Garamond:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <section id="aPageLogin">
        <input class="btn-Close" onclick="closePageLogin()" type="image" src="../img/icons/header/close.png">

        <form class="form-Signin" action="../includes/signin.inc.php" method="post">
            <label>Sign in here:</label>
            <input name="login-Uid" type="text" placeholder="Username">
            <input name="login-Pwd" type="password" placeholder="Password">
            <button name="submit-Login" type="submit"><img src="../img/icons/header/sign-in.png"></button>
        </form>
    </section>
    <section id="aPageForgottenPwd">
        <input class="btn-Close" onclick="closePageForgottenPwd()" type="image" src="../img/icons/header/close.png">

        <form class="form-ResetRequest" action="../includes/reset-request.inc.php" method="post">
            <label>Reset password:</label>
            <input name="request-Uid" type="email" placeholder="E-mail adress...">
            <p>We will send an email to the given adress with the instructions.</p>
            <button name="submit-Request" type="submit">Submit</button>
        </form>
    </section>
    <header>
        <div class='wrapper'>
            <section class="logo-container">
                <img class="logo" src="../img/logo.png" alt="">
                <h1 class="logo-title"><span style="color: #b6621f;">OldenErwanin</span>'s<br>website</h1>
            </section>
            <section class='account'>
                <?php
                if (isset($_SESSION["uID"])) {
                    if ($_SESSION["aStatus"] == 0) {
                        echo '<img class="avatar" src="../img/avatars/profile' . $_SESSION["uID"] . '.' . $_SESSION["aType"] . '?' . mt_rand() . '" alt="Avatar">';
                    } else if ($_SESSION["aStatus"] == 1) {
                        echo '<img class="avatar" src="../img/avatars/default.png" alt="Avatar">';
                    }
                    $con = mysqli_connect("localhost", "root", "", "website");
                    $sqlGotUnread = "SELECT * FROM messages WHERE mRead = 0 AND toDelete = 0 AND toID=" . $_SESSION["uID"];
                    $resultGotUnread = mysqli_query($con, $sqlGotUnread);
                    $numberGotUnread = mysqli_num_rows($resultGotUnread);
                    mysqli_close($con);
                    echo '
                    <table>
                      <tr><td>
                        <div class="info">
                            <p>Logged in as: <span class="uName">' . $_SESSION["uName"] . '</span></p>
                        </div><br>
                      </td></tr>
                      <tr><td>
                        <div class="buttons">
                          <form action="../subpages/messages.php?page=recieved" method="post">
                              ';
                    if ($numberGotUnread > 0) {
                        echo '<button class="tooltip" type="submit"><span>Messages</span><img src="../img/icons/header/messagegot.png"></button>';
                    } else {
                        echo '<button class="tooltip" type="submit"><span>Messages</span><img src="../img/icons/header/message.png"></button>';
                    }
                    echo '
                          </form>
                          <form action="../subpages/settings.php?id=' . $_SESSION["uID"] . '&page=main" method="post">
                              <button class="tooltip" type="submit"><span>Settings</span><img src="../img/icons/header/settings.png"></button>
                          </form>
                          <form action="../subpages/user.php?id=' . $_SESSION["uID"] . '&page=pdata" method="post">
                              <button class="tooltip" type="submit"><span>User profile</span><img src="../img/icons/header/profile.png"></button>
                          </form>
                          <form action="../subpages/friends.php?page=list" method="post">
                              <button class="tooltip" type="submit"><span>Friends</span><img src="../img/icons/header/friends.png"></button>
                          </form>
                          <form action="../includes/logout.inc.php" method="post">
                              <button name="submit-Logout" class="btn-logout tooltip" type="submit"><span>Logout</span><img src="../img/icons/header/logout.png"></button>
                          </form>
                        </div>
                      </td></tr>
                    </table>
                ';
                } else {
                    echo '
                      <form class="form-webLogin" action="javascript:togglePageLogin()">
                          <button type="submit">Sign in</button>
                      </form>
                      <form class="form-Login" action="header.php" method="post">
                    ';
                    if (isset($_GET["signup"])) {
                        if ($_GET["signup"] == "success") {
                            echo '<div class="successField"><p class="regSuccess">Successful registration!<br>Now you can sign in below.</p></div>';
                        }
                    }
                    echo '
                        <label>Sign in here:</label>
                        <input name="login-Uid" type="text" placeholder="Username">
                        <input name="login-Pwd" type="password" placeholder="Password">
                        <input name="submit-Login" type="image" src="../img/icons/header/sign-in.png">
                    </form>
                    <form class="form-ForgetPwd" action="javascript:togglePageForgottenPwd()" method="post">
                        <button type="submit">Forgotten password</button>
                    </form>
                    <form class="form-toSignup" action="../subpages/signup.php" method="post">
                        <button type="submit">Sign up</button>
                    </form>
                ';
                }
                ?>
            </section>

            <nav>
                <form action="news.php" method="post">
                    <input class="nav-home" type="image" src="../img/icons/header/home.png" alt="">
                </form>
                <input onclick="toggleMenu()" class="nav-toggle" type="image" src="../img/icons/header/list.png" alt="">

                <ul id="toggleMenu">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../news.php">News</a></li>
                    <li><a href="#">Menu element1</a></li>
                    <li><a href="#">Menu element2</a></li>
                    <li><a href="#">Menu element3</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="line"></div>
    <script>
        function toggleMenu() {
            var x = document.getElementById("toggleMenu");
            if (x.style.display === "block") {
                x.style.display = "none";
            } else {
                x.style.display = "block";
            }
        }

        function togglePageLogin() {
            var x = document.getElementById("aPageLogin");
            x.style.display = "block";
        }

        function closePageLogin() {
            var x = document.getElementById("aPageLogin");
            x.style.display = "none";
        }

        function togglePageForgottenPwd() {
            var x = document.getElementById("aPageForgottenPwd");
            x.style.display = "block";
        }

        function closePageForgottenPwd() {
            var x = document.getElementById("aPageForgottenPwd");
            x.style.display = "none";
        }
        var tooltips = document.querySelectorAll('.tooltip span');

        window.onmousemove = function(e) {
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
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OldenErwanin's website - Sign up page</title>
    <meta name="description" content="OldenErwanin website">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900|Cormorant+Garamond:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <header>
        <div class='wrapper signupBG'>
            <main class='signupPage'>
                <section class="logo-container">
                    <img class="logo" src="../img/logo.png" alt="">
                    <h1 class="logo-title"><span style="color: #b6621f;">OldenErwanin</span>'s<br>website</h1>
                </section>

                <form class='form-Signup' action='../includes/signup.inc.php' method='post'>
                    <?php
                    if (isset($_GET['regerror'])) {
                        if ($_GET['regerror'] == "emptyfields") {
                            echo '<div class="errorField"><p class="regError">Fill in all fields!</p></div><br>';
                        } else if ($_GET['regerror'] == "invalidmailuid") {
                            echo '<div class="errorField"><p class="regError">Invalid username and email!</p></div><br>';
                        } else if ($_GET['regerror'] == "invalidmail") {
                            echo '<div class="errorField"><p class="regError">Give a valid email!</p></div><br>';
                        } else if ($_GET['regerror'] == "invaliduid") {
                            echo '<div class="errorField"><p class="regError">The username can contains characters: a-z, A-Z, 0-9</p></div><br>';
                        } else if ($_GET['regerror'] == "pwdcheck") {
                            echo '<div class="errorField"><p class="regError">The passwords have to be the same!</p></div><br>';
                        } else if ($_GET['regerror'] == "sqlerror") {
                            echo '<div class="errorField"><p class="regError">Mysql error!</p></div><br>';
                        } else if ($_GET['regerror'] == "uidtaken") {
                            echo '<div class="errorField"><p class="regError">This username is already used!</p></div><br>';
                        }
                    }
                    ?>

                    <label class='formTitle'>Sign up here:</label>
                    <input name='signup-Uid' type='text' placeholder='Username'>
                    <input name='signup-Pwd' type='password' placeholder='Password'>
                    <input name='signup-Pwd2' type='password' placeholder='Repeat password'>
                    <input name='signup-Email' type='email' placeholder='E-mail adress'>

                    <table class='tableGender'>
                        <tr>
                            <td>
                                <label class='tableTitle'>Gender:</label>
                            </td>
                            <td>
                                <label for="signup-Gender" class='radioGender'>Male</label>
                            </td>
                            <td>
                                <input name='signup-Gender' type='radio' value='male'>
                            </td>
                            <td>
                                <label for='signup-Gender' class='radioGender'>Female</label>
                            </td>
                            <td>
                                <input name='signup-Gender' type='radio' value='female'>
                            </td>
                        </tr>
                    </table>

                    <table class='tableDate'>
                        <tr>
                            <td>
                                <label class='tableTitle'>Birthday:</label>
                            </td>
                            <td>
                                <input name='signup-birthDay' type='number' placeholder='DD' min="1" max="31">
                            </td>
                            <td>
                                <input name='signup-birthMonth' type='number' placeholder='MM' min="1" max="12">
                            </td>
                            <td>
                                <input name='signup-birthYear' type='number' placeholder='YYYY' min="1920" max="2019">
                            </td>
                        </tr>
                    </table>

                    <iframe src="../subpages/terms.html" height="200" width="100%"></iframe>
                    <table class='tableTerms'>
                        <tr>
                            <td>
                                <label class='tableTitle'>Accept terms:</label>
                            </td>
                            <td>
                                <input name='signup-Terms' type="checkbox">
                            </td>
                        </tr>
                    </table>
                    <button class="regSubmit" name='submit-Signup' type='submit'>Sign up</button>
                    <form class='form-Backward' action='../news.php' method='post'>
                        <button class="backwardSubmit" type='submit'>Back to Home page</button>
                    </form>
                    </button>

            </main>
        </div>
    </header>
</body>

</html>

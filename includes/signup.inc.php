<?php
if (isset($_POST["submit-Signup"])) {
    require 'database.inc.php';

    $username = $_POST['signup-Uid'];
    $password = $_POST['signup-Pwd'];
    $password2 = $_POST['signup-Pwd2'];
    $email = $_POST['signup-Email'];
    $gender = $_POST['signup-Gender'];
    $birthDay = $_POST['signup-birthDay'];
    $birthMonth = $_POST['signup-birthMonth'];
    $birthYear = $_POST['signup-birthYear'];
    $terms = $_POST['signup-Terms'];
    $date = date("Y-m-d");
    $birth = $birthDay. "/" .$birthMonth. "/" .$birthYear;
    $introductionTitle = "Default title";
    $introductionText = "Default text";
    $time = strtotime($birth);

    $newformat = date('Y-m-d', $time);
    $other = 0;

    if (empty($username) || empty($password) || empty($password2) || empty($email) || empty($gender) || empty($birthDay) || empty($birthMonth) || empty($birthYear)) {
        header("Location: ../subpages/signup.php?regerror=emptyfields&uid=" . $username . "&mail=" . $email . "&gender=" . $gender . "&bD=" . $birthDay . "&bM=" . $birthMonth . "&bY=" . $birthYear);
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../subpages/signup.php?regerror=invalidmail&uid=" . $username . "&gender=" . $gender . "&bD=" . $birthDay . "&bM=" . $birthMonth . "&bY=" . $birthYear);
        exit();
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../subpages/signup.php?regerror=invaliduid&mail=" . $email . "&gender=" . $gender . "&bD=" . $birthDay . "&bM=" . $birthMonth . "&bY=" . $birthYear);
        exit();
    } else if ($password !== $password2) {
        header("Location: ../subpages/signup.php?regerror=pwdcheck&uid=" . $username . "&mail=" . $email . "&gender=" . $gender . "&bD=" . $birthDay . "&bM=" . $birthMonth . "&bY=" . $birthYear);
        exit();
    } else if (empty($terms)){
        header("Location: ../subpages/signup.php?regerror=termscheck&uid=" . $username . "&mail=" . $email . "&gender=" . $gender . "&bD=" . $birthDay . "&bM=" . $birthMonth . "&bY=" . $birthYear);
        exit();
    } else {
        $sql = "SELECT uName FROM users WHERE uName=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../subpages/signup.php?regerror=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultcheck = mysqli_stmt_num_rows($stmt);
            if ($resultcheck > 0) {
                header("Location: ../subpages/signup.php?regerror=uidtaken&mail=" . $email . "&gender=" . $gender . "&bD=" . $birthDay . "&bM=" . $birthMonth . "&bY=" . $birthYear);
                exit();
            } else if ($resultcheck == 0) {
                $sql = "INSERT INTO users (uName, uEmail, uPwd, uBirth, uGender, uRegistred, uAdmin, uCommCounter, uRank, uIntroductionTitle, uIntroductionText) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../subpages/signup.php?regerror=sqlerror");
                    exit();
                } else {
                    $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ssssssiiiss", $username, $email, $hashedpwd, $newformat, $gender, $date, $other, $other, $other, $introductionTitle, $introductionText);
                    mysqli_stmt_execute($stmt);
                    $sqlAvatar = "SELECT * FROM users WHERE uName = '$username'";
                    $resultAvatar = mysqli_query($conn, $sqlAvatar);
                    if (mysqli_num_rows($resultAvatar) > 0) {
                      while ($row = mysqli_fetch_assoc($resultAvatar)) {
                        $userID = $row["uID"];
                        $aDate = date("Y-m-d");
                        $insertAvatar = "INSERT INTO avatars (uID, aStatus, aType, aAdded, aSize) VALUES ('$userID', 1, 'none', '$aDate', 0)";
                        mysqli_query($conn, $insertAvatar);
                      }
                    }
                    header("Location: ../news.php?signup=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: ../news.php");
    exit();
}

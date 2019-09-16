<?php
if (isset($_POST["submit-FriendAnswer"])) {
    session_start();
    require 'database.inc.php';

    $id = $_POST["friendanswer-ID"];
    if ($_POST["submit-FriendAnswer"] == "accept") {
        $sql = "UPDATE friends SET fState = 2 WHERE fID = " . $id;
        $result = mysqli_query($conn, $sql);
    } elseif ($_POST["submit-FriendAnswer"] == "refuse") {
        $sql = "DELETE FROM friends WHERE fID = " . $id;
        $result = mysqli_query($conn, $sql);
    }
    header("Location: ../subpages/friends.php?page=list");
    exit();
} else {
    header("Location: ../news.php");
    exit();
}

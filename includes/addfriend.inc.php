<?php
session_start();
if (isset($_POST["submit-AddFriend"]) && $_POST["addfriend-Name"] != $_SESSION["uName"]) {
    require 'database.inc.php';

    $sqlExist = "SELECT * FROM friends WHERE uName = '".$_SESSION["uName"]. "' OR toName = '" . $_SESSION["uName"] . "'";
    $resultExist = mysqli_query($conn, $sqlExist);
    if (mysqli_num_rows($resultExist) > 0) {
        
    }
    $friendName = $_POST["addfriend-Name"];
    $sqlFriend = "SELECT * FROM users WHERE uName = '". $friendName ."'";
    $resultFriend = mysqli_query($conn, $sqlFriend);
    while ($rowFriend = mysqli_fetch_assoc($resultFriend)) {
        $friendID = $rowFriend["uID"];
    }
    
    

    $id = $_SESSION["uID"];
    $name = $_SESSION["uName"];
    
    $date = date("Y.m.d");

    $state = 1;

    if (empty($friendName)) {
        header("Location: ../news.php");
        exit();
    } else {
        $sql = "INSERT INTO friends (uID, uName, toID, toName, fDate, fState) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../news.php?mysql=error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "isissi", $id, $name, $friendID, $friendName, $date, $state);
            mysqli_stmt_execute($stmt);
            header("Location: ../subpages/friends.php?page=list");
            exit();
        }
    }
} else {
    header("Location: ../news.php");
    exit();
}

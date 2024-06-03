<?php

session_start();

require_once '../functions.php';

if (!isset($_SESSION["user"])) {
    header("Location: ./c_topic.php");
}

require_once '../functions.php';

$comment = selectCommentById();

$message = htmlspecialchars(trim($_POST["message"]));

$id = $_GET["comment_id"];

$getId = $_GET["id"];

if($message !== "") {
    if($_SESSION["user"]["id"] == $comment["user_id"] || $_SESSION["user"]["role_id"] == 1 || $_SESSION["user"]["role_id"] == 2) {
        updateComments($message, $id);
        header("Location: ./read_topic.php?id=$getId");
    } else {
        header("Location: ./c_topic.php");
    }
} else {
    header("Location: ./c_topic.php");
}

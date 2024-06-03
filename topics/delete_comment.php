<?php

require_once '../functions.php';

session_start();

if(!isset($_SESSION["user"])) {
    header("Location: ./c_topic.php");
}

deleteComment($_GET["comment_id"]);

header("Location: ./read_topic.php?id=" . $_GET["id"]);
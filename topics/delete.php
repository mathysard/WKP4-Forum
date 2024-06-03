<?php
session_start();
require_once '../functions.php';

$id = $_GET["id"];

$topic = topicFromId();

if ($_SESSION["user"]["id"] == $topic["user_id"] || $_SESSION["user"]["role_id"] == 1 || $_SESSION["user"]["role_id"] == 2) {
    deleteTopic($id);
    header("Location: ./c_topic.php");
} else {
    header("Location: ./c_topic.php");
}

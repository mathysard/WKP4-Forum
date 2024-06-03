<?php
session_start();

require_once '../functions.php';

if (isset($_SESSION["user"])) {
    if(isset($_POST["submit"]) && $_POST["comment"] !== "") {
        $id = $_GET["id"];
        $comment = htmlspecialchars(trim($_POST["comment"]));
        createComments($comment, $id);
        header("Location: ./read_topic.php?id=$id");
    } elseif(isset($_POST["submit"]) && empty($_POST["comment"])) {
        $id = $_GET["id"];
        header("Location: ./read_topic.php?error=15&message=Commentaire vide&id=$id");    
    }
}
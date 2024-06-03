<?php

require_once '../functions.php';

session_start();

if($_SESSION["user"]["role_id"] !== 1 && $_SESSION["user"]["role_id"] !== 2) {
    header("Location: ../index.php");
}

deleteUser($_GET["id"]);

if($_SESSION["user"]["id"] == $_GET["id"]) {
    session_destroy();
    header("Location: ../index.php");
}

header("Location: ./user_list.php");
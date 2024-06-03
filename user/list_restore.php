<?php

require_once '../functions.php';

session_start();

if($_SESSION["user"]["role_id"] !== 1 && $_SESSION["user"]["role_id"] !== 2) {
    header("Location: ../index.php");
}

restoreUser($_GET["id"]);

header("Location: ./user_list.php");
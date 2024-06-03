<?php

session_start();

if(!isset($_SESSION["user"])) {
    header("Location: ../login.php");
}

require_once '../functions.php';

deleteUser($_SESSION["user"]["id"]);

session_destroy();

header("Location: ../index.php");
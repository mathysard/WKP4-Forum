<?php

require_once '../functions.php';

session_start();

$user = showUser();

if (!isset($_SESSION["user"]) || !isset($_GET["id"])) {
    header("Location: ../index.php");
}

// var_dump($_FILES["profile_picture"]);

if($_SESSION["user"]["id"] == $_GET["id"]) {
    if (isset($_POST["firstname"]) && !empty($_POST["firstname"]) || isset($_POST["lastname"]) && !empty($_POST["lastname"]) || isset($_POST["username"]) && !empty($_POST["username"]) || isset($_POST["email"]) && !empty($_POST["email"])) {
        if($_FILES["profile_picture"]["tmp_name"] !== "") {
            updateUser(htmlspecialchars(trim($_POST["firstname"])), htmlspecialchars(trim($_POST["lastname"])), $_FILES["profile_picture"], htmlspecialchars(trim($_POST["username"])), htmlspecialchars(trim($_POST["email"])), htmlspecialchars(trim($_POST["about"])), $_GET["id"]);
        } else {
            updateUserNoImage(htmlspecialchars(trim($_POST["firstname"])), htmlspecialchars(trim($_POST["lastname"])), htmlspecialchars(trim($_POST["username"])), htmlspecialchars(trim($_POST["email"])), htmlspecialchars(trim($_POST["about"])), $_GET["id"]);
        }
        header("Location: ./profile.php?id=" . $_SESSION["user"]["id"]);
    } else {                                                                                                                                                                                                                                                                                                                                                           
        header("Location: ./profile.php?error=19&message=Veuillez remplir la totalité des champs");
    }
} else {
    header("Location: ./profile.php?error=20&message=Vous n'avez pas les permissions nécessaires pour modifier ces données");
}
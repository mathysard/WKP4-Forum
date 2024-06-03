<?php

// Pour la liste

session_start();

require_once '../functions.php';

$id = $_GET["id"];

if($_SESSION["user"]["role_id"] == 1 || $_SESSION["user"]["role_id"] == 2) {
    deleteCategory($id);
    header("Location: ./category_list.php");
} else {
    header("Location: ./c_category.php");
}

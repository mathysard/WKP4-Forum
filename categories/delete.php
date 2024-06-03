<?php
session_start();

require_once '../functions.php';

$id = $_GET["id"];

if($_SESSION["user"]["role_id"] == 1 || $_SESSION["user"]["role_id"] == 2) {
    deleteCategory($id);
    header("Location: ./c_category.php");
} else {
    header("Location:./c_category.php");
}
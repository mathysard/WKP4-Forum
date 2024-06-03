<?php

if (!isset($_SESSION["user"])) {
    header("Location: ./c_category.php");
}
<?php
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role_id"] == 4 || $_SESSION["user"]["role_id"] == 3) {
    header('Location: ./profile.php?id=' . $_SESSION["user"]["id"]);
}

<?php
session_start();
if(!isset($_SESSION['thelogin'])||$_SESSION["key"] != session_id()) {
    header("Location: deco.php");
    exit();
}

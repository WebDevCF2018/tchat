<?php
session_start();
if(!isset($_SESSION['thelogin'])) {
    header("Location: deco.php");
    exit();
}

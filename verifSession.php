<?php
session_start();
if(!isset($_SESSION['thelogin'])) {
    header("Location: index.php");
    exit();
}

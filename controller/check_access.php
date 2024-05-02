<?php
session_start();

if ($_SESSION['access_type'] == 1 || $_SESSION['access_type'] == 3) {
    header("Location: ../manager.php");
} elseif ($_SESSION['access_type'] == 2) {
    header("Location: ../user.php");
}

<?php
session_start();

include "../scripts/isRegistrated.php";

if (isR()) {
    $role = $_SESSION['role'];
    switch ($role) {
        case "user":
            header('Location:https://group667.online/PA/UA/personalaccaunt.php');
            break;
        case "admin":
            header('Location:https://group667.online/PA/AA/adminaccaunt.php');
            break;
        case "expert":
            header('Location:https://group667.online/PA/EA/expertaccaunt.php');
            break;
        case "consultant":
            header('Location:https://group667.online/PA/CA/consultantaccaunt.php');
            break;
        case "main_expert":
            header('Location:https://group667.online/PA/EA/mainexpertaccaunt.php');
            break;
        default:
            header('Location:https://group667.online/index.php');
    }
} else {
    header('Location:https://group667.online/redirectPages/notRegistred.html');
}

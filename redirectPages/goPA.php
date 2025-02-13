<?php
session_start();

include "../scripts/isRegistrated.php";

if (isR()) {
    $role = $_SESSION['role'];
    switch ($role) {
        case "user":
            header('Location:https://group667.ru/PA/UA/personalaccaunt.php');
            break;
        case "admin":
            header('Location:https://group667.ru/PA/AA/adminaccaunt.php');
            break;
        case "expert":
            header('Location:https://group667.ru/PA/EA/expertaccaunt.php');
            break;
        case "consultant":
            header('Location:https://group667.ru/PA/CA/consultantaccaunt.php');
            break;
        default:
            header('Location:https://group667.ru/index.php');
    }
} else {
    header('Location:https://group667.ru/redirectPages/notRegistred.html');
}

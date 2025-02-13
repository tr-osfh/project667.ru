<?php
session_start();

include "isRegistrated.php";

if (!isR()) {
    header('Location:https://group667.ru/pages/authorization/authorization.html');
} else {
    header('Location:https://group667.ru/pages/pages/authorization/alredyAuthorized.html');
}

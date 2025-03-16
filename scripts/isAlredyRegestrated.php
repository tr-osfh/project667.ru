<?php
session_start();

include "isRegistrated.php";

if (!isR()) {
    header('Location:https://group667.online/pages/authorization/authorization.html');
} else {
    header('Location:https://group667.online/pages/pages/authorization/alredyAuthorized.html');
}

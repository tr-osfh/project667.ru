<?php
session_start();

include "../scripts/isRegistrated.php";

if (isR()) {
    header('Location:https://group667.ru/pages/consultationForm.php');
} else {
    header('Location:https://group667.ru/redirectPages/notRegistred.html');
}

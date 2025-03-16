<?php
session_start();

include "../scripts/isRegistrated.php";

if (isR()) {
    header('Location:https://group667.online/pages/consultationForm.php');
} else {
    header('Location:https://group667.online/redirectPages/notRegistred.html');
}

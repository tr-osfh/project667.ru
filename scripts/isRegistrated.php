<?php

function isR()
{
    if (isset($_SESSION['username'])) {
        return true;
    } else {
        return false;
    }
}

function getUserRole()
{
    return $_SESSION['role'];
}

function getUsername()
{
    return $_SESSION['username'];
}
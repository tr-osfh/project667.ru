<?php
session_start();

$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";

$connection = new mysqli($servername, $username, $password, $db);

if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profession_name = htmlspecialchars($_POST["profname"]);
    $qu1 = htmlspecialchars($_POST["quality1"]);
    $qu2 = htmlspecialchars($_POST["quality2"]);
    $qu3 = htmlspecialchars($_POST["quality3"]);
    $qu4 = htmlspecialchars($_POST["quality4"]);
    $qu5 = htmlspecialchars($_POST["quality5"]);
    $qu6 = htmlspecialchars($_POST["quality6"]);
    $qu7 = htmlspecialchars($_POST["quality7"]);
    $descriprion = htmlspecialchars($_POST["descriprion"]);
    $ph_link = htmlspecialchars($_POST["photolink"]);
    $sql = "INSERT INTO `professions` (`profname`, `quality1`, `quality2`, `quality3`, `quality4`, `quality5`, `quality6`, `quality7`, `descriprion`, `photolink`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssssssss", $profession_name, $qu1, $qu2, $qu3, $qu4, $qu5, $qu6, $qu7, $descriprion, $ph_link);
    $stmt->execute();
    header('Location:https://group667.ru/PA/EA/expertpanel.php');
}

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
    $name = htmlspecialchars($_POST["name"]);
    if ($name != "") {
        $id = $_SESSION["id"];
        $sql = "UPDATE `user_data` SET `name`= ? WHERE `user_id`=  $id";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
    }

    $surname = htmlspecialchars($_POST["surname"]);

    if ($surname != "") {
        $id = $_SESSION["id"];
        $sql = "UPDATE user_data SET surname = ? WHERE user_id = $id";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $surname);
        $stmt->execute();
    }

    $email = htmlspecialchars($_POST["email"]);
    if ($email != "") {
        $id = $_SESSION["id"];
        $sql = "UPDATE user_data SET email = ? WHERE user_id = $id";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
    }

    $sex = htmlspecialchars($_POST["sex"]);
    if ($sex != "") {
        $id = $_SESSION["id"];
        $sql = "UPDATE user_data SET sex = ? WHERE user_id = $id";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $sex);
        $stmt->execute();
    }

    $age = htmlspecialchars($_POST["age"]);
    if ($age != "") {
        $id = $_SESSION["id"];
        $sql = "UPDATE user_data SET age = ? WHERE user_id = $id";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $age);
        $stmt->execute();
    }
}

header("Location: /redirectPages/goPA.php");
exit();

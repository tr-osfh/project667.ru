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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/styles/styleForLK.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
</head>

<body>


    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);
        $password2 = htmlspecialchars($_POST["password2"]);

        $sql = "SELECT `id` FROM `users` WHERE `username` = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
    ?>
            <p>Такой пользователь уже существует</p>
            <a href="https://group667.ru/index.php"><button>Домой</button></a>
            <?php
            exit();
        } else {
            if ($password == $password2) {
                $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("ss", $username, $password);
                if ($stmt->execute() === TRUE) {
            ?>
                    <p>Регистрация завершена</p>
                    <a href="https://group667.ru/index.php"><button>Домой</button></a>
                <?php
                    exit();
                } else {
                    echo "Ошибка: " . $sql . "<br>" . $connection->error;
                }
            } else {
                ?>
                <p>Пароли не совпадают</p>
                <a href="https://group667.ru/index.php"><button>Домой</button></a>
    <?php
                exit();
            }
        }
    }
    ?>
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

        $sql = "SELECT `id` FROM `users` WHERE `username` = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $sql = "SELECT `password` FROM `users` WHERE `username` = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $ppass = $result->fetch_assoc();


            if ($password == $ppass['password']) {
    ?>
                <div class="message">

                    <p>Вы вошли в аккаунт <b><?php echo $username ?></b></p>
                    <a href="https://group667.online/index.php"><button>Домой</button></a>
                </div>
            <?php
                $sql = "SELECT `role` FROM `users` WHERE `username` = '$username'";
                $role = $connection->query($sql)->fetch_assoc()['role'];

                $sql = "SELECT `id` FROM `users` WHERE `username` = '$username'";
                $id = $connection->query($sql)->fetch_assoc()['id'];

                $_SESSION["username"] = $username;
                $_SESSION["role"] = $role;
                $_SESSION["id"] = $id;
            } else {
            ?>
                <div class="message">
                    <p>Поверьте имя пользователя или пароль!</p>
                    <a href="https://group667.online/pages/authorization/authorization.html"><button>Назад</button></a>
                </div>
            <?php
            }
        } else {
            ?>
            <div class="message">
                <p>Проверьте имя пользователя или пароль!</p>
                <a href="https://group667.online/pages/authorization/authorization.html"><button>Назад</button></a>
            </div>
    <?php
        }
    }

    $connection->close();
    ?>
</body>

</html>
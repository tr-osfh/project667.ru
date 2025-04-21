<?php
session_start();
error_reporting(E_ALL); // Вывод всех типов ошибок (E_ALL включает всё)
ini_set('display_errors', 1); // Включаем отображение ошибок на экране
ini_set('display_startup_errors', 1);

$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";
$connection = new mysqli($servername, $username, $password, $db);
if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

// Проверка наличия параметров
if (isset($_GET['username']) && isset($_GET['tableName'])) {
    // Сохраняем username и tableName
    $username = $_GET['username'];
    $_SESSION['tableName'] = $_GET['tableName'];

    // Подготовка SQL-запроса
    $stmt = $connection->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); // Привязываем параметр
    $stmt->execute();

    // Получение результата
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION['user_test_id'] = $user['id'];
        $user_test_id = $user['id'];
    }

    // Закрытие соединения
    $stmt->close();
    $connection->close();
}


?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты теста</title>
    <link rel="stylesheet" href="../../static/styles/styleForAllTests.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
</head>
    <div class="container">
        <div class="header_container" id="header">
            <a href="https://group667.online" onclick="location.href='index.php';" class="icon_button"></a>
            <div class="header-title_container">
                <div class="header_title">
                    <h2>Group 667</h2>
                    <div class="header_subtitle">
                        <h3>Путь в IT начинается здесь!</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>  

    <div><?php include "../../scripts/test_res_biId.php" ?></div>
    <div><?php include "../../scripts/test_dynamic_user.php" ?></div>
    <div><?php $_SESSION['user_test_id'] = $user_test_id; include "../../scripts/test_norm_user.php"; ?></div>

    
    <div style="text-align: left;">
        <form action="testresults.php" method="post">
            <button type="submit">вернуться к тестам</button>
        </form>
    </div>
    
</body>
</html>
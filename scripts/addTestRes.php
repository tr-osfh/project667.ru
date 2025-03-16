<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = 'u3003666_project667';
$username = 'u3003666_root';
$password = '9MhtHL8QmFHjbiK';

// Устанавливаем соединение с базой данных
$connection = new mysqli($host, $username, $password, $dbname);

// Проверяем соединение
if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из POST-запроса
    $table_name = $_POST['table_name'];
    $avg_time = $_POST['avg_time'];
    $accuracy = $_POST['accuracy'];
    $misses = $_POST['misses'];
    $date = $_POST['date'];
    $test = $_POST['test'];

    // Получаем user_id из сессии
    $user_id = $_SESSION['id'];

    // Подготавливаем SQL-запрос
    $sql = "INSERT INTO `$table_name` (`user_id`, `avg_time`, `accuracy`, `misses`, `date`)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $connection->error);
    }

    // Привязываем параметры
    $stmt->bind_param("iddis", $user_id, $avg_time, $accuracy, $misses, $date);

    // Выполняем запрос
    if ($stmt->execute()) {
        // Перенаправляем пользователя
        header("Location: https://group667.online/tests/$test");
        exit;
    } else {
        die("Ошибка выполнения запроса: " . $stmt->error);
    }
}
?>
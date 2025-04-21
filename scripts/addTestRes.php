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
    $table_name = $_POST['table_name'] ?? 'test_ruletka';
    $avg_time = isset($_POST['avg_time']) ? (float)$_POST['avg_time'] : 0;
    $accuracy = isset($_POST['accuracy']) ? (int)$_POST['accuracy'] : 0;
    $misses = isset($_POST['misses']) ? (int)$_POST['misses'] : 0;
    $std_dev = isset($_POST['std_dev']) ? (float)$_POST['std_dev'] : 0; // Добавляем std_dev
    $date = $_POST['date'] ?? date('Y-m-d');
    $test = $_POST['test'] ?? '';

    // Получаем user_id из сессии
    if (!isset($_SESSION['id'])) {
        die("Ошибка: пользователь не авторизован");
    }
    $user_id = (int)$_SESSION['id'];

    // Подготавливаем SQL-запрос
    $sql = "INSERT INTO `$table_name` (`user_id`, `avg_time`, `accuracy`, `misses`, `std_dev`, `date`)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $connection->error);
    }

    // Привязываем параметры
    $stmt->bind_param("iddids", $user_id, $avg_time, $accuracy, $misses, $std_dev, $date);

    // Выполняем запрос
    if ($stmt->execute()) {
        // Перенаправляем пользователя
        header("Location: https://group667.online/tests/$test");
        exit;
    } else {
        die("Ошибка выполнения запроса: " . $stmt->error);
    }

    $stmt->close();
}

$connection->close();
?>
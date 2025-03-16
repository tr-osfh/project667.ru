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
    // Декодируем JSON-строку в массив
    $pvk_ids = json_decode($_POST['pvk_id'], true);
    $profession_id = $_POST['profession_id'];

    // Проверяем, что декодирование прошло успешно
    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Ошибка декодирования JSON: " . json_last_error_msg());
    }

    // Проверяем, что массив не пуст
    if (empty($pvk_ids)) {
        die("Ошибка: массив pvk_id пуст.");
    }

    // Получаем expert_id из сессии
    $expert_id = $_SESSION['id'];

    // Подготавливаем SQL-запрос
    $sql = "INSERT INTO `selectedPVK` (`profession_id`, `pvk_id`, `expert_id`) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $connection->error);
    }

    // Вставляем каждое значение pvk_id
    foreach ($pvk_ids as $pvk_id) {
        $stmt->bind_param("iii",$profession_id,  $pvk_id, $expert_id);
        if (!$stmt->execute()) {
            die("Ошибка выполнения запроса: " . $stmt->error);
        }
    }

    // Закрываем соединение
    $stmt->close();
    $connection->close();

    // Перенаправляем пользователя
    header("Location: https://group667.online/PA/EA/expertpanel.php");
    exit;
}
?>
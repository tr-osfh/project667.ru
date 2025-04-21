<?php

session_start();

error_reporting(E_ALL); // Указываем, какие ошибки отображать (E_ALL — все ошибки)
ini_set('display_errors', 1); // Включаем отображение ошибок на экране
ini_set('display_startup_errors', 1);

$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";

// Подключение к БД
$connection = new mysqli($servername, $username, $password, $db);
if ($connection->connect_error) {
    die("Ошибка подключения: " . $connection->connect_error);
}

// Получаем user_id (из сессии)
$expert_id = $_SESSION['id'];
if(isset($_POST['prof_id'])){
    $prof_id = $_POST['prof_id'];
}else{
    error_log( "pizda, bratan");
}

// Загружаем данные пользователя
$sql = "SELECT * FROM user_tests WHERE expert_id = ? AND prof_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ii", $expert_id, $prof_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Если записи нет, создаем новую
if (!$data) {
    $sql = "INSERT INTO user_tests (expert_id, prof_id) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $expert_id, $prof_id);
    $stmt->execute();

    // Повторно загружаем данные
    $sql = "SELECT * FROM user_tests WHERE expert_id = ? AND prof_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $expert_id, $prof_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
}

// Устанавливаем данные в сессии
$savedData = $data ?? [
    "test_chet_sound" => 0,
    "test_chet_view" => 0,
    "test_one_color" => 0,
    "test_one_sound" => 0,
    "test_ruletka" => 0,
];
$_SESSION['savedData'] = $savedData;

// Обработка формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedTests = $_POST["tests"] ?? [];

    $test1 = in_array("test_chet_sound", $selectedTests) ? 1 : 0;
    $test2 = in_array("test_chet_view", $selectedTests) ? 1 : 0;
    $test3 = in_array("test_one_color", $selectedTests) ? 1 : 0;
    $test4 = in_array("test_one_sound", $selectedTests) ? 1 : 0;
    $test5 = in_array("test_ruletka", $selectedTests) ? 1 : 0;

    // Обновление данных
    $sql = "UPDATE user_tests SET test_chet_sound=?, test_chet_view=?, test_one_color=?, test_one_sound=?, test_ruletka=? WHERE expert_id=? AND prof_id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iiiiiii", $test1, $test2, $test3, $test4, $test5, $expert_id, $prof_id);

    $stmt->execute();

    // Обновляем сессию
    $_SESSION['savedData'] = [
        "test_chet_sound" => $test1,
        "test_chet_view" => $test2,
        "test_one_color" => $test3,
        "test_one_sound" => $test4,
        "test_ruletka" => $test5,
    ];


    header('Location:https://group667.online/PA/EA/expertpanel.php');
}
?>
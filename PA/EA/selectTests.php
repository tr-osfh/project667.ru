<?php

session_start();

// Проверяем, есть ли сохраненные данные в сессии
$savedData = $_SESSION['savedData'] ?? [
    "test_chet_sound" => 0,
    "test_chet_view" => 0,
    "test_one_color" => 0,
    "test_one_sound" => 0,
    "test_ruletka" => 0,
];

$prof_id = $_POST['id'];

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Выбор тестов</title>
    <link rel="stylesheet" href="../../static/styles/styleForLK.css">
</head>

<body>
    <div class="header_container">
        <h1>Выбрать тесты</h1>
    </div>

    <h3>Выберите тесты</h3>
    <div class="forms">
        <form action="../../expertRights/selectTestsForUser.php" method="post">
            <input type="hidden" name="prof_id" value="<?php echo $prof_id; ?>">
        
            <label><input type="checkbox" name="tests[]" value="test_chet_sound" <?= $savedData['test_chet_sound'] ? "checked" : "" ?>> Test chet-sound</label><br>
            <label><input type="checkbox" name="tests[]" value="test_chet_view" <?= $savedData['test_chet_view'] ? "checked" : "" ?>> Test chet-view</label><br>
            <label><input type="checkbox" name="tests[]" value="test_one_color" <?= $savedData['test_one_color'] ? "checked" : "" ?>> Test one-color</label><br>
            <label><input type="checkbox" name="tests[]" value="test_one_sound" <?= $savedData['test_one_sound'] ? "checked" : "" ?>> Test one-sound</label><br>
            <label><input type="checkbox" name="tests[]" value="test_ruletka" <?= $savedData['test_ruletka'] ? "checked" : "" ?>> Test ruletka</label><br>
            <button type="submit">Сохранить</button>
        </form>
    </div>

</body>

</html>

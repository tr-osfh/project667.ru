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

include "../../expertRights/getProfessionName.php";

$sql = "SELECT `id` FROM `profession_data` WHERE `expertID` = ? AND `profid` = ?";

if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param("ss", $_SESSION['id'], $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: ../../redirectPages/alreadyRated.html");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../static/styles/styleForLK.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <h1>Вы оцениваете профессию<br>"<?php echo $profession_name ?>"</h1>

    <form id="searchForm">
        <input type="text" name="query" placeholder="Введите поисковый запрос">
        <button type="button" id="search">Искать ПВК</button> <!-- Добавлен type="button" -->
    </form>

    <div id="result"></div> <!-- Элемент для вывода результатов -->

    <form action="../../expertRights/rateProfession.php" method="post">
        <button type="submit">Закончить оценку</button>
    </form>

    <script>
        document.getElementById('search').addEventListener('click', function(event) {
            event.preventDefault(); // Отменяем стандартное поведение формы

            const query = document.querySelector('input[name="query"]').value;

            fetch('../../OpenAiRes.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `query=${encodeURIComponent(query)}`
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('result').innerHTML = data; // Вставляем результат в div
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                });
        });
    </script>
</body>
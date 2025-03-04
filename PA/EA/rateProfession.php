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

    <form action="../../expertRights/rateProfession.php" method="post">

        <ul id="sortable-list">
            <li data-id="analyticity">Аналитичность</li>
            <li data-id="switching_attention">Переключение внимания</li>
            <li data-id="planning">Планирование</li>
            <li data-id="сritical_thinking">Кретическое мышление</li>
            <li data-id="сommunication_skills">Коммуникабельность</li>
            <li data-id="emotional_stability">Эмоциональная устойчивость</li>
            <li data-id="сreativity">Креативность</li>
        </ul>

        <input type="hidden" name="order" id="order-input">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
        <script src="../../scripts/sortable_list.js"></script>

        <input type="hidden" name="expertID" id="expertID" value="<?php echo $_SESSION['id'] ?>">
        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
        <button type="submit">Закончить оценивание</button>
    </form>
</body>

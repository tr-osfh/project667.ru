<?php session_start(); ?>
<!-- К строке выше не прикасаться, она отвечает за запуск сессии -->
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
    <?php
    include "../../expertRights/getProfessionName.php";
    ?>
    <h1>Вы оцениваете профессию " <?php echo $profession_name ?> "</h1>

    <form action="../../expertRights/rateProfession.php" method="post">

        <ul id="sortable-list">
            <li data-id="skill">Скилл</li>
            <li data-id="knowlege">Знания</li>
            <li data-id="sport">Физподготовка</li>
            <li data-id="creativity">Креативность</li>
            <li data-id="communication">Коммуникабельность</li>
            <li data-id="confidence">Уверенность</li>
            <li data-id="chill">Чиловость</li>
        </ul>

        <input type="hidden" name="order" id="order-input">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
        <script src="../../scripts/sortable_list.js"></script>


        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
        <button type="submit">Закончить оценивание</button>
    </form>
</body>
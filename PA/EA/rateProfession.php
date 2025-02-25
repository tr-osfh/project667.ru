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

        <input type="text" id="value1" name="value1" placeholder="оценка 2">
        <input type="text" id="value2" name="value2" placeholder="оценка 2">
        <input type="text" id="value3" name="value3" placeholder="оценка 3">
        <input type="text" id="value4" name="value4" placeholder="оценка 4">
        <input type="text" id="value5" name="value5" placeholder="оценка 5">
        <input type="text" id="value6" name="value6" placeholder="оценка 6">
        <input type="text" id="value7" name="value7" placeholder="оценка 7">


        <input type="hidden" name="id" value=<?php $id ?>>
        <button type="submit">Закончить оценивание</button>
    </form>
</body>
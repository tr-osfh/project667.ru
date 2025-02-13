<?php session_start(); ?>
<!-- К строке выше не прикасаться, она отвечает за запуск сессии -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://group667.ru/static/styles/styleForLK.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <?php include '../scripts/isRegistrated.php' ?>

    <div class="header_container" id="header">
        <!-- Логотип в шапке -->
        <a href="https://group667.ru/index.php" onclick="location.href='index.php';" class="icon_button"></a>
        <h1>Записаться на консультацию</h1>
    </div>

    <h3>Доступные консультации</h3>
    <?php
    include "../userConsultations/curConsultations.php";
    ?>

    <h3>Ваши консультации</h3>
    <?php
    include "../userConsultations/userConsultations.php";
    ?>
</body>

</html>
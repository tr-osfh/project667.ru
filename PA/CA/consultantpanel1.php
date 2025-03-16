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
    <?php include '../../scripts/isRegistrated.php' ?>
    <div class="header_container" id="header">
        <!-- Логотип в шапке -->
        <a href="https://group667.online/index.php" onclick="location.href='mainpage.html';" class="icon_button"></a>
        <h1>Панель консультанта</h1>
    </div>

    <h3>Актуальные консультации</h3>
    <?php
    include "../../consultantRights/curConsultations.php";
    ?>

    <h3>Свободные консультации</h3>
    <?php
    include "../../consultantRights/avaConsultations.php";
    ?>

    <h3>Добавить запись</h3>

    <div class="forms">
        <form action="../../consultantRights/addConsultation.php" method="post">
            <input type="text" id="date_time" name="date_time" placeholder="YYYY-MM-DD hh:mm">
            <br>
            <button type="submit" id="btn2">подтвердить</button>
        </form>
    </div>

    <h3>Выйти из панели консультанта</h3>

    <form action="../../redirectPages/goPA.php" method="post">
        <button type="submit">вернуться в личный кабинет</button>
    </form>
</body>

</html>
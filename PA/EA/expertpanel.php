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
    <div class="header_container" id="header">
        <!-- Логотип в шапке -->
        <a href="https://group667.online/index.php" onclick="location.href='mainpage.html';" class="icon_button"></a>
        <h1>Панель эксперта</h1>
    </div>

    <h3>Список профессий</h3>
    <div>
        <?php include "../../expertRights/currentProfessions.php" ?>
    </div>

    <h3>Добавить профессию</h3>

    <div>
        <form action="addprofession.php" method="post">
            <button type="submit">Добавить профессию</button>
        </form>
    </div>

    <h3>Выйти из панели эксперта</h3>
    <div>
        <form action="../../redirectPages/goPA.php" method="post">
            <button type="submit">вернуться в личный кабинет</button>
        </form>
    </div>
</body>

</html>
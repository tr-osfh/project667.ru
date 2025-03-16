<?php session_start(); ?>
<!-- К строке выше не прикасаться, она отвечает за запуск сессии -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>667gang</title>
    <link rel="stylesheet" href="../../static/styles/professionsStyle.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <?php include '../../scripts/isRegistrated.php' ?>
    <div class="header_container" id="header">
        <!-- Логотип в шапке -->
        <a href="https://group667.online/index.php" onclick="location.href='mainpage.html';" class="icon_button"></a>
    </div>

    <div class="body_container">
        <div class="prof_title">
        </div>
        <?php include "../../adminRights/glanceProfession.php" ?>
    </div>

    <form action="../../PA/AA/adminpanel.php" method="post">
        <button type="submit">вернуться в ПА</button>
    </form>

</body>

</html>
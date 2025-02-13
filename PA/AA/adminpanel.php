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
        <a href="https://group667.ru/index.php" onclick="location.href='mainpage.html';" class="icon_button"></a>
        <h1>Панель админа</h1>
    </div>

    <h3>Список пользователей</h3>

    <?php
    include "../../adminRights/checkAllUsers.php";
    ?>

    <h3>Установить роль пользователя</h3>

    <div class="forms">
        <form action="../../adminRights/setNewRole.php" method="post">
            <input type="text" id="userid" name="userid" placeholder="ID пользователя">
            <input type="text" id="role" name="role" placeholder="user/admin/expert/consultant">
            <br>
            <button type="submit" id="btn2">подтвердить</button>
        </form>
    </div>

    <h3>Удалить пользователя</h3>

    <div class="forms">
        <form action="../../adminRights/deliteUser.php" method="post">
            <input type="text" id="userid" name="userid" placeholder="ID пользователя">
            <br>
            <button type="submit" id="btn2">подтвердить</button>
        </form>
    </div>


    <h3>Выйти из панели администратора</h3>
    <form action="../../PA/AA/adminaccaunt.php" method="post">
        <button type="submit">вернуться в личный кабинет</button>
    </form>
</body>

</html>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="static/styles/styleForLK.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <h1>Добавить професиию</h1>

    <h3>Добавить профессию</h3>
    <div class="forms">
        <form action="../../expertRights/addProfession.php" method="post">
            <div>
                <p>Название</p>
                <input type="text" id="profname" name="profname" placeholder="Название профессии">
            </div>
            <div>
                <p>Качества</p>
                <input type="text" id="quality1" name="quality1" placeholder="Качество 1">
                <input type="text" id="quality2" name="quality2" placeholder="Качество 2">
                <input type="text" id="quality3" name="quality3" placeholder="Качество 3">
                <input type="text" id="quality4" name="quality4" placeholder="Качество 4">
                <input type="text" id="quality5" name="quality5" placeholder="Качество 5">
                <input type="text" id="quality6" name="quality6" placeholder="Качество 6">
                <input type="text" id="quality7" name="quality7" placeholder="Качество 7">
            </div>
            <div>
                <p>Описание профессии</p>
                <input type="text" id="descriprion" name="descriprion" placeholder="описание">
            </div>
            <div>
                <p>Фото</p>
                <input type="text" id="photolink" name="photolink" placeholder="Cсылка на фото">
            </div>
            <div>
                <button type="submit" id="btn">подтвердить</button>
            </div>
        </form>
    </div>
</body>

</html>
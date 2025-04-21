<?php 
session_start();
$_SESSION['tableName'] = 'test_ruletka';
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>667gang</title>
        <link rel="stylesheet" href="../static/styles/test_ruletka.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
            <div class="header_container" id="header">
                <a href="https://group667.online" onclick="location.href='index.php';" class="icon_button"></a>
                <div class="header-title_container">
                    <div class="header_title">
                        <h2>Group 667</h2>
                        <div class="header_subtitle">
                            <h3>Путь в IT начинается здесь!</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div id="loading">
                <div id="loading_content">
                    <p>Подождите несколько секунд, данные загружаются</p>
                </div>
            </div>
            <canvas id="wheel" width="400" height="400"></canvas>
            <div class="buttons">
                <button id="blue" class="color-btn" data-color="#4682B4">Синий</button>
                <button id="green" class="color-btn" data-color="#2E8B57">Зелёный</button>
                <button id="red" class="color-btn" data-color="#B30000">Красный</button>
            </div>
            <div id="results">
                <p>Среднее время реакции: <span id="avg-time">0</span> мс</p>
                <p>Точность: <span id="accuracy">0</span></p>
                <p>Ошибки (пропуски): <span id="misses">0</span></p>
                <p>Ошибки (неверные): <span id="wrong">0</span></p>
                <p>Стандартное отклонение: <span id="std-dev">0</span> мс</p>
            </div>
            <button id="start"><?php include "../scripts/check_attemts/ruletka_attemts.php" ?></button>
            <div id="old_res"><?php include "../scripts/results_after_test/testRuletkaRes.php" ?></div>
            <div id="norm"><?php include "../scripts/test_norm_user.php"?></div>
            <div id="dinamic"><?php include "../scripts/test_dynamic_user.php"?></div>
        </div>
        <script src="../scripts/test_scripts/test_ruletka.js"></script>
    </body>
</html>
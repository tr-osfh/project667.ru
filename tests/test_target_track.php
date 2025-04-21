<?php 
session_start();
$_SESSION['tableName'] = 'test_target_track';
$_SESSION['columns'] = ['reaction_time', 'max_correct_time', 'std_dev'];
$_SESSION['columns_names'] = ['Среднее время реакции', 'Точность преследования', 'Стандартное отклонение'];
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>667gang</title>
        <link rel="stylesheet" href="../static/styles/test_styles.css" />
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
            
            <div class="game_area" id="game_area" style="display: none">
                <div id="goal"></div>
                <div id="target"></div>
            </div>

            <!-- Добавляем прогресс-бар -->
            <div class="progress-container" id="progress-container" style="display: none">
                <div class="progress-bar" id="progress">
                    <div class="progress-fill" id="progress-fill"></div>
                </div>
                <span id="progress-text">0:00</span>
            </div>

            <div id="results">
                <div id="timer"></div>
                <p>Среднее время реакции на изменение движения <span id="avg-time">0</span> мс</p>
                <p>Точность преследования (максимальное время пересечения цели с мишенью) <span id="accuracy">0</span> с</p>
            </div>
            <button id="start"><?php include "../scripts/check_attemts/one_color_attemts.php" ?></button>

            <!-- Добавляем модальное окно для выбора времени -->
            <div id="time-modal" class="modal">
                <div class="modal-content">
                    <h2>Выберите время теста:</h2>
                    <button class="time-option" data-minutes="2">2 минуты</button>
                    <button class="time-option" data-minutes="5">5 минут</button>
                    <button class="time-option" data-minutes="15">15 минут</button>
                    <button class="time-option" data-minutes="45">45 минут</button>
                </div>
            </div>

            <div id="old_res"><?php include "../scripts/results_after_test/testTargetTracking.php" ?></div>
            <div id="norm"><?php include "../scripts/test_norm_user_script.php"?></div>
            <div id="dinamic"><?php include "../scripts/test_dynamic_user_script.php"?></div>
        </div>
        <script src="../scripts/test_scripts/test_target_track.js"></script>
    </body>
</html>
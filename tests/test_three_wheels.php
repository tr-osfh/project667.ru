<?php 
session_start();
$_SESSION['tableName'] = 'test_three_wheels';
$_SESSION['columns'] = ['avg_time', 'accuracy', 'misses', 'abs_mean', 'std_dev']
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Тест на движущиеся объекты</title>
    <link rel="stylesheet" href="../static/styles/test_three_wheels.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div class="header_container">
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
        <div class="wheels-container">
            <div class="wheel-wrapper">
                <canvas id="wheel1" width="300" height="300"></canvas>
                <div class="progress-container">
                    <div class="progress-bar" id="progress1">
                        <div class="progress-fill" id="progress-fill1"></div>
                    </div>
                    <span id="progress-text1">0:00</span>
                </div>
            </div>
            <div class="wheel-wrapper">
                <canvas id="wheel2" width="300" height="300"></canvas>
                <div class="progress-container">
                    <div class="progress-bar" id="progress2">
                        <div class="progress-fill" id="progress-fill2"></div>
                    </div>
                    <span id="progress-text2">0:00</span>
                </div>
            </div>
            <div class="wheel-wrapper">
                <canvas id="wheel3" width="300" height="300"></canvas>
                <div class="progress-container">
                    <div class="progress-bar" id="progress3">
                        <div class="progress-fill" id="progress-fill3"></div>
                    </div>
                    <span id="progress-text3">0:00</span>
                </div>
            </div>
        </div>
        <div class="buttons">
            <button id="first" class="test-btn">First</button>
            <button id="second" class="test-btn">Second</button>
            <button id="third" class="test-btn">Third</button>
        </div>
        <button id="start"><?php include "../scripts/check_attemts/three_wheel_attemts.php" ?></button>

        <!-- Модальное окно для выбора времени -->
        <div id="time-modal" class="modal">
            <div class="modal-content">
                <h2>Выберите время теста:</h2>
                <button class="time-option" data-minutes="2">2 минуты</button>
                <button class="time-option" data-minutes="5">5 минут</button>
                <button class="time-option" data-minutes="15">15 минут</button>
                <button class="time-option" data-minutes="45">45 минут</button>
            </div>
        </div>

        <h1>Результаты теста</h1>
        <!-- Новая секция: Статистика по колесам -->
        <div class="wheel-stats">
            <div class="stats-header">
                <h2>Статистика по колесам</h2>
                <button class="toggle-btn" id="toggle-wheel-stats">Свернуть</button>
            </div>
            <div class="stats-content" id="wheel-stats-content">
                <div id="wheel1-stats">
                    <h3>Колесо 1</h3>
                    <p>Попадания: <span id="wheel1-hits">0</span></p>
                    <p>Промахи: <span id="wheel1-misses">0</span></p>
                    <p>Точность: <span id="wheel1-accuracy">0%</span></p>
                    <p>Среднее время реакции: <span id="wheel1-avg-time">0 мс</span></p>
                </div>
                <div id="wheel2-stats">
                    <h3>Колесо 2</h3>
                    <p>Попадания: <span id="wheel2-hits">0</span></p>
                    <p>Промахи: <span id="wheel2-misses">0</span></p>
                    <p>Точность: <span id="wheel2-accuracy">0%</span></p>
                    <p>Среднее время реакции: <span id="wheel2-avg-time">0 мс</span></p>
                </div>
                <div id="wheel3-stats">
                    <h3>Колесо 3</h3>
                    <p>Попадания: <span id="wheel3-hits">0</span></p>
                    <p>Промахи: <span id="wheel3-misses">0</span></p>
                    <p>Точность: <span id="wheel3-accuracy">0%</span></p>
                    <p>Среднее время реакции: <span id="wheel3-avg-time">0 мс</span></p>
                </div>
            </div>
        </div>
        <!--
        <div class="results">
            <div class="stats-header">
                <h2>Общая статистика</h2>
                <button class="toggle-btn" id="toggle-overall-stats">Свернуть</button>
            </div>
            <div class="stats-content" id="overall-stats-content">
                <div id="old_res"><?php include "../scripts/results_after_test/testThreeWheels.php" ?></div>
                <div id="norm"><?php include "../scripts/test_norm_user_script.php"?></div>
                <div id="dinamic"><?php include "../scripts/test_dynamic_user_script.php"?></div>
            </div>
        </div>
-->
        <div class="last-minute-stats">
            <div class="stats-header">
                <h2>Статистика за последнюю минуту</h2>
                <button class="toggle-btn" id="toggle-last-minute-stats">Свернуть</button>
            </div>
            <div class="stats-content" id="last-minute-stats-content">
                <p>Попадания: <span id="last-minute-hits">0</span></p>
                <p>Промахи: <span id="last-minute-misses">0</span></p>
                <p>Точность: <span id="last-minute-accuracy">0%</span></p>
                <p>Среднее время реакции: <span id="last-minute-avg-time">0 мс</span></p>
            </div>
        </div>
    </div>
    <script src="../scripts/test_scripts/test_three_wheels.js"></script>
</body>
</html>
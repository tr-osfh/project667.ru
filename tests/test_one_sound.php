<?php 
session_start();
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
            <audio id="sound" src="../static/sound/bip.mp3"></audio>
            <img id="sound_img" style="display: none;" src="../static/images/iconsreg/sound.png">
            <div class="buttons">
                <button id="click_space_btn">Click/Space</button>
            </div>
            <div id="results">
                <div id="timer"></div>
                <p>Среднее время реакции: <span id="avg-time">0</span> мс</p>
                <p>Верные попадания: <span id="accuracy">0</span></p>
                <p>Ошибки: <span id="misses">0</span></p>
            </div>
            <button id="start"><?php include "../scripts/check_attemts/one_sound_attemts.php" ?></button>
            <div id="old_res"><?php include "../scripts/testOneSoundRes.php" ?></div>
        </div>
        <script src="../scripts/test_onesound.js"></script>
    </body>
</html>
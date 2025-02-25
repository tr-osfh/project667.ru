<?php
session_start();
include '../scripts/isRegistrated.php';
?>

<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>667gang</title>
    <link rel="stylesheet" href="../static/styles/professionsStyle.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <div class="container">
        <div class="header_container" id="header">
            <a href="https://group667.ru/" onclick="location.href='../index.php';" class="icon_button"></a>
            <div class="header-title_container">
                <div class="header_title">
                    <h2>Group 667</h2>
                    <div class="header_subtitle">
                        <h3>Путь в IT начинается здесь!</h3>
                    </div>
                </div>
            </div>

            <div class="button-container">
                <?php
                if (!isR()) {
                    echo '<a href="../redirectPages/goConsultation.php" class="btn btn-add">Консультации</a>';
                    echo '<a href="#" class="btn btn-add">Тесты</a>';
                    echo '<a href="../pages/registration/registration.html" class="btn btn_sign-in">Sign in</a>';
                    echo '<a href="../scripts/isAlredyRegestrated.php" class="btn btn_log-in">Log in</a>';
                } else {
                    echo '<a href="../redirectPages/goConsultation.php" class="btn btn-add">Консультации</a>';
                    echo '<a href="#" class="btn btn-add">Тесты</a>';
                    echo '<a href="../redirectPages/goPA.php" class="btn btn_sign-in">Личный кабинет</a>';
                }
                ?>

                <img class="authorization_icon" src="" />
            </div>
        </div>


        <div class="body_container">
            <div class="prof_title">
                <h2>Актуальные профессии</h2>
            </div>
            <div class="professions_container" id="prof-container">
                <div class="profession_block">
                    <img class="prof-photo"
                        src="https://slushaidom.ru/wp-content/uploads/2022/08/obuchenie-it-spetsialnostyam.jpg" />
                    <div class="prof_content">
                        <div class="prof_title">НАЗВАНИЕ</div>
                        <div class="prof_description">
                            Описание профессии
                        </div>
                        <ul class="prof_requirements">
                            <li>Требование 1</li>
                            <li>Требование 2</li>
                            <li>Требование 3</li>
                            <li>Требование 4</li>
                            <li>Требование 5</li>
                            <li>Требование 6</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
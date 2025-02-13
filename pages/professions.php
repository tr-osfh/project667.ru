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
            <a href="https://group667.ru/" onclick="location.href='../index.html';" class="icon_button"></a>
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
                    <img class="prof-photo" src="../static/images/professions/frontend.jpg" />
                    <div class="prof_content">
                        <div class="prof_title">Front-end разработчик</div>
                        <div class="prof_description">
                            Front-end разработчик отвечает за создание видимой части сайта. Он работает с HTML, CSS
                            и JavaScript, чтобы сделать сайт красивым, удобным и интерактивным.
                        </div>
                    </div>
                    <div class="prof_text">Создает интерфейсы для пользователей</div>
                </div>
                <div class="profession_block">
                    <img class="prof-photo" src="../static/images/professions/backend.jpg" />
                    <div class="prof_content">
                        <div class="prof_title">Back-end разработчик</div>
                        <div class="prof_description">
                            Back-end разработчик занимается серверной частью приложения. Он работает с базами
                            данных, API и логикой, которая скрыта от пользователя, но обеспечивает работу всего
                            сайта.
                        </div>
                    </div>
                    <div class="prof_text">Работает с серверной частью</div>
                </div>
                <div class="profession_block">
                    <img class="prof-photo" src="../static/images/professions/web.jpg" />
                    <div class="prof_content">
                        <div class="prof_title">Web-разработчик</div>
                        <div class="prof_description">
                            Web-разработчик — это универсальный специалист, который может работать как с front-end,
                            так и с back-end. Он создает полноценные веб-приложения, начиная от дизайна и заканчивая
                            серверной логикой.
                        </div>
                    </div>
                    <div class="prof_text">Универсальный специалист</div>
                </div>
                <div class="profession_block">
                    <img class="prof-photo" src="../static/images/professions/data.jpg" />
                    <div class="prof_content">
                        <div class="prof_title">Data Scientist</div>
                        <div class="prof_description">
                            Анализирует данные, строит модели и делает прогнозы. Data Scientist анализирует большие
                            объемы данных с помощью статистических методов и машинного обучения. Его цель — выявить
                            закономерности и создать модели для предсказания будущих событий.
                        </div>
                    </div>
                    <div class="prof_text">Анализирует данные</div>
                </div>
                <div class="profession_block">
                    <img class="prof-photo" src="../static/images/professions/devops.jpg" />
                    <div class="prof_content">
                        <div class="prof_title">DevOps Engineer</div>
                        <div class="prof_description">
                            DevOps-инженер объединяет разработку и эксплуатацию программного обеспечения,
                            автоматизируя процессы CI/CD. Он управляет инфраструктурой и обеспечивает надежность
                            приложений через мониторинг и автоматизацию.
                        </div>
                    </div>
                    <div class="prof_text">Автоматизирует процессы</div>
                </div>
                <div class="profession_block">
                    <img class="prof-photo" src="../static/images/professions/ux.jpg" />
                    <div class="prof_content">
                        <div class="prof_title">UI/UX Designer</div>
                        <div class="prof_description">
                            UI/UX дизайнер создает удобные и привлекательные интерфейсы для пользователей, исследуя
                            их потребности и предпочтения. Он разрабатывает прототипы и проводит тестирования для
                            улучшения пользовательского опыта.
                        </div>
                    </div>
                    <div class="prof_text">Создает интерфейсы</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
session_start();
include 'scripts/isRegistrated.php';
?>
<!doctype html>
<html lang="ru">

<head>
    <!-- Устанавливаем кодировку страницы на UTF-8 -->
    <meta charset="UTF-8" />

    <!-- Метатег для адаптивности страницы на мобильных устройствах -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Заголовок страницы -->
    <title>667gang</title>

    <!-- Подключение CSS-файла для стилей -->
    <link rel="stylesheet" href="https://group667.online/static/styles/main.css" />

    <!-- Подключение шрифтов с Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <!-- Главный контейнер всей страницы -->
    <div class="container">
        <!-- Шапка страницы -->
        <div class="header_container" id="header">
            <!-- Логотип в шапке -->
            <a href="https://absurdopedia.wiki/667" onclick="location.href='index.php';" class="icon_button"></a>

            <!-- Контейнер для заголовков в шапке -->
            <div class="header-title_container">
                <div class="header_title">
                    <!-- Основной заголовок -->
                    <h2>Group 667</h2>

                    <!-- Подзаголовок -->
                    <div class="header_subtitle">
                        <h3>Путь в IT начинается здесь!</h3>
                    </div>
                </div>
            </div>

            <!-- Контейнер для кнопок авторизации -->
            <div class="button-container">
                <?php
                if (!isR()) {
                    echo '<a href="redirectPages/goConsultation.php" class="btn btn-add">Консультации</a>';
                    echo '<a href="pages/professions.php" class="btn btn_sign-in">Профессии</a>';
                    echo '<a href="redirectPages/goTests.php" class="btn btn-add">Тесты</a>';
                    echo '<a href="pages/registration/registration.html" class="btn btn_sign-in">Sign up</a>';
                    echo '<a href="scripts/isAlredyRegestrated.php" class="btn btn_log-in">Log in</a>';
                } else {
                    echo '<a href="redirectPages/goConsultation.php" class="btn btn-add">Консультации</a>';
                    echo '<a href="pages/professions.php" class="btn btn_sign-in">Профессии</a>';
                    echo '<a href="redirectPages/goTests.php" class="btn btn-add">Тесты</a>';
                    echo '<a href="redirectPages/goPA.php" class="btn btn_sign-in">Личный кабинет</a>';
                }
                ?>

            </div>
        </div>

        <!-- Основной контент страницы -->
        <div class="body_container">
            <!-- Заголовок страницы -->
            <div class="inf_title">
                <p>Главная страница</p>
            </div>

            <!-- Контейнер для блока информации -->
            <div class="info_container" id="info-container">
                <!-- Первый блок информации -->
                <div class="info_block">
                    <!-- Заголовок блока -->
                    <div class="info_block_title">О команде</div>

                    <!-- Основной текст блока -->
                    <div class="info_block_text">
                        Наша команда состоит из студентов IT-университета,
                        поэтму мы, как никто, понимаем сложность и
                        важность выбора профессии в сфере информационных технологий.
                        Надеемся, что наш сервис Вам поможет.
                    </div>
                </div>

                <!-- Второй блок информации -->
                <div class="info_block">
                    <!-- Заголовок блока -->
                    <div class="info_block_title">О проекте</div>

                    <!-- Основной текст блока -->
                    <div class="info_block_text">
                        Не важно кто Вы: школьник, студент, работяга с
                        завода или пенсионер. Для вкатывания в IT нет преград,
                        равно как нет и оправданий для отказа.
                        Наш сервис призван сделать процесс выбора профессии предельно
                        простым и интерактивным для всех. Начните свой путь в IT
                        здесь!
                    </div>
                </div>

                <!-- Третий блок информации -->
                <div class="info_block">
                    <!-- Заголовок блока -->
                    <div class="info_block_title">Контакты</div>

                    <!-- Основной текст блока -->
                    <div class="info_block_text">
                        Свяжитесь с нами по телефону +7 667 228-81-52, по
                        электронной почте info@667gang.online или отправьте
                        голубя с письмом по адресу: село Никольское Меньковская ул. дом 10, палата 22.
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
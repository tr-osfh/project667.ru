<?php session_start(); ?>
<!-- К строке выше не прикасаться, она отвечает за запуск сессии -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../static/styles/styleForLK.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <?php include "../../scripts/isRegistrated.php"; ?>
    <!-- Выключение файла с php функиями -->
    <div class="header_container" id="header">
        <!-- Логотип в шапке -->
        <a href="https://group667.ru/index.php" onclick="location.href='mainpage.html';" class="icon_button"></a>
        <h1>Личный кабинет Юзера</h1>
    </div>
    <h3>Актуальные данные</h3>
    <p>Аккаунт: <?php echo getUsername() . "</br>"; ?></p>
    <p>Тип аккаунта: <?php echo getUserRole() . "</br>"; ?></p>


    <p>Электронная почта:
        <?php
        include "../../personalaccauntlogic/getEmail.php";
        echo getEmail() . "</br>";
        ?>
    </p>
    <p>Имя и фамилия:
        <?php
        include "../../personalaccauntlogic/getName.php";
        include "../../personalaccauntlogic/getSurname.php";
        echo getName() . " " . getSurname();
        ?>
    </p>

    <!-- Male/Female -->
    <p>Пол:
        <?php
        include "../../personalaccauntlogic/getSex.php";
        echo getSex();
        ?>
    </p>

    <p>Возраст:
        <?php
        include "../../personalaccauntlogic/getAge.php";
        echo getAge();
        ?>
    </p>



    <!-- Все что обернуто в php можно воспринимать как обычные строки, но все что внутри php скобок - неприкасаемо  -->

    <!-- К тегам ниже можно добавлять классы, менять белый текст, но трогать оранжевое и голубое нельзя -->

    <h3>Внести изменения</h3>
    <p>Имя и Фамилия</p>
    <div class="forms">
        <form action="../../personalaccauntlogic/setNSE.php" method="post">
            <input type="text" id="name" name="name" placeholder="<?php echo getName(); ?>">
            <input type="text" id="surname" name="surname" placeholder="<?php echo getSurname(); ?>">
            <p>Возраст</p>
            <input type="text" id="age" name="age" placeholder="<?php echo getAge(); ?>" >
            <p>Электронная почта</p>
            <input type="text" id="email" name="email" placeholder="<?php echo getEmail(); ?>">
            <p id="email_error">Неверно введена почта!</p>
            <div>
                <button id="afterEmail" type="submit">подтвердить</button>
            </div>
            <p>Пол</p>
            <div class="gender_div">
                <button class=<?php include "../../personalaccauntlogic/isMale.php"; echo isMale();?> class="gender_btn" id="man_btn">Мужчина</button>
                <button class=<?php include "../../personalaccauntlogic/isFemale.php"; echo isFemale();?> class="genderSet" id="woman_btn">Женщина</button>
            </div>
        </form>
    </div>


    <!--  -->

    <h3>Изменить пароль</h3>

    <form action="../../personalaccauntlogic\changePassword.php" method="post">
        <input type="text" id="password" name="password" placeholder="Введите пароль">
        <input type="text" id="password2" name="password2" placeholder="Повторите пароль">
        <br>
        <p id="password_error">Пароли не совпадают!</p>
        <button type="submit" id="btn2">подтвердить</button>
    </form>
    <!--  -->
    
    <h3>Посмотреть свои результаты тестов</h3>
    <form action="testresults.php" method="post">
        <button type="submit">Результаты тестов</button>
    </form>

    <h3>Выйти из аккаунта</h3>
    <form action="../../scripts/stopsession.php" method="post">
        <button type="submit">ПОКИНУТЬ АККАУНТ</button>
    </form>


    <script>
        const name_input = document.getElementById('name');
        const surname_input = document.getElementById('surname');
        const sex_input = document.getElementById('sex');
        const age_input = document.getElementById('age');
        const email_input = document.getElementById('email');
        const email_error = document.getElementById('email_error');
        const btn = document.getElementById('afterEmail');
        const btn2 = document.getElementById('btn2');
        const password = document.getElementById('password');
        const password2 = document.getElementById('password2');
        const password_error = document.getElementById('password_error')
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const man_btn = document.getElementById('man_btn');
        const woman_btn = document.getElementById('woman_btn');

        function checkInput(inputElement, expectedValue) {
            if (inputElement.value === expectedValue) {
                inputElement.style.backgroundColor = '#a04c4d06';
            } else {
                inputElement.style.backgroundColor = 'white';
            }
        }


        name_input.addEventListener('input', function() {
            checkInput(name_input, '<?php echo getName(); ?>');
        });

        surname_input.addEventListener('input', function() {
            checkInput(surname_input, '<?php echo getSurname(); ?>');
        });

        email_input.addEventListener('input', function() {
            checkInput(email_input, '<?php echo getEmail(); ?>');
        });

        email_input.addEventListener('blur', function() {
            if (!regex.test(email_input.value)) {
                email_error.style.display = 'block';
                btn.style.display = 'none';
            } else {
                email_error.style.display = 'none';
                btn.style.display = 'block';
            }
        });

        email_input.addEventListener('input', function() {
            if (regex.test(email_input.value)) {
                email_error.style.display = 'none';
                btn.style.display = 'block';
            }
        });

        password2.addEventListener('blur', function() {
            if (password2.value != password.value) {
                btn2.style.display = 'none';
                password_error.style.display = 'block';
            } else {
                btn2.style.display = 'block';
                password_error.style.display = 'none';
            }
        });

        password2.addEventListener('input', function() {
            if (password2.value == password.value) {
                btn2.style.display = 'block';
                password_error.style.display = 'none';
            }
        });

        man_btn.addEventListener('click', function() {
            fetch(`../../personalaccauntlogic/setGender.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `sex=male`
                })
                .then(response => response.text())
                .catch(error => {
                    console.error('Ошибка:', error);
                })
        });

        woman_btn.addEventListener('click', function() {
            fetch(`../../personalaccauntlogic/setGender.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `sex=female`
                })
                .then(response => response.text())
                .catch(error => {
                    console.error('Ошибка:', error);
                })
        });
    </script>
</body>

</html>

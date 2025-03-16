<?php
session_start();
error_reporting(E_ALL); // Указываем, какие ошибки отображать (E_ALL — все ошибки)
ini_set('display_errors', 1); // Включаем отображение ошибок на экране
ini_set('display_startup_errors', 1);
$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";
$connection = new mysqli($servername, $username, $password, $db);
if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

include "../../expertRights/getProfessionName.php";

$sql = "SELECT `id` FROM `profession_data` WHERE `expertID` = ? AND `profid` = ?";

if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param("ss", $_SESSION['id'], $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: ../../redirectPages/alreadyRated.html");
    }
}
?>

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
    <div id="many_pvk">
        <div id="many_pvk_content">
            <p>Вы уже выбрали максимальное количество ПВК!</p>
        </div>
    </div>
    <h1>Вы оцениваете профессию<br>"<?php echo $profession_name ?>"</h1>

    <form id="searchForm">
        <input id='search_input' type="text" name="query" placeholder="Введите поисковый запрос">
        <button type="button" id="search">Искать ПВК</button> <!-- Добавлен type="button" -->
    </form>
    <div id="loading">
        <!-- <p>Загрузка</p> -->
        <img id = 'log_logo' src="https://icons8.com/preloaders/preloaders/22/%D0%A2%D0%B0%D1%8E%D1%89%D0%B8%D0%B5%20%D0%BA%D1%80%D1%83%D0%B3%D0%B8.gif">
    </div>
    <form action="../../expertRights/rateProfession.php" method="post">
        <button id = 'end_rate' type="submit">Закончить оценку</button>
        <p id="error" style="display: none; color: red;">Выбрано недостаточно ПВК</p>
    </form>
    <div id="all_pvk"><?php include "../../expertRights/allPvk.php" ?></div>
    <div id="result"></div> <!-- Элемент для вывода результатов -->

    

    <script>
        const loading = document.getElementById('loading');
        const all_pvk = document.getElementById('all_pvk');
        const result = document.getElementById('result');
        const reg = /btn_pick_prof\d+/;
        let list = [];
        const end_rate = document.getElementById('end_rate');
        const error = document.getElementById('error')

        document.getElementById('search').addEventListener('click', function(event) {
            loading.style.display = "block";
            all_pvk.style.display = "none";
            event.preventDefault(); // Отменяем стандартное поведение формы

            const query = document.querySelector('input[name="query"]').value;
            document.getElementById('result').innerHTML = '';
            fetch(`../../OpenAiRes.php?nocache=${Date.now()}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `query=${encodeURIComponent(query)}&selected_pvk=${JSON.stringify(list)}`
                })
                .then(response => response.text())
                .then(data => {
                    console.log('Данные:', data);
                    document.getElementById('result').innerHTML = data; // Вставляем результат в div
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                })
                .then(() => {
                    document.getElementById('result').style.display = 'block';
                    loading.style.display = "none"; // Скрываем индикатор загрузки
                });
        });

        document.addEventListener('click', function(event) {
            if (event.target && reg.test(event.target.id)) {
                if (list.length >= 10 && (event.target.classList.contains('not_selected'))){
                    const element = document.getElementById("many_pvk");
                    element.style.opacity = '1';
                    element.style.display = 'flex';
                    setTimeout(function() {
                        element.style.opacity = '0';
                        setTimeout(function() {
                            element.style.display = 'none';
                        }, 1000); 
                    }, 2000);
                } if (list.length < 10 || event.target.classList.contains('selected')){
                    const btn_pick_prof = document.querySelectorAll('#'+event.target.id);
                    console.log(event.target.id);
                    const pvk_id = event.target.id.replace(/\D+/g, '')
                    if (event.target.classList.contains('selected')){
                        btn_pick_prof.forEach(element => {
                            element.style.backgroundColor = "red";
                            element.textContent = "Установить";
                            element.classList.add("not_selected");
                            element.classList.remove("selected");
                        });
                        list = list.filter(item => item !== pvk_id);
                        console.log(list);
                    }else if (event.target.classList.contains('not_selected')){
                        btn_pick_prof.forEach(element => {
                            element.style.backgroundColor = "grey";
                            element.textContent = "Установлено✓";
                            element.classList.add("selected");
                            element.classList.remove("not_selected");
                        });
                        list.push(pvk_id);
                        console.log(list);
                    }
                }else {
                   console.log('ЧЗХ');
                }
            }
        });

        document.getElementById('end_rate').addEventListener('click', function(event) {
            event.preventDefault(); 
            fetch('../../expertRights/rateProfession.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: '' 
                })
                .then(response => response.text()) 
                .catch(error => {
                    console.error('Ошибка при выполнении запроса:', error);
                });
        });

        document.getElementById('search_input').addEventListener('input', function(event) {
            if (event.target.value == '') {
                result.style.display = "none";
                all_pvk.style.display = "block";
            };
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.getElementById('many_pvk').style.display = 'none';
            }
        });

        end_rate.addEventListener('click', function(event){
            if (list.length < 5){ 
                error.style.display = 'block';
                setTimeout(function() { 
                    error.style.display = 'none';
                }, 5000);
                
            } else {
                fetch('../../selectedPVK.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `pvk_id=${JSON.stringify(list)}`
                })
                .then(response => response.text()) 
                .catch(error => {
                    console.error('Ошибка при выполнении запроса:', error);
                });
                window.location.replace("https://group667.online/PA/EA/expertpanel.php");
            }
        });
                

    </script>
</body>
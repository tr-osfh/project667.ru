<?php 
session_start();
$_SESSION['tableName'] = 'test_chet_view';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Тест на скорость реакции (Чёт/Нечёт) с голосовым сопровождением</title>
  <link rel="stylesheet" href="../static/styles/chet_view_test.css" />
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
  <div id="task">
    <p id="numbers">Нажми "Старт" для начала теста</p>
    <progress id="progress-bar" value="0" max="10"></progress>
  </div>
  <div class="buttons">
    <button id="even" class="choice-btn" disabled>Чёт</button>
    <button id="odd" class="choice-btn" disabled>Нечёт</button>
  </div>
  <div id="results">
    <p>Среднее время реакции: <span id="avg-time">0</span> мс</p>
    <p>Количество верных ответов: <span id="accuracy">0</span></p>
    <p>Ошибки: <span id="errors">0</span></p>
    <p>Стандартное отклонение: <span id="std-dev">0</span> мс</p>
  </div>
  <button id="start"><?php include "../scripts/check_attemts/chet_view_attemts.php" ?></button>
  <div id="old_res"><?php include "../scripts/results_after_test/testChetViewRes.php" ?></div>
  <div id="norm"><?php include "../scripts/test_norm_user.php"?></div>
  <div id="dinamic"><?php include "../scripts/test_dynamic_user.php"?></div>
</div>
<script src="../scripts/test_scripts/chet_view_test.js"></script>
</body>
</html>
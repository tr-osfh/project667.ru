<?php 
session_start();
$_SESSION['tableName'] = 'test_stick_drift';
$_SESSION['columns'] = ['avg_reaction', 'center_percent', 'std_dev'];
$_SESSION['columns_names'] = ['Средняя реакция', 'Процент времени в центре', 'Среднее отклонение'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Тест на управление дрейфом</title>
  <link rel="stylesheet" href="../static/styles/drift_test.css" />
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
  <div id="game-area">
    <div class="center-line"></div>
    <div id="target"></div>
  </div>
  <div class="progress-container">
    <div class="progress-bar" id="progress-bar">
      <div class="progress-fill" id="progress-fill"></div>
    </div>
    <span id="progress-text">0:00</span>
  </div>
  <button id="start">Начать тест</button>

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
  <!-- Текущая статистика -->
  <div class="current-stats">
    <p>Текущее отклонение: <span id="deviation">0.00</span> px</p>
    <p>Направление: <span id="direction">-</span></p>
  </div>
  <!-- Общая статистика -->
  <div class="results">
    <div class="stats-header">
      <h2>Общая статистика</h2>
      <button class="toggle-btn" id="toggle-overall-stats">Свернуть</button>
    </div>
    <div class="stats-content" id="overall-stats-content">
      <p>Среднее отклонение от центра: <span id="final-result">0</span> px</p>
      <p>Среднее время реакции: <span id="avg-reaction">0</span> мс</p>
      <p>Процент времени в центре: <span id="center-percent">0</span>%</p>
    </div>
  </div>
  <!-- Статистика за последнюю минуту -->
  <div class="last-minute-stats">
    <div class="stats-header">
      <h2>Статистика за последнюю минуту</h2>
      <button class="toggle-btn" id="toggle-last-minute-stats">Свернуть</button>
    </div>
    <div class="stats-content" id="last-minute-stats-content">
      <p>Среднее отклонение от центра: <span id="last-minute-avg-deviation">0</span> px</p>
      <p>Среднее время реакции: <span id="last-minute-avg-reaction">0</span> мс</p>
      <p>Процент времени в центре: <span id="last-minute-center-percent">0</span>%</p>
    </div>
  </div>
</div>
<script src="../scripts/test_scripts/drift_test.js"></script>
</body>
</html>
<?php 
session_start();
$_SESSION['tableName'] = 'test_tracking';
$_SESSION['columns'] = ['total_clicks', 'stats_avg', 'avg_click'];
$_SESSION['columns_names'] = ['Количество нажатий', 'Отклонение', 'Среднее количество кликов'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Moving Object Test</title>
  <style>
    body {
  background: linear-gradient(135deg, #f0f4f8, #ffffff);
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  font-optical-sizing: auto;
  font-weight: 400;
  background-color: white;
  width: 700px;
  border-radius: 15px;
  margin-left: auto;
  margin-right: auto;
  padding: 30px;
  padding-top: 0px;
  background-color: Snow;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  color: rgb(46, 46, 46);
}

.container {
  width: 90%;
  max-width: 800px;
  margin: 1rem auto;
  padding: 0.5rem;
  text-align: center;
  overflow: hidden;
}

.header_container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  height: 100px;
  border-bottom: 0.1rem solid black;
}

.header_icon {
  width: 150px;
  height: auto;
}

.header-title_container {
  flex: 1;
  text-align: left;
  margin-left: 20px;
}

.header_container h2 {
  font-size: 1.5rem;
  margin: 0;
}

.header_container h3 {
  font-size: 1rem;
  margin: 0;
}

.icon_button {
  width: 100px;
  max-height: 100px;
  height: 100%;
  border: none;
  background-image: url("../static/images/mainpage/667BIG.png");
  background-position: top center;
  background-size: 130% 120%;
  background-repeat: no-repeat;
  background-color: transparent;
}

.icon_button:hover {
  opacity: 0.8;
}

.icon_button:active {
  transform: scale(0.95);
}

    .card {
      padding-top: 20px;
      width: 100%;
      max-width: 700px;
      text-align: center;
      margin-top: 0;
    }

    #controls {
      margin-bottom: 20px;
    }

    #testArea {
      width: 100%;
      height: 400px;
      border-radius: 12px;
      background: #f8f9fc;
      position: relative;
      overflow: hidden;
      box-shadow: inset 0 4px 12px rgba(0, 0, 0, 0.05);
      margin: 20px 0;
    }

    #movingObject {
      width: 50px;
      height: 50px;
      background: #ff4d4d;
      position: absolute;
      border-radius: 50%;
      cursor: pointer;
      transition: transform 0.2s;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }
    #movingObject:hover {
      transform: scale(1.1);
    }

    #progressBar {
      height: 20px;
      background: #e0e0e0;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    #progressInner {
      height: 100%;
      background: #4caf50;
      width: 0%;
      transition: width 0.3s ease;
    }

    select, button {
      padding: 8px 16px;
      font-size: 16px;
      margin-left: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    button {
      background-color:rgb(229, 14, 14);
      color: white;
      border: none;
      cursor: pointer;
    }

    button:hover {
      background-color:rgb(234, 0, 0);
    }

    #results {
      margin-top: 20px;
    }
  </style>
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
    <div class="card">
    <div id="controls">
      <label for="duration">Выберите время теста:</label>
      <select id="duration">
        <option value="120">2 минуты</option>
        <option value="300">5 минут</option>
        <option value="900">15 минут</option>
        <option value="2700">45 минут</option>
      </select>
      <button id="startBtn">Начать тест</button>
    </div>

    <div id="testArea" style="display:none;">
      <div id="movingObject"></div>
    </div>

    <div id="progress" style="display:none;">
      <div style="margin-bottom: 8px;">Оставшееся время: <span id="timeLeft"></span></div>
      <div id="progressBar">
        <div id="progressInner"></div>
      </div>
    </div>
    
    <div id="results" style="display:none;">
    <div id="old_res"><?php include "../scripts/results_after_test/testTracking.php" ?></div>
    <div id="norm"><?php include "../scripts/test_norm_user_script.php"?></div>
    <div id="dinamic"><?php include "../scripts/test_dynamic_user_script.php"?></div>
    </div>
  </div>
    </div>

    <script>
    const startBtn = document.getElementById('startBtn');
    const durationSelect = document.getElementById('duration');
    const testArea = document.getElementById('testArea');
    const movingObject = document.getElementById('movingObject');
    const timeLeftSpan = document.getElementById('timeLeft');
    const progress = document.getElementById('progress');
    const progressInner = document.getElementById('progressInner');
    const resultsDiv = document.getElementById('results');
    const controls = document.getElementById('controls');

    let interval, timer, startTime, totalClicks = 0, speed = 1000, timeElapsed = 0;
    let clickTimestamps = [];

    function randomPosition() {
      const maxX = testArea.clientWidth - movingObject.clientWidth;
      const maxY = testArea.clientHeight - movingObject.clientHeight;
      const x = Math.random() * maxX;
      const y = Math.random() * maxY;
      movingObject.style.left = `${x}px`;
      movingObject.style.top = `${y}px`;
    }

    function moveObject() {
      randomPosition();
    }

    function updateProgress(duration) {
      const elapsed = Math.floor((Date.now() - startTime) / 1000);
      timeLeftSpan.textContent = `${duration - elapsed} сек`;
      progressInner.style.width = `${(elapsed / duration) * 100}%`;
      timeElapsed = elapsed;
    }

    function calculateStatistics() {
      if (clickTimestamps.length < 2) return { avg: 0, std: 0 };
      let intervals = [];
      for (let i = 1; i < clickTimestamps.length; i++) {
        intervals.push(clickTimestamps[i] - clickTimestamps[i - 1]);
      }
      const avg = intervals.reduce((a, b) => a + b, 0) / intervals.length;
      const std = Math.sqrt(intervals.reduce((sum, val) => sum + Math.pow(val - avg, 2), 0) / intervals.length);
      return { avg: (avg / 1000).toFixed(2), std: (std / 1000).toFixed(2) };
    }

    function endTest(duration) {
      testArea.style.display = 'none';
      progress.style.display = 'none';
      resultsDiv.style.display = 'block';
      const perMinute = (totalClicks / (duration / 60)).toFixed(2);
      const stats = calculateStatistics();
      updateFooter();
      // resultsDiv.innerHTML = `
      //   <h2>Результаты теста</h2>
      //   <p>Всего кликов: ${totalClicks}</p>
      //   <p>Кликов в минуту: ${perMinute}</p>
      //   <p>Среднее время между кликами: ${stats.avg} сек</p>
      //   <p>Среднеквадратичное отклонение: ${stats.std} сек</p>
      //   <p>Среднее количество кликов в секунду: ${(totalClicks / duration).toFixed(2)}</p>
      // `;

    }

    // Функция для обновления таблицы результатов в футере
    function updateFooter() {
      let now = new Date();
      let year = now.getFullYear();
      let month = String(now.getMonth() + 1).padStart(2, '0');
      let day = String(now.getDate()).padStart(2, '0'); 
      let dbFormattedDate = `${year}-${month}-${day}`;
      let data = {
          table_name: 'test_tracking',
          totsl_clicks:totalClicks,
          click_per_minute: perMinute,
          stats_avg: stats.avg,
          stats_std: stats.std,
          avg_clicks: (totalClicks / duration).toFixed(2),
          date: dbFormattedDate,
          test: 'test_chet_sound.php'
      };
      const urlEncodedData = new URLSearchParams(data).toString();
      try {
          fetch(`https://group667.online/scripts/addTestRes.php`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
              },
              body: urlEncodedData
          })
          ;
        } catch (error) {
          console.error('Ошибка:', error);
      }
      data_load().then(() => {
          window.location.href = "https://group667.online/tests/tracking_test.php";
      })
    };
      

    movingObject.addEventListener('click', () => {
      totalClicks++;
      clickTimestamps.push(Date.now());
    });

    function startTest() {
      const duration = parseInt(durationSelect.value);
      totalClicks = 0;
      clickTimestamps = [];
      speed = 1000;
      startTime = Date.now();

      controls.style.display = 'none';
      testArea.style.display = 'block';
      progress.style.display = 'block';
      resultsDiv.style.display = 'none';
      randomPosition();

      interval = setInterval(() => {
        moveObject();
      }, speed);

      timer = setInterval(() => {
        updateProgress(duration);
        if (timeElapsed % 10 === 0 && timeElapsed !== 0) {
          speed *= 0.9;
          clearInterval(interval);
          interval = setInterval(() => {
            moveObject();
          }, speed);
        }
        if (timeElapsed >= duration) {
          clearInterval(interval);
          clearInterval(timer);
          endTest(duration);
        }
      }, 1000);
    }

    startBtn.addEventListener('click', startTest);
  </script>
</body>
</html>

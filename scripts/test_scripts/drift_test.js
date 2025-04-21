const startBtn = document.getElementById('start');
const target = document.getElementById('target');
const deviationSpan = document.getElementById('deviation');
const directionSpan = document.getElementById('direction');
const finalResultSpan = document.getElementById('final-result');
const avgReactionSpan = document.getElementById('avg-reaction');
const centerPercentSpan = document.getElementById('center-percent');
const progressFill = document.getElementById('progress-fill');
const progressText = document.getElementById('progress-text');
const timeModal = document.getElementById('time-modal');
const timeOptions = document.querySelectorAll('.time-option');
const toggleOverallStatsBtn = document.getElementById('toggle-overall-stats');
const toggleLastMinuteStatsBtn = document.getElementById('toggle-last-minute-stats');
const overallStatsContent = document.getElementById('overall-stats-content');
const lastMinuteStatsContent = document.getElementById('last-minute-stats-content');
const lastMinuteAvgDeviationSpan = document.getElementById('last-minute-avg-deviation');
const lastMinuteAvgReactionSpan = document.getElementById('last-minute-avg-reaction');
const lastMinuteCenterPercentSpan = document.getElementById('last-minute-center-percent');

let isRunning = false;
let animationFrame;
let driftTimeout;
let lastFrame = 0;
let totalTestTime = 0;
let testStartTime = 0;
let lastMinuteInterval;
let totalElapsed = 0;

// Накопители статистических данных
let deviationSamples = [];
let overallDeviationSum = 0;
let overallSamples = 0;
let reactionTimes = [];
let reactionTimestamps = [];
let pendingDriftReaction = null;
let centerTime = 0;
const centerThreshold = 10;

// Физические параметры
const physics = {
  position: 0,
  velocity: 0,
  driftForce: 50,    // Увеличиваем для более динамичного дрейфа
  controlForce: 100,  // Увеличиваем для более отзывчивого управления
  friction: 0.2,      // Уменьшаем трение
  maxSpeed: 300,      // Увеличиваем максимальную скорость
  currentDirection: 1
};

// Обновление сложности
const updateDifficulty = {
  currentLevel: 0,
  intervals: [4000, 3000, 2000, 1500, 800],
  forceLevels: [100, 125, 175, 200, 210]
};

// Состояние клавиш
const keys = {
  KeyA: false,
  KeyD: false
};

// Экран загрузки
async function data_load() {
  // console.log('data_load началась');
  const element = document.getElementById("loading");
  element.style.opacity = '1';
  element.style.display = 'flex';
  await new Promise(resolve => setTimeout(resolve, 1000));
  element.style.opacity = '0';
  await new Promise(resolve => setTimeout(resolve, 1000));
  element.style.display = 'none';
  // console.log('data_load завершена');
}

// Форматирование времени (секунды в MM:SS)
function formatTime(seconds) {
  const minutes = Math.floor(seconds / 60);
  const secs = Math.floor(seconds % 60);
  return `${minutes}:${secs < 10 ? '0' + secs : secs}`;
}

// Функция для расчета стандартного отклонения
function calculateStandardDeviation(times) {
  if (times.length <= 1) return 0;
  const mean = times.reduce((a, b) => a + b, 0) / times.length;
  const squaredDiffs = times.reduce((sum, time) => sum + Math.pow(time - mean, 2), 0);
  const stdDev = Math.sqrt(squaredDiffs / (times.length - 1));
  return Math.round(stdDev);
}

// Вычисление статистики за последние 60 секунд
function calculateLastMinuteStats() {
  const now = Date.now() / 1000;
  const lastMinuteStats = {
    deviationSum: 0,
    deviationSamples: 0,
    reactionTimes: [],
    centerTime: 0,
    totalElapsed: 0
  };

  for (let i = 0; i < deviationSamples.length; i++) {
    const timestamp = deviationSamples[i].timestamp;
    if (now - timestamp <= 60) {
      lastMinuteStats.deviationSum += deviationSamples[i].value;
      lastMinuteStats.deviationSamples++;
    }
  }

  for (let i = 0; i < reactionTimes.length; i++) {
    const timestamp = reactionTimestamps[i];
    if (now - timestamp <= 60) {
      lastMinuteStats.reactionTimes.push(reactionTimes[i]);
    }
  }

  const elapsedSinceStart = totalElapsed;
  const startTime = now - 60;
  let centerTimeInLastMinute = 0;
  let elapsedInLastMinute = 0;

  for (let i = 0; i < deviationSamples.length; i++) {
    const timestamp = deviationSamples[i].timestamp;
    if (timestamp >= startTime) {
      const nextTimestamp = i + 1 < deviationSamples.length ? deviationSamples[i + 1].timestamp : now;
      const deltaTime = (nextTimestamp - timestamp) / 1000;
      elapsedInLastMinute += deltaTime;
      if (Math.abs(deviationSamples[i].value) < centerThreshold) {
        centerTimeInLastMinute += deltaTime;
      }
    }
  }

  lastMinuteStats.centerTime = centerTimeInLastMinute;
  lastMinuteStats.totalElapsed = elapsedInLastMinute;

  const avgDeviation = lastMinuteStats.deviationSamples ? (lastMinuteStats.deviationSum / lastMinuteStats.deviationSamples) : 0;
  const avgReaction = lastMinuteStats.reactionTimes.length ? lastMinuteStats.reactionTimes.reduce((a, b) => a + b) / lastMinuteStats.reactionTimes.length : 0;
  const centerPercent = lastMinuteStats.totalElapsed ? (lastMinuteStats.centerTime / lastMinuteStats.totalElapsed * 100) : 0;

  return {
    avgDeviation: avgDeviation.toFixed(2),
    avgReaction: avgReaction.toFixed(0),
    centerPercent: centerPercent.toFixed(2)
  };
}

function updateLastMinuteStats() {
  const lastMinuteStats = calculateLastMinuteStats();
  lastMinuteAvgDeviationSpan.textContent = lastMinuteStats.avgDeviation;
  lastMinuteAvgReactionSpan.textContent = lastMinuteStats.avgReaction;
  lastMinuteCenterPercentSpan.textContent = lastMinuteStats.centerPercent;
}

function updateFooter() {
  let now = new Date();
  let year = now.getFullYear();
  let month = String(now.getMonth() + 1).padStart(2, '0');
  let day = String(now.getDate()).padStart(2, '0');
  let dbFormattedDate = `${year}-${month}-${day}`;
  const overallAvg = overallSamples ? (overallDeviationSum / overallSamples) : 0;
  const avgReaction = reactionTimes.length ? reactionTimes.reduce((a, b) => a + b) / reactionTimes.length : 0;
  const centerPercent = totalElapsed ? (centerTime / totalElapsed * 100) : 0;
  let data = {
    table_name: 'test_stick_drift',
    overall_avg: overallAvg,
    avg_reaction: avgReaction,
    center_percent: centerPercent,
    std_dev: calculateStandardDeviation(reactionTimes),
    date: dbFormattedDate,
    test: 'drift_test.php'
  };
  const urlEncodedData = new URLSearchParams(data).toString();
  try {
    fetch(`https://group667.online/scripts/addTestRes.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: urlEncodedData
    });
  } catch (error) {
    console.error('Ошибка:', error);
  }
  data_load().then(() => {
    window.location.href = "https://group667.online/tests/drift_test.php";
  });
}

function scheduleDriftChange() {
  const interval = updateDifficulty.intervals[Math.min(updateDifficulty.currentLevel, updateDifficulty.intervals.length - 1)];
  driftTimeout = setTimeout(() => {
    physics.currentDirection *= -1;
    physics.driftForce = updateDifficulty.forceLevels[Math.min(updateDifficulty.currentLevel, updateDifficulty.forceLevels.length - 1)];
    updateDifficulty.currentLevel++;
    pendingDriftReaction = {
      time: performance.now(),
      targetDirection: physics.currentDirection
    };
    directionSpan.textContent = physics.currentDirection > 0 ? '→' : '←';
    scheduleDriftChange();
  }, interval);
}

function gameLoop(timestamp) {

  if (!isRunning) return;

  const deltaTime = (timestamp - lastFrame) / 1000;
  lastFrame = timestamp;
  totalElapsed += deltaTime;

  let userInput = 0;
  if (keys.KeyA) userInput -= physics.controlForce;
  if (keys.KeyD) userInput += physics.controlForce;

  const driftAccel = physics.driftForce * physics.currentDirection;
  const frictionAccel = -physics.velocity * physics.friction;
  const totalAccel = driftAccel + frictionAccel + userInput;

  physics.velocity += totalAccel * deltaTime;
  physics.velocity = Math.max(-physics.maxSpeed, Math.min(physics.maxSpeed, physics.velocity));

  physics.position += physics.velocity * deltaTime;

  const gameAreaWidth = 560;
  const targetWidth = 40;
  physics.position = Math.max(-(gameAreaWidth - targetWidth) / 2, Math.min((gameAreaWidth - targetWidth) / 2, physics.position));

  target.style.left = `${260 + physics.position}px`;

  const deviation = Math.abs(physics.position);
  deviationSpan.textContent = deviation.toFixed(2);
  overallDeviationSum += deviation;
  overallSamples++;
  deviationSamples.push({ value: deviation, timestamp: Date.now() / 1000 });

  if (Math.abs(physics.position) < centerThreshold) {
    centerTime += deltaTime;
  }

  const elapsedTime = (Date.now() - testStartTime) / 1000;
  const remainingTime = Math.max(0, totalTestTime - elapsedTime);
  const progressPercent = (elapsedTime / totalTestTime) * 100;
  progressFill.style.width = `${progressPercent}%`;
  progressText.textContent = formatTime(elapsedTime);

  if (elapsedTime >= totalTestTime) {
    endTest();
    return;
  }

  animationFrame = requestAnimationFrame(gameLoop);
}

startBtn.addEventListener('click', () => {
  if (!isRunning) {
    timeModal.style.display = 'flex';
  }
});

timeOptions.forEach(option => {
  option.addEventListener('click', () => {
    totalTestTime = parseInt(option.getAttribute('data-minutes')) * 60;
    timeModal.style.display = 'none';
    startTest();
  });
});

function startTest() {
  if (isRunning) return;
  isRunning = true;
  testStartTime = Date.now();
  startBtn.textContent = 'Тест идёт...';

  physics.position = 0;
  physics.velocity = 0;
  physics.driftForce = 0;
  physics.controlForce = 100;
  physics.currentDirection = 1;
  updateDifficulty.currentLevel = 0;
  totalElapsed = 0;
  overallDeviationSum = 0;
  overallSamples = 0;
  deviationSamples = [];
  reactionTimes = [];
  reactionTimestamps = [];
  pendingDriftReaction = null;
  centerTime = 0;
  lastFrame = performance.now();
  target.style.left = '26а0px';
  directionSpan.textContent = physics.currentDirection > 0 ? '→' : '←';
  deviationSpan.textContent = '0.00';
  finalResultSpan.textContent = '0';
  avgReactionSpan.textContent = '0';
  centerPercentSpan.textContent = '0';
  lastMinuteAvgDeviationSpan.textContent = '0';
  lastMinuteAvgReactionSpan.textContent = '0';
  lastMinuteCenterPercentSpan.textContent = '0';

  clearTimeout(driftTimeout);
  // фвввыфвфвыфвф
  scheduleDriftChange();
  requestAnimationFrame(gameLoop);

  lastMinuteInterval = setInterval(updateLastMinuteStats, 60000);
}

window.addEventListener('keydown', (e) => {
  if (isRunning && keys.hasOwnProperty(e.code)) {
    keys[e.code] = true;
    if (pendingDriftReaction) {
      if ((pendingDriftReaction.targetDirection > 0 && e.code === 'KeyA') ||
          (pendingDriftReaction.targetDirection < 0 && e.code === 'KeyD')) {
        const reactionTime = performance.now() - pendingDriftReaction.time;
        reactionTimes.push(reactionTime);
        reactionTimestamps.push(Date.now() / 1000);
        pendingDriftReaction = null;
      }
    }
  }
});

window.addEventListener('keyup', (e) => {
  if (keys.hasOwnProperty(e.code)) keys[e.code] = false;
});

function endTest() {
  isRunning = false;
  startBtn.textContent = 'Начать заново';
  clearTimeout(driftTimeout);
  cancelAnimationFrame(animationFrame);
  clearInterval(lastMinuteInterval);

  const overallAvg = overallSamples ? (overallDeviationSum / overallSamples) : 0;
  finalResultSpan.textContent = overallAvg.toFixed(2);

  const avgReaction = reactionTimes.length ? reactionTimes.reduce((a, b) => a + b) / reactionTimes.length : 0;
  avgReactionSpan.textContent = avgReaction.toFixed(0);



  const centerPercent = totalElapsed ? (centerTime / totalElapsed * 100) : 0;
  centerPercentSpan.textContent = centerPercent.toFixed(2);

  updateLastMinuteStats();
  updateFooter();
}

toggleOverallStatsBtn.addEventListener('click', () => {
  if (overallStatsContent.classList.contains('collapsed')) {
    overallStatsContent.classList.remove('collapsed');
    overallStatsContent.classList.add('expanded');
    toggleOverallStatsBtn.textContent = 'Свернуть';
  } else {
    overallStatsContent.classList.remove('expanded');
    overallStatsContent.classList.add('collapsed');
    toggleOverallStatsBtn.textContent = 'Развернуть';
  }
});

toggleLastMinuteStatsBtn.addEventListener('click', () => {
  if (lastMinuteStatsContent.classList.contains('collapsed')) {
    lastMinuteStatsContent.classList.remove('collapsed');
    lastMinuteStatsContent.classList.add('expanded');
    toggleLastMinuteStatsBtn.textContent = 'Свернуть';
  } else {
    lastMinuteStatsContent.classList.remove('expanded');
    lastMinuteStatsContent.classList.add('collapsed');
    toggleLastMinuteStatsBtn.textContent = 'Развернуть';
  }
});

overallStatsContent.classList.add('expanded');
lastMinuteStatsContent.classList.add('expanded');
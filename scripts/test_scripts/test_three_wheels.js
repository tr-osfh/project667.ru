// Элементы canvas и кнопки
const canvas1 = document.getElementById('wheel1');
const canvas2 = document.getElementById('wheel2');
const canvas3 = document.getElementById('wheel3');

const ctx1 = canvas1.getContext('2d');
const ctx2 = canvas2.getContext('2d');
const ctx3 = canvas3.getContext('2d');

const startBtn = document.getElementById('start');
const firstBtn = document.getElementById('first');
const secondBtn = document.getElementById('second');
const thirdBtn = document.getElementById('third');
const buttons = [firstBtn, secondBtn, thirdBtn];
const timeModal = document.getElementById('time-modal');
const timeOptions = document.querySelectorAll('.time-option');
const toggleOverallStatsBtn = document.getElementById('toggle-overall-stats');
const toggleLastMinuteStatsBtn = document.getElementById('toggle-last-minute-stats');
const overallStatsContent = document.getElementById('overall-stats-content');
const lastMinuteStatsContent = document.getElementById('last-minute-stats-content');
const wheelStatsContent = document.getElementById('wheel-stats-content');
const toggleWheelStatsBtn = document.getElementById('toggle-wheel-stats');

// Константы
const WIDTH = 300;
const HEIGHT = 300;
const CENTER_X = WIDTH / 2;
const CENTER_Y = HEIGHT / 2;
const RADIUS = 120;
const DOT_RADIUS = 10;
const SPEEDS = [0.03, 0.05, 0.07];

// Переменные
let angles = [0, 0, 0];
let testRunning = false;
let currentStage = 1;
let animationFrameId;
let totalTestTime = 0;
let stageDuration = 0;
let startTime = 0;
let stats = {
    1: { hits: 0, misses: 0, attempts: 0, reactionTimes: [], timestamps: [] },
    2: { hits: 0, misses: 0, attempts: 0, reactionTimes: [], timestamps: [] },
    3: { hits: 0, misses: 0, attempts: 0, reactionTimes: [], timestamps: [] }
};
let testStartTime = 0;
let lastMinuteInterval;

// Проверка на приватный режим
function isPrivateMode() {
    const path = window.location.pathname;
    const query = window.location.search;
    return path.includes('private') || query.includes('mode=private');
}

const isPrivate = isPrivateMode();

// Экран загрузки
async function data_load() {
    const element = document.getElementById("loading");
    element.style.opacity = '1';
    element.style.display = 'flex';
    
    await new Promise(resolve => setTimeout(resolve, 5000));
    
    element.style.opacity = '0';
    await new Promise(resolve => setTimeout(resolve, 1000));
    element.style.display = 'none';
}

// Форматирование времени (секунды в MM:SS)
function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${minutes}:${secs < 10 ? '0' + secs : secs}`;
}

// Вычисление стандартного отклонения
function calculateStandardDeviation(times) {
    if (times.length === 0) return 0;
    const mean = times.reduce((sum, time) => sum + time, 0) / times.length;
    const variance = times.reduce((sum, time) => sum + Math.pow(time - mean, 2), 0) / times.length;
    return Math.sqrt(variance);
}

// Вычисление статистики за последние 60 секунд
function calculateLastMinuteStats() {
    const now = Date.now() / 1000;
    const lastMinuteStats = {
        hits: 0,
        misses: 0,
        attempts: 0,
        reactionTimes: []
    };

    Object.keys(stats).forEach(stage => {
        const stageStats = stats[stage];
        for (let i = 0; i < stageStats.attempts; i++) {
            const timestamp = stageStats.timestamps[i];
            if (now - timestamp <= 60) {
                lastMinuteStats.attempts++;
                if (i < stageStats.hits) lastMinuteStats.hits++;
                else lastMinuteStats.misses++;
                lastMinuteStats.reactionTimes.push(stageStats.reactionTimes[i]);
            }
        }
    });

    const avgTime = lastMinuteStats.reactionTimes.length > 0 
        ? lastMinuteStats.reactionTimes.reduce((a, b) => a + b, 0) / lastMinuteStats.reactionTimes.length 
        : 0;
    const accuracy = lastMinuteStats.attempts > 0 
        ? (lastMinuteStats.hits / lastMinuteStats.attempts * 100) 
        : 0;

    return {
        hits: lastMinuteStats.hits,
        misses: lastMinuteStats.misses,
        accuracy: accuracy.toFixed(2),
        avgTime: avgTime.toFixed(2)
    };
}

// Обновление статистики за последнюю минуту
function updateLastMinuteStats() {
    const lastMinuteStats = calculateLastMinuteStats();
    document.getElementById('last-minute-hits').textContent = lastMinuteStats.hits;
    document.getElementById('last-minute-misses').textContent = lastMinuteStats.misses;
    document.getElementById('last-minute-accuracy').textContent = lastMinuteStats.accuracy + '%';
    document.getElementById('last-minute-avg-time').textContent = lastMinuteStats.avgTime + ' мс';
}

// Вычисление общей статистики
function calculateAverageStats() {
    const totalReactionTimes = [].concat(...Object.values(stats).map(s => s.reactionTimes));
    const totalHits = Object.values(stats).reduce((sum, s) => sum + s.hits, 0);
    const totalMisses = Object.values(stats).reduce((sum, s) => sum + s.misses, 0);
    const totalAttempts = Object.values(stats).reduce((sum, s) => sum + s.attempts, 0);

    const avgTime = totalReactionTimes.length > 0 
        ? totalReactionTimes.reduce((a, b) => a + b, 0) / totalReactionTimes.length 
        : 0;
    const accuracy = totalAttempts > 0 ? (totalHits / totalAttempts * 100) : 0;
    const earlyTimes = totalReactionTimes.filter(t => t < 0);
    const lateTimes = totalReactionTimes.filter(t => t > 0);
    const earlyMean = earlyTimes.length > 0 ? earlyTimes.reduce((a, b) => a + b, 0) / earlyTimes.length : 0;
    const lateMean = lateTimes.length > 0 ? lateTimes.reduce((a, b) => a + b, 0) / lateTimes.length : 0;
    const absMean = totalReactionTimes.length > 0 ? totalReactionTimes.reduce((a, b) => a + Math.abs(b), 0) / totalReactionTimes.length : 0;
    const stdDevAbs = calculateStandardDeviation(totalReactionTimes.map(t => Math.abs(t)));
    const stdDev = calculateStandardDeviation(totalReactionTimes);

    return {
        hits: totalHits,
        misses: totalMisses,
        attempts: totalAttempts,
        accuracy: accuracy.toFixed(2),
        avgTime: avgTime.toFixed(2),
        earlyMean: earlyMean.toFixed(2),
        lateMean: lateMean.toFixed(2),
        absMean: absMean.toFixed(2),
        stdDevAbs: stdDevAbs.toFixed(2),
        stdDev: stdDev.toFixed(2)
    };
}

// Функция для обновления таблицы результатов в футере
function updateFooter() {
    let now = new Date();
    let year = now.getFullYear();
    let month = String(now.getMonth() + 1).padStart(2, '0');
    let day = String(now.getDate()).padStart(2, '0'); 
    let dbFormattedDate = `${year}-${month}-${day}`;

    const avgStats = calculateAverageStats();
    const lastMinuteStats = calculateLastMinuteStats();

    
    let data = {
        table_name: 'test_three_wheels',
        avg_time: avgStats.avgTime,
        accuracy: avgStats.hits,
        misses: avgStats.misses,
        accuracy_percent: avgStats.accuracy,
        early_mean: avgStats.earlyMean,
        late_mean: avgStats.lateMean,
        abs_mean: avgStats.absMean,
        std_dev_abs: avgStats.stdDevAbs,
        std_dev: avgStats.stdDev,
        date: dbFormattedDate,
        test: 'test_three_wheels.php'
    };

    const urlEncodedData = new URLSearchParams(data).toString();
    try {
        if(!isPrivate) {
        fetch(`https://group667.online/scripts/addTestRes.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: urlEncodedData
        });
    }
    } catch (error) {
        console.error('Ошибка:', error);
    }

    data_load().then(() => {
        if (!isPrivate) {
        window.location.href = "https://group667.online/tests/test_three_wheels.php";
        }
    });
}

// Рисование стилизованной стрелки
function drawArrow(ctx, centerX, centerY, radius) {
    const arrowBaseOffset = radius * 0.2;
    const arrowTipOffset = radius * 0.07;
    const arrowWidthHalf = radius * 0.12;

    const arrowGradient = ctx.createLinearGradient(
        centerX, 
        centerY - radius - arrowBaseOffset, 
        centerX, 
        centerY - radius + arrowTipOffset
    );
    arrowGradient.addColorStop(0, '#333');
    arrowGradient.addColorStop(1, '#000');

    ctx.beginPath();
    ctx.moveTo(centerX, centerY - radius + arrowTipOffset);
    ctx.lineTo(centerX + arrowWidthHalf, centerY - radius - arrowBaseOffset);
    ctx.lineTo(centerX - arrowWidthHalf, centerY - radius - arrowBaseOffset);
    ctx.closePath();
    ctx.fillStyle = arrowGradient;
    ctx.fill();
    ctx.lineWidth = 1;
    ctx.strokeStyle = '#fff';
    ctx.stroke();
}

// Рисование колеса
function drawWheel(ctx, angle, centerX, centerY, radius, isActive) {
    ctx.clearRect(0, 0, WIDTH, HEIGHT);

    ctx.beginPath();
    ctx.arc(centerX, centerY, radius, 0, Math.PI * 2);
    ctx.strokeStyle = 'black';
    ctx.lineWidth = 2;
    ctx.stroke();

    if (isActive) {
        const dotX = centerX + radius * Math.cos(angle);
        const dotY = centerY + radius * Math.sin(angle);
        ctx.beginPath();
        ctx.arc(dotX, dotY, DOT_RADIUS, 0, Math.PI * 2);
        ctx.fillStyle = 'red';
        ctx.fill();
    }

    drawArrow(ctx, centerX, centerY, radius);
}

// Проверка попадания
function checkAlignment(angle) {
    const targetAngle = 3 * Math.PI / 2;
    const diff = Math.abs((angle - targetAngle) % (2 * Math.PI));
    const minDiff = Math.min(diff, 2 * Math.PI - diff);
    return minDiff < 0.1;
}

// Время реакции (в миллисекундах)
function calculateReactionTime(angle, stage) {
    const targetAngle = 3 * Math.PI / 2;
    let diff = (angle - targetAngle) % (2 * Math.PI);
    if (diff > Math.PI) diff -= 2 * Math.PI;
    if (diff < -Math.PI) diff += 2 * Math.PI;
    const timeInSeconds = diff / (SPEEDS[stage - 1] * 60);
    return timeInSeconds * 1000; // Переводим в миллисекунды
}

// Подсветка кнопки
function highlightButton(stage) {
    buttons.forEach(btn => btn.classList.remove('active'));
    if (stage === 1) firstBtn.classList.add('active');
    else if (stage === 2) secondBtn.classList.add('active');
    else if (stage === 3) thirdBtn.classList.add('active');
}

// Обновление прогресс-бара (по времени)
function updateProgressBar(stage) {
    if (!testRunning) return;

    const elapsedTime = (Date.now() - startTime) / 1000;
    const remainingTime = Math.max(0, stageDuration - elapsedTime);
    const progressPercent = (remainingTime / stageDuration) * 100;

    const progressFill = document.getElementById(`progress-fill${stage}`);
    const progressText = document.getElementById(`progress-text${stage}`);
    progressFill.style.width = `${progressPercent}%`;
    progressText.textContent = formatTime(remainingTime);

    [1, 2, 3].forEach(s => {
        if (s !== stage) {
            document.getElementById(`progress-fill${s}`).style.width = '0%';
            document.getElementById(`progress-text${s}`).textContent = formatTime(0);
        }
    });

    if (remainingTime <= 0) {
        currentStage++;
        if (currentStage > 3) {
            endTest();
        } else {
            startTime = Date.now();
            highlightButton(currentStage);
        }
    }
}

// Обновление статистики по колесам
function updateWheelStats(stage) {
    const stageStats = stats[stage];
    const hits = stageStats.hits;
    const misses = stageStats.misses;
    const attempts = stageStats.attempts;
    const accuracy = attempts > 0 ? (hits / attempts * 100).toFixed(2) : 0;
    const avgTime = stageStats.reactionTimes.length > 0 
        ? (stageStats.reactionTimes.reduce((a, b) => a + b, 0) / stageStats.reactionTimes.length).toFixed(2) 
        : 0;

    document.getElementById(`wheel${stage}-hits`).textContent = hits;
    document.getElementById(`wheel${stage}-misses`).textContent = misses;
    document.getElementById(`wheel${stage}-accuracy`).textContent = accuracy + '%';
    document.getElementById(`wheel${stage}-avg-time`).textContent = avgTime + ' мс';
}

// Обработка нажатия кнопки
function handleButtonPress(stage) {
    if (!testRunning || stage !== currentStage) return;

    const angle = angles[stage - 1];
    const isAligned = checkAlignment(angle);

    stats[stage].attempts++;
    if (isAligned) stats[stage].hits++;
    else stats[stage].misses++;

    const reactionTime = calculateReactionTime(angle, stage);
    stats[stage].reactionTimes.push(reactionTime);
    stats[stage].timestamps.push(Date.now() / 1000);

    updateWheelStats(stage); // Обновляем статистику по колесу
}

// Анимация
function animate() {
    if (!testRunning) return;

    if (currentStage === 1) angles[0] += SPEEDS[0];
    else if (currentStage === 2) angles[1] += SPEEDS[1];
    else if (currentStage === 3) angles[2] += SPEEDS[2];

    drawWheel(ctx1, angles[0], CENTER_X, CENTER_Y, RADIUS, currentStage === 1);
    drawWheel(ctx2, angles[1], CENTER_X, CENTER_Y, RADIUS, currentStage === 2);
    drawWheel(ctx3, angles[2], CENTER_X, CENTER_Y, RADIUS, currentStage === 3);

    updateProgressBar(currentStage);

    animationFrameId = requestAnimationFrame(animate);
}

// Показ модального окна для выбора времени
startBtn.addEventListener('click', () => {
    if (!testRunning) {
        timeModal.style.display = 'flex';
    }
});

// Обработчики выбора времени
timeOptions.forEach(option => {
    option.addEventListener('click', () => {
        totalTestTime = parseInt(option.getAttribute('data-minutes')) * 60;
        stageDuration = totalTestTime / 3;
        timeModal.style.display = 'none';
        startTest();
    });
});

// Запуск теста
function startTest() {
    testRunning = true;
    testStartTime = Date.now();
    startBtn.textContent = 'Тест идёт...';
    currentStage = 1;
    angles = [0, 0, 0];
    stats = {
        1: { hits: 0, misses: 0, attempts: 0, reactionTimes: [], timestamps: [] },
        2: { hits: 0, misses: 0, attempts: 0, reactionTimes: [], timestamps: [] },
        3: { hits: 0, misses: 0, attempts: 0, reactionTimes: [], timestamps: [] }
    };
    startTime = Date.now();
    highlightButton(currentStage);
    animate();

    // Обновляем статистику каждые 60 секунд
    lastMinuteInterval = setInterval(updateLastMinuteStats, 60000);
}

// Обработчики кнопок
firstBtn.addEventListener('click', () => handleButtonPress(1));
secondBtn.addEventListener('click', () => handleButtonPress(2));
thirdBtn.addEventListener('click', () => handleButtonPress(3));

// Завершение теста
function endTest() {
    testRunning = false;
    startBtn.textContent = 'Начать заново';
    cancelAnimationFrame(animationFrameId);
    buttons.forEach(btn => btn.classList.remove('active'));
    clearInterval(lastMinuteInterval); // Останавливаем таймер
    updateLastMinuteStats(); // Финальное обновление
    updateFooter();
} 

// Обработчики сворачивания/разворачивания статистики
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

toggleWheelStatsBtn.addEventListener('click', () => {
    if (wheelStatsContent.classList.contains('collapsed')) {
        wheelStatsContent.classList.remove('collapsed');
        wheelStatsContent.classList.add('expanded');
        toggleWheelStatsBtn.textContent = 'Свернуть';
    } else {
        wheelStatsContent.classList.remove('expanded');
        wheelStatsContent.classList.add('collapsed');
        toggleWheelStatsBtn.textContent = 'Развернуть';
    }
});

// Начальная отрисовка
drawWheel(ctx1, angles[0], CENTER_X, CENTER_Y, RADIUS, false);
drawWheel(ctx2, angles[1], CENTER_X, CENTER_Y, RADIUS, false); 
drawWheel(ctx3, angles[2], CENTER_X, CENTER_Y, RADIUS, false);

// Инициализация состояния статистики (по умолчанию развернуто)
overallStatsContent.classList.add('expanded');
lastMinuteStatsContent.classList.add('expanded');
wheelStatsContent.classList.add('expanded');
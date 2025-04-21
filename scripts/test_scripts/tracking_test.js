// Элементы canvas и кнопки
const canvas1 = document.getElementById('wheel1');
const ctx1 = canvas1.getContext('2d');
const startBtn = document.getElementById('start');
const firstBtn = document.getElementById('first');
const buttons = [firstBtn];

// Константы
const WIDTH = 300;
const HEIGHT = 300;
const CENTER_X = WIDTH / 2;
const CENTER_Y = HEIGHT / 2;
const RADIUS = 120;
const DOT_RADIUS = 10;
const SPEEDS = [0.03, 0.05, 0.07]; // Разные скорости: первый - 0.03, второй - 0.05, третий - 0.07

// Переменные
let angles = [0, 0, 0];
let testRunning = false;
let currentStage = 1;
let animationFrameId;
let stats = {
    1: { hits: 0, misses: 0, attempts: 0, reactionTimes: [] },
    2: { hits: 0, misses: 0, attempts: 0, reactionTimes: [] },
    3: { hits: 0, misses: 0, attempts: 0, reactionTimes: [] }
};

// Экран загрузки
async function data_load() {
    const element = document.getElementById("loading");
    element.style.opacity = '1';
    element.style.display = 'flex';
    
    // Имитация асинхронной операции
    await new Promise(resolve => setTimeout(resolve, 5000));
    
    element.style.opacity = '0';
    await new Promise(resolve => setTimeout(resolve, 1000));
    element.style.display = 'none';
}

// Вычисление стандартного отклонения
function calculateStandardDeviation(times) {
    if (times.length === 0) return 0;
    const mean = times.reduce((sum, time) => sum + time, 0) / times.length;
    const variance = times.reduce((sum, time) => sum + Math.pow(time - mean, 2), 0) / times.length;
    return Math.sqrt(variance);
}

// Вычисление средней статистики по всем этапам
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
/* function updateFooter() {
    let now = new Date();
    let year = now.getFullYear();
    let month = String(now.getMonth() + 1).padStart(2, '0');
    let day = String(now.getDate()).padStart(2, '0'); 
    let dbFormattedDate = `${year}-${month}-${day}`;

    const avgStats = calculateAverageStats();

     let data = {
        table_name: 'test_three_wheels',
        avg_time: avgStats.avgTime,            // Среднее время реакции
        accuracy: avgStats.hits,               // Общее количество попаданий
        misses: avgStats.misses,               // Общее количество промахов
        accuracy_percent: avgStats.accuracy,   // Средняя точность в процентах
        early_mean: avgStats.earlyMean,        // Среднее время ранних ответов
        late_mean: avgStats.lateMean,          // Среднее время поздних ответов
        abs_mean: avgStats.absMean,            // Среднее время по модулю
        std_dev_abs: avgStats.stdDevAbs,       // Стандартное отклонение по модулю
        std_dev: avgStats.stdDev,              // Стандартное отклонение с учетом знака
        date: dbFormattedDate,
        test: 'test_three_wheels.php'
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
        window.location.href = "https://group667.online/tests/test_three_wheels.php";
    });
} */

// Рисование стилизованной стрелки
function drawArrow(ctx, centerX, centerY, radius) {
    const arrowBaseOffset = radius * 0.2; // Смещение основания стрелки
    const arrowTipOffset = radius * 0.07;   // Смещение кончика стрелки
    const arrowWidthHalf = radius * 0.12;  // Половина ширины основания

    const arrowGradient = ctx.createLinearGradient(
        centerX, 
        centerY - radius - arrowBaseOffset, 
        centerX, 
        centerY - radius + arrowTipOffset
    );
    arrowGradient.addColorStop(0, '#333'); // Начало градиента
    arrowGradient.addColorStop(1, '#000'); // Конец градиента

    ctx.beginPath();
    ctx.moveTo(centerX, centerY - radius + arrowTipOffset); // Кончик стрелки
    ctx.lineTo(centerX + arrowWidthHalf, centerY - radius - arrowBaseOffset); // Правое основание
    ctx.lineTo(centerX - arrowWidthHalf, centerY - radius - arrowBaseOffset); // Левое основание
    ctx.closePath();
    ctx.fillStyle = arrowGradient;
    ctx.fill();
    ctx.lineWidth = 1;
    ctx.strokeStyle = '#fff'; // Белая обводка
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
    const targetAngle = 3 * Math.PI / 2; // Верхняя точка
    const diff = Math.abs((angle - targetAngle) % (2 * Math.PI));
    const minDiff = Math.min(diff, 2 * Math.PI - diff);
    return minDiff < 0.1; // Допустимая погрешность
}

// Время реакции
function calculateReactionTime(angle, stage) {
    const targetAngle = 3 * Math.PI / 2;
    let diff = (angle - targetAngle) % (2 * Math.PI);
    if (diff > Math.PI) diff -= 2 * Math.PI;
    if (diff < -Math.PI) diff += 2 * Math.PI;
    return diff / (SPEEDS[stage - 1] * 60); // Учитываем скорость текущего этапа
}

// Подсветка кнопки
function highlightButton(stage) {
    buttons.forEach(btn => btn.classList.remove('active'));
    if (stage === 1) firstBtn.classList.add('active');
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

    if (stats[stage].attempts >= 5) {
        currentStage++;
        if (currentStage > 3) endTest();
        else highlightButton(currentStage);
    }
}

// Анимация
function animate() {
    if (!testRunning) return;

    if (currentStage === 1) angles[0] += SPEEDS[0];
    else if (currentStage === 2) angles[1] += SPEEDS[1];
    else if (currentStage === 3) angles[2] += SPEEDS[2];

    drawWheel(ctx1, angles[0], CENTER_X, CENTER_Y, RADIUS, currentStage === 1);
    
    animationFrameId = requestAnimationFrame(animate);
}

// Запуск теста
startBtn.addEventListener('click', () => {
    if (!testRunning) {
        testRunning = true;
        startBtn.textContent = 'Тест идёт...';
        currentStage = 1;
        angles = [0, 0, 0];
        stats = {
            1: { hits: 0, misses: 0, attempts: 0, reactionTimes: [] },
            2: { hits: 0, misses: 0, attempts: 0, reactionTimes: [] },
            3: { hits: 0, misses: 0, attempts: 0, reactionTimes: [] }
        };
        highlightButton(currentStage);
        animate();
    }
});

// Обработчики кнопок
firstBtn.addEventListener('click', () => handleButtonPress(1));



// Завершение теста
 function endTest() {
    testRunning = false;
    startBtn.textContent = 'Начать заново';
    cancelAnimationFrame(animationFrameId);
    buttons.forEach(btn => btn.classList.remove('active'));
    updateFooter(); // Отправляем результаты, включая среднюю статистику
}

// Начальная отрисовка
drawWheel(ctx1, angles[0], CENTER_X, CENTER_Y, RADIUS, false);
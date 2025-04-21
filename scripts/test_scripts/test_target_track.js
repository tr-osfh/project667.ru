const startBtn = document.getElementById('start');
const avgTimeDisplay = document.getElementById('avg-time');
const accuracyDisplay = document.getElementById('accuracy');
const results = document.getElementById('results');
const body = document.body;
const goal = document.getElementById('goal');
const timerElement = document.getElementById('timer');
const target = document.getElementById('target');
const game_area = document.getElementById('game_area');
const timeModal = document.getElementById('time-modal');
const timeOptions = document.querySelectorAll('.time-option');
const progressFill = document.getElementById('progress-fill');
const progressText = document.getElementById('progress-text');
const progressContainer = document.getElementById('progress-container');

let timerInterval = null;
let startTime = 0;
let reactionTimes = [];
let testRunning = false;
let timeLeft = 120; // Начальное значение, будет переопределяться
let totalTestTime = 120; // Общее время теста в секундах
let secret_code = false;
let time_test;
let goalX = 0;
let targetX = 300;
let direction = 1;
let speed = 2;
let lastDirChange = Date.now();
let maxCorrectTime = 0;
let currentInsideTime = 0;
let insideStartTime = null;
let lastFrameTime = null;

function isPrivateMode() {
    const path = window.location.pathname;
    const query = window.location.search;
    return path.includes('private') || query.includes('mode=private');
}

const isPrivate = isPrivateMode();

// Форматирование времени (MM:SS)
function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
}

// Двигаем цель
function movegoal(timestamp) {
    if (!testRunning) return;

    // Расчёт времени между кадрами
    if (lastFrameTime === null) lastFrameTime = timestamp;
    const delta = timestamp - lastFrameTime;
    lastFrameTime = timestamp;

    goalX += speed * direction;

    // Проверка на столкновение с краем и реакция
    if (goalX <= 0) {
        goalX = 0;
        direction = 1;
        recordReaction();
    } else if (goalX >= 634 - goal.offsetWidth) {
        goalX = 634 - goal.offsetWidth;
        direction = -1;
        recordReaction();
    }

    goal.style.left = goalX + 'px';
    updateCorrectTime();
    updateProgressBar(); // Обновляем прогресс-бар
    requestAnimationFrame(movegoal);
}

function updateCorrectTime() {
    const isInside = Math.abs(goalX - targetX) < 30;
    const now = Date.now();

    if (isInside) {
        if (insideStartTime === null) {
            insideStartTime = now; // Начало нового пересечения
        }
        currentInsideTime = now - insideStartTime;
        if (currentInsideTime > maxCorrectTime) {
            maxCorrectTime = currentInsideTime;
        }
    } else {
        insideStartTime = null; // Сброс, вышли из зоны
        currentInsideTime = 0;
    }

    // Обновляем отображение точности (в миллисекундах)
    accuracyDisplay.textContent = maxCorrectTime;
}

// Меняем скорость и направление каждые 2-5 сек
function light() {
    setInterval(() => {
        const now = Date.now();
        const timeSinceLastChange = now - lastDirChange;
        if (timeSinceLastChange > 2000 + Math.random() * 3000) {
            direction = Math.random() > 0.5 ? 1 : -1;
            speed = 1 + Math.random() * 4;
            lastDirChange = now;
            recordReaction();
        }
    }, 100);
}

// Подсчёт реакции
function recordReaction() {
    if (!startTime) return;
    let reaction = Date.now() - lastDirChange;
    reactionTimes.push(reaction);
    avgTimeDisplay.textContent = Math.floor(
        reactionTimes.reduce((a, b) => a + b, 0) / reactionTimes.length
    );
}

// Управление мишенью
document.addEventListener('keydown', (e) => {
    const step = 15;
    if (e.key === 'ArrowLeft') targetX -= step;
    if (e.key === 'ArrowRight') targetX += step;
    updateTarget();
});

let dragging = false;

const MAX_RIGHT = 600;

target.addEventListener('mousedown', (e) => {
    e.preventDefault();
    if (e.button === 0) {
        const rect = target.getBoundingClientRect();
        if (
            e.clientX >= rect.left &&
            e.clientX <= rect.right &&
            e.clientY >= rect.top &&
            e.clientY <= rect.bottom
        ) {
            dragging = true;
        }
    }
});

document.addEventListener('mouseup', () => {
    dragging = false;
});

document.addEventListener('mousemove', (e) => {
    if (testRunning && dragging) {
        const gameAreaRect = document.getElementById('game_area').getBoundingClientRect();
        let relativeX = e.clientX - gameAreaRect.left; // Координата внутри game_area
        let newX = relativeX - target.offsetWidth / 2;
        targetX = Math.max(0, Math.min(600 - target.offsetWidth, newX));
        updateTarget();
    }
});

function updateTarget() {
    target.style.left = targetX + 'px';
}

// Обновление прогресс-бара
function updateProgressBar() {
    if (!testRunning) return;

    const elapsedTime = (Date.now() - startTime) / 1000; // Прошедшее время в секундах
    const remainingTime = Math.max(0, totalTestTime - elapsedTime); // Оставшееся время
    const progressPercent = (remainingTime / totalTestTime) * 100; // Процент оставшегося времени

    progressFill.style.width = `${progressPercent}%`; // Обновляем ширину заполнения
    progressText.textContent = formatTime(remainingTime); // Обновляем текст времени
}

// Старт/завершение теста
startBtn.addEventListener('click', () => {
    if (startBtn.textContent === 'Выйти') {
        progressContainer.style.display = 'none';
        startBtn.textContent = 'Пройти ещё раз';
        goal.style.display = 'none';
        body.style.background = 'linear-gradient(135deg, #f0f4f8, #ffffff)';
        results.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
        results.style.color = '#333';
        const totalReactionTimes = reactionTimes;
        let now = new Date();
        let year = now.getFullYear();
        let month = String(now.getMonth() + 1).padStart(2, '0');
        let day = String(now.getDate()).padStart(2, '0'); 
        let dbFormattedDate = `${year}-${month}-${day}`;
        let data = {
            table_name: 'test_target_track',
            reaction_time: reactionTimes.reduce((sum, val) => sum + val, 0) / reactionTimes.length,
            max_correct_time: maxCorrectTime/1000,
            std_dev: calculateStandardDeviation(totalReactionTimes),
            date: dbFormattedDate,
            test: 'test_target_track.php'
        };
        console.log(data);
        const urlEncodedData = new URLSearchParams(data).toString();
        try {
            if (!isPrivate) {
            fetch(`https://group667.online/scripts/add_results/add_target_track.php`, {
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

        // drop_results();
        // data_load().then(() => {
        //     window.location.href = 'https://group667.online/tests/test_target_track.php';
        // });

    } else if (!testRunning) {
        timeModal.style.display = 'flex';   // Показываем модальное окно
    }
});

function calculateStandardDeviation(times) {
    if (times.length === 0) return 0;
    const mean = times.reduce((sum, time) => sum + time, 0) / times.length;
    const variance = times.reduce((sum, time) => sum + Math.pow(time - mean, 2), 0) / times.length;
    return Math.sqrt(variance);
}

// Обработчики выбора времени
timeOptions.forEach(option => {
    option.addEventListener('click', () => {
        totalTestTime = parseInt(option.getAttribute('data-minutes')) * 60; // Переводим минуты в секунды
        timeLeft = secret_code ? 10 : totalTestTime; // Если секретный код активирован, тест длится 10 секунд
        time_test = secret_code ? 15000 : (totalTestTime * 1000); // Переводим в миллисекунды
        timeModal.style.display = 'none'; // Скрываем модальное окно
        startTest(); // Запускаем тест
    });
});

function startTest() {
    progressContainer.style.display = 'block';
    testRunning = true;
    startTime = Date.now();
    goal.style.display = 'block';
    startBtn.textContent = 'Тест идёт...';
    body.style.background = '#333';
    results.style.backgroundColor = '#fcf6f7';
    startBtn.style.backgroundColor = '#B30000';
    startBtn.style.color = 'white';
    timerElement.style.display = 'block';
    game_area.style.display = 'block';  
    if (timerInterval) clearInterval(timerInterval);
    timerInterval = setInterval(updateTimer, 1000);
    updateTimer();
    light();
    movegoal(); // Старт движения цели
}

function drop_results() {
    reactionTimes = [];
    maxCorrectTime = 0;
    avgTimeDisplay.textContent = 0;
    accuracyDisplay.textContent = 0;
}

function updateTimer() {
    if (timeLeft <= 0) {
        clearInterval(timerInterval);
        timerElement.style.display = 'none';
        testRunning = false;
        startBtn.textContent = 'Выйти';
    } else {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        timeLeft--;
    }
}

async function data_load() {
    const element = document.getElementById('loading');
    element.style.opacity = '1';
    element.style.display = 'flex';

    await new Promise(resolve => setTimeout(resolve, 5000));

    element.style.opacity = '0';
    await new Promise(resolve => setTimeout(resolve, 1000));
    element.style.display = 'none';
    console.log('thinking');
}

// Секретный код (ctrl+m)
document.addEventListener('keydown', (event) => {
    if ((event.ctrlKey || event.metaKey) && event.key === 'm') {
        event.preventDefault();
        secret_code = true;
        console.log('Секретный код активирован!');
    }
});
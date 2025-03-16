const canvas = document.getElementById('wheel');
const ctx = canvas.getContext('2d');
const startBtn = document.getElementById('start');
const buttons = document.querySelectorAll('.color-btn');
const avgTimeDisplay = document.getElementById('avg-time');
const accuracyDisplay = document.getElementById('accuracy');
const missesDisplay = document.getElementById('misses');
const wrongDisplay = document.getElementById('wrong');

const colors = ['#4682B4', '#2E8B57', '#B30000'];
const totalCircles = 12;
let circleColors = [];
let currentColor = '';
let activeButton = null;
let startTime = 0;
let reactionTimes = [];
let correct = 0;
let misses = 0;
let wrong = 0;
let testRunning = false;
let wheelAngle = 0;
let timeoutId = null;
let lastTime = null; // Добавляем переменную для отслеживания времени

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
  
  // Сброс результатов перед запуском теста
  function dropResults() {
    reactionTimes = [];
    correct = 0;
    errors = 0;
    avgTimeDisplay.textContent = '0';
    accuracyDisplay.textContent = '0';
    errorsDisplay.textContent = '0';
    progressBar.value = 0; // Сбрасываем прогресс-бар
  }
  
  // Функция для обновления таблицы результатов в футере
  function updateFooter() {
    let now = new Date();
    let year = now.getFullYear();
    let month = String(now.getMonth() + 1).padStart(2, '0');
    let day = String(now.getDate()).padStart(2, '0'); 
    let dbFormattedDate = `${year}-${month}-${day}`;
    let data = {
        table_name: 'test_ruletka',
        avg_time: reactionTimes.reduce((a, b) => a + b, 0) / reactionTimes.length,
        accuracy: correct,
        misses: misses,
        date: dbFormattedDate,
        test: 'test_ruletka.php'
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
        window.location.href = "https://group667.online/tests/test_ruletka.php";
    });
  }

// Адаптивный размер canvas
function resizeCanvas() {
    const container = document.querySelector('.container');
    const size = Math.min(container.offsetWidth, 400);
    canvas.width = size;
    canvas.height = size;
    drawWheel();
}

function initializeCircleColors() {
    circleColors = [];
    for (let i = 0; i < totalCircles; i++) {
        circleColors.push(colors[i % colors.length]);
    }
}

function drawWheel() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const radius = canvas.width / 2.67;
    const circleRadius = canvas.width / 20;
    const innerRadius = radius - circleRadius - canvas.width / 40;

    const gradient = ctx.createRadialGradient(centerX, centerY, 0, centerX, centerY, radius);
    gradient.addColorStop(0, '#d0d0d0');
    gradient.addColorStop(1, '#808080');

    ctx.save();
    ctx.translate(centerX, centerY);
    ctx.rotate(wheelAngle);
    ctx.beginPath();
    ctx.arc(0, 0, radius, 0, 2 * Math.PI);
    ctx.fillStyle = gradient;
    ctx.fill();
    ctx.lineWidth = 2;
    ctx.strokeStyle = '#555';
    ctx.stroke();

    ctx.shadowBlur = 8;
    ctx.shadowColor = 'rgba(0, 0, 0, 0.3)';
    for (let i = 0; i < totalCircles; i++) {
        const circleAngle = (i * 2 * Math.PI) / totalCircles;
        const x = innerRadius * Math.cos(circleAngle);
        const y = innerRadius * Math.sin(circleAngle);
        ctx.beginPath();
        ctx.arc(x, y, circleRadius, 0, 2 * Math.PI);
        ctx.fillStyle = circleColors[i];
        ctx.fill();
        ctx.lineWidth = 2;
        ctx.strokeStyle = 'white';
        ctx.stroke();
    }
    ctx.shadowBlur = 0;
    ctx.restore();

    const arrowGradient = ctx.createLinearGradient(centerX, centerY - radius - 20, centerX, centerY - radius + 30);
    arrowGradient.addColorStop(0, '#333');
    arrowGradient.addColorStop(1, '#000');
    ctx.beginPath();
    ctx.moveTo(centerX, centerY - radius + 30);
    ctx.lineTo(centerX + 20, centerY - radius - 20);
    ctx.lineTo(centerX - 20, centerY - radius - 20);
    ctx.closePath();
    ctx.fillStyle = arrowGradient;
    ctx.fill();
    ctx.lineWidth = 1;
    ctx.strokeStyle = '#fff';
    ctx.stroke();
}

function spinWheel(timestamp) {
    if (!testRunning) return;

    if (!lastTime) lastTime = timestamp; // Устанавливаем начальное время
    const deltaTime = (timestamp - lastTime) / 1000; // Разница во времени в секундах
    lastTime = timestamp;

    const angularSpeed = 1.2; // Угловая скорость в радианах в секунду (можно настроить)
    wheelAngle += angularSpeed * deltaTime; // Увеличиваем угол пропорционально времени

    drawWheel();
    requestAnimationFrame(spinWheel);
}

function resetButtonColors() {
    buttons.forEach(button => {
        colors.forEach(color => {
            button.classList.remove(`active-${color.replace('#', '')}`);
        });
    });
    activeButton = null;
    currentColor = '';
    startTime = 0;
}

function highlightRandomButton() {
    resetButtonColors();
    const randomColorIndex = Math.floor(Math.random() * colors.length);
    currentColor = colors[randomColorIndex];
    
    buttons.forEach(button => {
        if (button.dataset.color === currentColor) {
            button.classList.add(`active-${currentColor.replace('#', '')}`);
            activeButton = button;
        }
    });
    
    startTime = performance.now();
    
    timeoutId = setTimeout(() => {
        if (startTime !== 0 && testRunning) {
            misses++;
            missesDisplay.textContent = misses;
            resetButtonColors();
            nextRound();
        }
    }, 2000);
}
function getCurrentColorUnderArrow() {
    // Положение стрелки — 3π/2 (270 градусов)
    const arrowAngle = 3 * Math.PI / 2;

    // Учитываем вращение колеса по часовой стрелке
    const effectiveAngle = (arrowAngle - wheelAngle) % (2 * Math.PI);

    // Приводим угол к диапазону [0, 2π)
    const normalizedAngle = (effectiveAngle + 2 * Math.PI) % (2 * Math.PI);

    // Вычисляем индекс кружка (всего 12 кружков)
    const totalCircles = 12;
    const fraction = (normalizedAngle / (2 * Math.PI)) * totalCircles;
    let circleIndex = Math.round(fraction) % totalCircles;

    // Если индекс равен totalCircles, сбрасываем на 0
    if (circleIndex === totalCircles) circleIndex = 0;

    // Возвращаем цвет кружка
    return circleColors[circleIndex];
}

startBtn.addEventListener('click', () => {
    if (!testRunning) {
        testRunning = true;
        startBtn.textContent = 'Тест идёт...';
        resetStats();
        lastTime = null; // Сбрасываем время при старте
        requestAnimationFrame(spinWheel); // Запускаем анимацию
        nextRound();
    } 
});

buttons.forEach(button => {
    button.addEventListener('click', () => {
        if (!testRunning || startTime === 0 || !activeButton) return;
        
        clearTimeout(timeoutId);

        const reactionTime = performance.now() - startTime;
        reactionTimes.push(reactionTime);
        startTime = 0;

        const clickedColor = button.dataset.color;
        const arrowColor = getCurrentColorUnderArrow();

        if (button === activeButton && clickedColor === arrowColor) {
            correct++;
            accuracyDisplay.textContent = correct;
        } else {
            wrong++;
            wrongDisplay.textContent = wrong;
        }

        updateAvgTime();
        resetButtonColors();
        nextRound();
    });
});

function nextRound() {
    if (reactionTimes.length < 10 && testRunning) {
        const delay = Math.random() * 2000 + 2000;
        setTimeout(() => {
            if (testRunning) highlightRandomButton();
        }, delay);
    } else {
        endTest();
    }
}

function updateAvgTime() {
    const avgTime = reactionTimes.length > 0 
        ? reactionTimes.reduce((a, b) => a + b, 0) / reactionTimes.length 
        : 0;
    avgTimeDisplay.textContent = Math.round(avgTime);
}

function endTest() {
    testRunning = false;
    startBtn.textContent = 'Начать заново';
    resetButtonColors();
    updateFooter();
}

function resetStats() {
    reactionTimes = [];
    correct = 0;
    misses = 0;
    wrong = 0;
    avgTimeDisplay.textContent = '0';
    accuracyDisplay.textContent = '0';
    missesDisplay.textContent = '0';
    wrongDisplay.textContent = '0';
    resetButtonColors();
}

// Инициализация
initializeCircleColors();
resizeCanvas();
window.addEventListener('resize', resizeCanvas);
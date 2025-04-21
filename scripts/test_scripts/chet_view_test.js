const startBtn = document.getElementById('start');
const evenBtn = document.getElementById('even');
const oddBtn = document.getElementById('odd');
const numbersDisplay = document.getElementById('numbers');
const avgTimeDisplay = document.getElementById('avg-time');
const accuracyDisplay = document.getElementById('accuracy');
const errorsDisplay = document.getElementById('errors');
const resultsFooter = document.getElementById('results-footer');
const progressBar = document.getElementById('progress-bar');
const stdDevDisplay = document.getElementById('std-dev'); // Новый элемент для std_dev

let questionsCount = 10;
let currentQuestion = 0;
let startTime = 0;
let reactionTimes = [];
let correct = 0;
let errors = 0;
let testRunning = false;
let currentQuestionData = null;

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

// Сброс результатов перед запуском теста
function dropResults() {
    reactionTimes = [];
    correct = 0;
    errors = 0;
    avgTimeDisplay.textContent = '0';
    accuracyDisplay.textContent = '0';
    errorsDisplay.textContent = '0';
    stdDevDisplay.textContent = '0'; // Сбрасываем std_dev
    progressBar.value = 0;
}

// Функция для расчёта стандартного отклонения
function calculateStandardDeviation(times) {
    if (times.length <= 1) return 0;
    const mean = times.reduce((a, b) => a + b, 0) / times.length;
    const squaredDiffs = times.reduce((sum, time) => sum + Math.pow(time - mean, 2), 0);
    const stdDev = Math.sqrt(squaredDiffs / (times.length - 1));
    return Math.round(stdDev);
}

// Функция для обновления таблицы результатов в футере
function updateFooter() {
    let now = new Date();
    let year = now.getFullYear();
    let month = String(now.getMonth() + 1).padStart(2, '0');
    let day = String(now.getDate()).padStart(2, '0'); 
    let dbFormattedDate = `${year}-${month}-${day}`;
    
    const stdDev = calculateStandardDeviation(reactionTimes);
    console.log("reactionTimes:", reactionTimes);
    console.log("std_dev:", stdDev);

    let data = {
        table_name: 'test_chet_view',
        avg_time: reactionTimes.length > 0 ? reactionTimes.reduce((a, b) => a + b, 0) / reactionTimes.length : 0,
        accuracy: correct,
        misses: errors,
        std_dev: stdDev, // Добавляем std_dev
        date: dbFormattedDate,
        test: 'chet_view_test.php'
    };
    const urlEncodedData = new URLSearchParams(data).toString();
    try { 
        if (!isPrivate) {
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
            window.location.href = "https://group667.online/tests/chet_view_test.php";
        }
    });
}

// Генерация вопроса (сложение двух чисел)
function generateQuestion() {
    const num1 = Math.floor(Math.random() * 50);
    const num2 = Math.floor(Math.random() * 50);
    return { num1, num2, sum: num1 + num2 };
}

function isEven(num) {
    return num % 2 === 0;
}

// Обновление статистики на странице
function updateAvgTime() {
    const avgTime = reactionTimes.length > 0 
        ? reactionTimes.reduce((a, b) => a + b, 0) / reactionTimes.length 
        : 0;
    avgTimeDisplay.textContent = Math.round(avgTime);

    const stdDev = calculateStandardDeviation(reactionTimes);
    stdDevDisplay.textContent = stdDev;

    accuracyDisplay.textContent = correct;
    errorsDisplay.textContent = errors;
}

// Переход к следующему вопросу
function nextQuestion() {
    if (currentQuestion >= questionsCount) {
        endTest();
        return;
    }
    currentQuestionData = generateQuestion();
    numbersDisplay.textContent = `${currentQuestionData.num1} + ${currentQuestionData.num2} = ?`;
    numbersDisplay.classList.add('visible');

    startTime = performance.now();
    evenBtn.disabled = false;
    oddBtn.disabled = false;
    currentQuestion++;
    progressBar.value = currentQuestion;
}

// Обработка выбора ответа
function handleAnswer(isEvenAnswer) {
    if (!testRunning || startTime === 0) return;

    const reactionTime = performance.now() - startTime;
    reactionTimes.push(reactionTime);
    startTime = 0;

    const correctAnswer = isEven(currentQuestionData.sum);
    if (isEvenAnswer === correctAnswer) {
        correct++;
    } else {
        errors++;
    }

    updateAvgTime();
    evenBtn.disabled = true;
    oddBtn.disabled = true;

    setTimeout(nextQuestion, 1000);
}

// Завершение теста
function endTest() {
    testRunning = false;
    startBtn.textContent = 'Начать заново';
    numbersDisplay.textContent = 'Тест завершён';
    updateFooter();
}

startBtn.addEventListener('click', () => {
    if (!testRunning) {
        testRunning = true;
        startBtn.textContent = 'Тест идёт...';
        dropResults();
        currentQuestion = 0;
        nextQuestion();
    }
});

evenBtn.addEventListener('click', () => handleAnswer(true));
oddBtn.addEventListener('click', () => handleAnswer(false));
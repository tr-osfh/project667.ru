
const startBtn = document.getElementById('start');
const evenBtn = document.getElementById('even');
const oddBtn = document.getElementById('odd');
const numbersDisplay = document.getElementById('numbers');
const avgTimeDisplay = document.getElementById('avg-time');
const accuracyDisplay = document.getElementById('accuracy');
const errorsDisplay = document.getElementById('errors');
const resultsFooter = document.getElementById('results-footer');
const progressBar = document.getElementById('progress-bar'); // Новый элемент

let questionsCount = 10; // Количество вопросов
let currentQuestion = 0;
let startTime = 0;
let reactionTimes = [];
let correct = 0;
let errors = 0;
let testRunning = false;
let currentQuestionData = null;

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
      table_name: 'test_chet_sound',
      avg_time: reactionTimes.reduce((a, b) => a + b, 0) / reactionTimes.length,
      accuracy: correct,
      misses: errors,
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
      });
  } catch (error) {
      console.error('Ошибка:', error);
  }
  data_load().then(() => {
      window.location.href = "https://group667.online/tests/chet_sound_test.php";
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
function updateResultsDisplay() {
  const avgTime = reactionTimes.reduce((a, b) => a + b, 0) / (reactionTimes.length || 1);
  avgTimeDisplay.textContent = Math.round(avgTime);
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
  const questionText = `${currentQuestionData.num1} плюс ${currentQuestionData.num2}`;

  numbersDisplay.textContent = 'Слушайте вопрос...';
  numbersDisplay.classList.remove('visible');
  numbersDisplay.classList.add('hidden');

  evenBtn.disabled = true;
  oddBtn.disabled = true;

  const utterance = new SpeechSynthesisUtterance(questionText);
  utterance.lang = 'ru-RU';
  utterance.onend = function() {
    startTime = performance.now();
    evenBtn.disabled = false;
    oddBtn.disabled = false;
  };
  speechSynthesis.speak(utterance);
  currentQuestion++;
  progressBar.value = currentQuestion; // Обновляем прогресс-бар
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

  updateResultsDisplay();
  evenBtn.disabled = true;
  oddBtn.disabled = true;

  setTimeout(nextQuestion, 1000);
}

// Завершение теста
function endTest() {
  testRunning = false;
  startBtn.textContent = 'Начать заново';
  numbersDisplay.textContent = 'Тест завершён';
  numbersDisplay.classList.remove('hidden');
  numbersDisplay.classList.add('visible');
  evenBtn.disabled = true;
  oddBtn.disabled = true;
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

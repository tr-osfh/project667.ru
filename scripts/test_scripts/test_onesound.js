const startBtn = document.getElementById('start');
const btn = document.getElementById('click_space_btn')
const avgTimeDisplay = document.getElementById('avg-time');
const accuracyDisplay = document.getElementById('accuracy');
const missesDisplay = document.getElementById('misses');
const results = document.getElementById('results');
const body = document.body;
const timerElement = document.getElementById("timer");
const sound_el = document.getElementById('sound');
const sound_img = document.getElementById('sound_img');

let startTime = 0;
let reactionTimes = [];
let correct = 0;
let misses = 0;
let testRunning = false;
let time_sound = 0;
let sound_count = 0;
let timeLeft = 120;
let click = false;
let secret_code = false;
let time_test;
let right = false;
const timerInterval = setInterval(updateTimer, 1000);

// Проверка для теста в приватном режиме
function isPrivateMode() {
    const path = window.location.pathname;
    const query = window.location.search;
    return path.includes('private') || query.includes('mode=private');
}

const isPrivate = isPrivateMode();

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

function drop_results(){
    reactionTimes = [];
    correct = 0;
    misses = 0;
    avgTimeDisplay.textContent = 0;
    missesDisplay.textContent = 0;
    accuracyDisplay.textContent = 0;
}

function updateTimer() {
    if (timeLeft <= 0) {
        clearInterval(timerInterval); 
        timerElement.style.display = 'none';
    } else {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        const formattedTime = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        timerElement.textContent = formattedTime;
        timeLeft--;
    }
}

function click_space(){
    if (right && sound_count >= correct) {
        reactionTimes.push(Date.now()-time_sound);
        correct ++;
        const avgTime = reactionTimes.reduce((a, b) => a + b, 0) / reactionTimes.length;
        avgTimeDisplay.textContent = Math.round(avgTime);
        accuracyDisplay.textContent = correct;
    } else {
        misses ++;
        missesDisplay.textContent = misses;
    }
    console.log(reactionTimes);
}

function sound() {
    const randomInteger = Math.floor(Math.random() * (4000 - 1500 + 1)) + 1500; 

    setTimeout(() => {
        right = true;
        sound_el.play();
        time_sound = Date.now();
        sound_count ++
        setTimeout(() => {
            const elapsedTime = Date.now() - startTime;
            if (elapsedTime < time_test) {
                sound();
            } else {
                testRunning = false; 
                startBtn.textContent = 'Выйти';
                timerElement.style.display = 'none';
            }
            if (!click) {
                misses ++
                missesDisplay.textContent = misses;
            } 
            click = false;
            right = false;
        }, 500);
    }, randomInteger);
}

startBtn.addEventListener('click', () => {
    if (startBtn.textContent == 'Выйти'){
        startBtn.textContent = 'Пройти ещё раз';
        btn.style.display = 'none';
        sound_img.style.display = 'none';
        body.style.background = 'linear-gradient(135deg, #f0f4f8, #ffffff)';
        results.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
        results.style.color = '#333';
        let now = new Date();
        let year = now.getFullYear();
        let month = String(now.getMonth() + 1).padStart(2, '0');
        let day = String(now.getDate()).padStart(2, '0'); 
        let dbFormattedDate = `${year}-${month}-${day}`;
        let data = {
            table_name: 'test_one_sound',
            avg_time: reactionTimes.reduce((a, b) => a + b, 0) / reactionTimes.length,
            accuracy: correct,
            misses: misses,
            date: dbFormattedDate,
            test: 'test_one_sound.php'
        };
        console.log(data);
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
        drop_results();
        data_load().then(() => {
            if (!isPrivate) {
                window.location.href = "https://group667.online/tests/test_one_sound.php";
            } else {
                startBtn.textContent = 'Пройти ещё раз';
            }
        });
        
    } else if (!testRunning) {
        if(secret_code){
            test_time = 15000;
            timeLeft = 10;
        } else {
            time_test = 120000;
            timeLeft = 120;
        }
        
        startTime = Date.now();
        testRunning = true;
        startBtn.textContent = 'Тест идёт...';
        btn.style.display = 'block';
        sound_img.style.display = 'block';
        body.style.background = '#333';
        results.style.backgroundColor = '#fcf6f7';
        startBtn.style.backgroundColor = '#B30000';
        startBtn.style.color = 'white';
        sound();
        timerElement.style.display = 'block';
        updateTimer();
    }
});

btn.addEventListener('click', () => {
    click = true
    click_space();
})

document.addEventListener('keydown', (event) => {
    event.preventDefault();
    if (testRunning){
        click = true
        if (event.code == 'Space') {
            event.preventDefault = false;
            click_space();
        }
    }
})

document.addEventListener('keydown', (event) => {
    if ((event.ctrlKey || event.metaKey) && event.key === 'm') {
        event.preventDefault();
        secret_code = true;
        console.log('Секретный код активирован!')
    }
});



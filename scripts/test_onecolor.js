const startBtn = document.getElementById('start');
const btn = document.getElementById('click_space_btn')
const avgTimeDisplay = document.getElementById('avg-time');
const accuracyDisplay = document.getElementById('accuracy');
const missesDisplay = document.getElementById('misses');
const results = document.getElementById('results');
const body = document.body;
const circle = document.getElementById('circle');
const timerElement = document.getElementById("timer");

let startTime = 0;
let reactionTimes = [];
let correct = 0;
let misses = 0;
let testRunning = false;
let time_light = 0;
let light_count = 0;
let timeLeft = 120;
let click = false;
let secret_code = false;
let time_test;
const timerInterval = setInterval(updateTimer, 1000);

async function data_load() {
    const element = document.getElementById("loading");
    element.style.opacity = '1';
    element.style.display = 'flex';
    
    // Имитация асинхронной операции
    await new Promise(resolve => setTimeout(resolve, 5000));
    
    element.style.opacity = '0';
    await new Promise(resolve => setTimeout(resolve, 1000));
    element.style.display = 'none';
    console.log('thinking');
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
    if (circle.classList.contains('active') && light_count >= correct) {
        reactionTimes.push(Date.now()-time_light);
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

function light() {
    const randomInteger = Math.floor(Math.random() * (4000 - 1500 + 1)) + 1500; 
    const randomInteger2 = Math.floor(Math.random() * (1000 - 500 + 1)) + 500; 

    setTimeout(() => {
        circle.classList.add('active');
        console.log(`Класс 'active' + через ${randomInteger} мс`);
        time_light = Date.now();
        light_count ++
        setTimeout(() => {
            circle.classList.remove('active');
            console.log(`Класс 'active' - через ${randomInteger2} мс`);
            const elapsedTime = Date.now() - startTime;
            if (elapsedTime < time_test) {
                light();
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
        }, randomInteger2);
    }, randomInteger);
}

startBtn.addEventListener('click', () => {
    if (startBtn.textContent == 'Выйти'){
        startBtn.textContent = 'Пройти ещё раз';
        btn.style.display = 'none';
        circle.style.display = 'none';
        body.style.background = 'linear-gradient(135deg, #f0f4f8, #ffffff)';
        results.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
        results.style.color = '#333';
        let now = new Date();
        let year = now.getFullYear();
        let month = String(now.getMonth() + 1).padStart(2, '0');
        let day = String(now.getDate()).padStart(2, '0'); 
        let dbFormattedDate = `${year}-${month}-${day}`;
        let data = {
            table_name: 'test_one_color',
            avg_time: reactionTimes.reduce((a, b) => a + b, 0) / reactionTimes.length,
            accuracy: correct,
            misses: misses,
            date: dbFormattedDate,
            test: 'test_one_color.php'
        };
        console.log(data);
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
        drop_results();
        data_load().then(() => {
            window.location.href = "https://group667.online/tests/test_one_color.php";
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
        circle.style.display = 'block';
        body.style.background = '#333';
        results.style.backgroundColor = '#fcf6f7';
        startBtn.style.backgroundColor = '#B30000';
        startBtn.style.color = 'white';
        light();
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



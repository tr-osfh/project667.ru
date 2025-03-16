<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тесты на реакцию</title>
    <link rel="stylesheet" href="../static/styles/styleForAllTests.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
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

        
        <div class="test_head">
            <h1>Тест на свет</h1>
            <div class="arrowDown" id="arrow_oc"></div>
        </div>
        <div id="test_oc_div" style="display: none;">
            <p class="description">
                Перед вами тест на скорость реакции. Ваша задача — как можно быстрее нажимать на кнопку, когда загорается лампочка. Тест измеряет время вашей реакции от момента появления сигнала (света лампочки) до момента нажатия кнопки. Постарайтесь сосредоточиться и реагировать максимально быстро.
                <br><br>
                - Тест состоит из нескольких попыток.<br>
                - После каждой попытки вы увидите время вашей реакции.<br>
                - В конце теста вы получите среднее время реакции и оценку ваших результатов.<br>
            </p>
            <p class="start-text">Готовы проверить свою реакцию? Нажмите кнопку "Начать", чтобы приступить к тесту!</p>
            <button class="go_to_test" onclick="window.location.href='https://group667.online/tests/test_one_color.php';">Начать</button>
        </div>

        
        <div class="test_head">
            <h1>Тест на звук</h1>
            <div class="arrowDown" id="arrow_os"></div>
        </div>
        <div id="test_os_div" style="display: none;">
            <p class="description">
                Перед вами тест на скорость реакции. Ваша задача — как можно быстрее нажимать на кнопку, когда вы услышите звуковой сигнал. Тест измеряет время вашей реакции от момента появления звука до момента нажатия кнопки. Постарайтесь сосредоточиться и реагировать максимально быстро.
                <br><br>
                - Тест состоит из нескольких попыток.<br>
                - После каждой попытки вы увидите время вашей реакции.<br>
                - В конце теста вы получите среднее время реакции и оценку ваших результатов.<br>
                <b>Совет:</b> Убедитесь, что звук на вашем устройстве включен.<br>
            </p>
            <p class="start-text">Готовы проверить свою реакцию? Нажмите кнопку "Начать", чтобы приступить к тесту!</p>
            <button class="go_to_test" onclick="window.location.href='https://group667.online/tests/test_one_sound.php';">Начать</button>
        </div>


        <div class="test_head">
            <h1>Тест на разные цвета</h1>
            <div class="arrowDown" id="arrow_ruletka"></div>
        </div>
        <div id="test_hc_div" style="display: none;">
            <p class="description">
                Перед вами тест на скорость реакции и внимательность. Ваша задача — как можно быстрее нажимать на кнопку нужного цвета, когда стрелка на вращающемся колесе укажет на соответствующий цвет после подсветки кнопки. Тест измеряет время вашей реакции от момента подсветки кнопки до момента нажатия, а также проверяет вашу точность.
                <br><br>
                - Тест состоит из 10 попыток.<br>
                - После каждой попытки подсвечивается случайная кнопка (синяя, зеленая или красная), и вам нужно дождаться, пока стрелка на колесе укажет на тот же цвет, чтобы нажать.<br>
                - В процессе вы увидите статистику: среднее время реакции, количество верных ответов, пропусков и ошибок.<br>
                - В конце теста результаты сохраняются в таблице с итоговым средним временем реакции и оценкой точности.<br>
                <b>Совет:</b> Сосредоточьтесь на вращении колеса и будьте готовы к быстрому нажатию, когда цвета совпадут!<br>
            </p>
            <p class="start-text">Готовы проверить свою реакцию и внимательность? Нажмите кнопку "Начать", чтобы приступить к тесту!</p>
            <button class="go_to_test" onclick="window.location.href='https://group667.online/tests/test_ruletka.php';">Начать</button>
        </div>


        <div class="test_head">
    <h1>Тест на голосовой сигнал</h1>
    <div class="arrowDown" id="arrow_chet_sound"></div>
</div>
<div id="chet_sound_div" style="display: none;">
    <p class="description">
        Перед вами тест на скорость реакции и внимательность. Ваша задача — как можно быстрее нажимать кнопку "Чёт" или "Нечёт", когда вы услышите голосовой вопрос — сумму двух чисел. Тест измеряет время вашей реакции от момента окончания произнесения вопроса до нажатия кнопки, а также проверяет правильность ответа.
        <br><br>
        - Тест состоит из 10 попыток.<br>
        - После каждой попытки вы услышите вопрос вида "X плюс Y" и должны определить, четная или нечетная сумма.<br>
        - В процессе вы увидите статистику: среднее время реакции, количество верных ответов и ошибок.<br>
        - В конце теста результаты сохраняются в таблице с итоговым средним временем реакции и точностью.<br>
        <b>Совет:</b> Убедитесь, что звук на вашем устройстве включен, и внимательно слушайте голосовой сигнал!<br>
    </p>
    <p class="start-text">Готовы проверить свою реакцию и внимательность? Нажмите кнопку "Начать", чтобы приступить к тесту!</p>
    <button class="go_to_test" onclick="window.location.href='https://group667.online/tests/chet_sound_test.php';">Начать</button>
</div>

<div class="test_head">
    <h1>Тест на визуальный сигнал</h1>
    <div class="arrowDown" id="arrow_chet_view"></div>
</div>
<div id="chet_view_div" style="display: none;">
    <p class="description">
        Перед вами тест на скорость реакции и внимательность. Ваша задача — как можно быстрее нажимать кнопку "Чёт" или "Нечёт", когда на экране появится сумма двух чисел. Тест измеряет время вашей реакции от момента появления чисел до нажатия кнопки, а также проверяет правильность ответа.
        <br><br>
        - Тест состоит из 10 попыток.<br>
        - После каждой попытки вы увидите задачу вида "X + Y = ?" и должны определить, четная или нечетная сумма.<br>
        - В процессе вы увидите статистику: среднее время реакции, количество верных ответов и ошибок.<br>
        - В конце теста результаты сохраняются в таблице с итоговым средним временем реакции и точностью.<br>
        <b>Совет:</b> Сосредоточьтесь на числах и быстро принимайте решение!<br>
    </p>
    <p class="start-text">Готовы проверить свою реакцию и внимательность? Нажмите кнопку "Начать", чтобы приступить к тесту!</p>
    <button class="go_to_test" onclick="window.location.href='https://group667.online/tests/chet_view_test.php';">Начать</button>
</div>

    </div>
    

    <script>
    const arrowOc = document.getElementById('arrow_oc');
    const testOcDiv = document.getElementById('test_oc_div');
    const arrowOs = document.getElementById('arrow_os');
    const testOsDiv = document.getElementById('test_os_div');
    const arrowRuletka = document.getElementById('arrow_ruletka');
    const testRuletkaDiv = document.getElementById('test_hc_div');
    const arrowSound = document.getElementById('arrow_chet_sound');
    const testSoundDiv = document.getElementById('chet_sound_div');
    const arrowView = document.getElementById('arrow_chet_view');
    const testViewDiv = document.getElementById('chet_view_div');

    function openList(testDiv, arrow) {
        testDiv.style.display = 'block';
        arrow.classList.add('arrowUp');
        arrow.classList.remove('arrowDown');
    }

    function closeList(testDiv, arrow) {
        testDiv.style.display = 'none';
        arrow.classList.add('arrowDown');
        arrow.classList.remove('arrowUp');
    }

    arrowOc.addEventListener('click', function() {
        if (arrowOc.classList.contains('arrowDown')) {
            openList(testOcDiv, arrowOc);
        } else if (arrowOc.classList.contains('arrowUp')) {
            closeList(testOcDiv, arrowOc);
        }
    });

    arrowOs.addEventListener('click', function() {
        if (arrowOs.classList.contains('arrowDown')) {
            openList(testOsDiv, arrowOs);
        } else if (arrowOs.classList.contains('arrowUp')) {
            closeList(testOsDiv, arrowOs);
        }
    });

    arrowRuletka.addEventListener('click', function() {
        if (arrowRuletka.classList.contains('arrowDown')) {
            openList(testRuletkaDiv, arrowRuletka);
        } else if (arrowRuletka.classList.contains('arrowUp')) {
            closeList(testRuletkaDiv, arrowRuletka);
        }
    });

    arrowSound.addEventListener('click', function() {
        if (arrowSound.classList.contains('arrowDown')) {
            openList(testSoundDiv, arrowSound);
        } else if (arrowSound.classList.contains('arrowUp')) {
            closeList(testSoundDiv, arrowSound);
        }
    });

    arrowView.addEventListener('click', function() {
        if (arrowView.classList.contains('arrowDown')) {
            openList(testViewDiv, arrowView);
        } else if (arrowView.classList.contains('arrowUp')) {
            closeList(testViewDiv, arrowView);
        }
    });

</script>
</body>
</html>
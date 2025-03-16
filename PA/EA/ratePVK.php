<?php session_start(); ?>
<!-- К строке выше не прикасаться, она отвечает за запуск сессии -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../static/styles/styleForLK.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
    <script>
        function selectSkill(pvkId, description, frequency) {
            const selectedList = document.getElementById('selected-skills');
            const newItem = document.createElement('li');
            newItem.textContent = `${description} (Частота: ${frequency})`;

            selectedList.appendChild(newItem);

            saveSelectedSkill(pvkId);
        }

        function saveSelectedSkill(pvkId) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../../scripts/save_selected_skill.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log('ПВК успешно сохранен:', xhr.responseText);
                }
            };


            const professionId = document.getElementById('profession-id').value;

            const expertId = document.getElementById('expert-id').value;


            xhr.send(`profession_id=${professionId}&pvk_id=${pvkId}&expert_id=${expertId}`);
        }
    </script>
</head>

<body>
    <div class="header_container" id="header">
        <!-- Логотип в шапке -->
        <a href="https://group667.online/index.php" onclick="location.href='mainpage.html';" class="icon_button"></a>
        <h1>Панель эксперта</h1>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $profession_id = htmlspecialchars($_POST["id"]);
    }

    include "../../scripts/skillsList.php";
    $skillsList = getSkillsList($profession_id);

    $expert_id = $_SESSION['id'];
    ?>

    <input type="hidden" id="profession-id" value="<?= $profession_id ?>">
    <input type="hidden" id="expert-id" value="<?= $expert_id ?>">

    <h1>Список профессионально важных качеств (ПВК)</h1>

    <table style='width: 100%; border-collapse: collapse;'>
        <tr>
            <th style='padding: 10px; text-align: left;'>ПВК</th>
            <th style='padding: 10px; text-align: left;'>Оценок</th>
            <th style='padding: 10px; text-align: left;'></th>
        </tr>

        <?php foreach ($skillsList as $skill): ?>
            <tr>
                <td style='padding: 10px;'><?= htmlspecialchars($skill['description']) ?></td>
                <td style='padding: 10px;'><?= $skill['frequency'] ?></td>
                <td style='padding: 10px;'>
                    <div class="forms">
                        <button
                            onclick="selectSkill(<?= $skill['id'] ?>, '<?= htmlspecialchars($skill['description']) ?>', <?= $skill['frequency'] ?>)">
                            Выбрать
                        </button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Выбранные ПВК</h2>
    <ul id="selected-skills">
        <!-- Сюда будут добавляться выбранные ПВК -->
    </ul>
</body>

</html>
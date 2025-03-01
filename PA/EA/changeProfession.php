<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../static/styles/styleForLK.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <div class="header_container" id="header">
        <a href="https://group667.ru/index.php" onclick="location.href='mainpage.html';" class="icon_button"></a>
        <h1>Изменить профессию</h1>
    </div>

    <?php
    include "../../expertRights/getProfessionName.php";
    ?>
    <h1>Вы изменяете профессию<br>"<?php echo $profession_name ?>"</h1>

    <div class="forms">
        <form id="profform" action="../../expertRights/changePeofession.php" method="post">
            <div class="profinputs">
                <p>Название</p>
                <input type="text" id="profname" name="profname" placeholder="Название профессии">
                <p>Фото</p>
                <input type="text" id="photolink" name="photolink" placeholder="Cсылка на фото">
                <p>Описание профессии</p>
                <textarea type="text" id="descriprion" name="description" placeholder="Описание"></textarea>
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                <div>
                    <button type="submit" id="btn">подтвердить</button>
                    <p id="proferror">Какое-то из полей не заполнено!</p>
                </div>
            </div>
        </form>
    </div>

    <script>
        const profname = document.getElementById('profname');
        const photolink = document.getElementById('photolink');
        const descriprion = document.getElementById('descriprion');
        const btn = document.getElementById('btn');
        const proferror = document.getElementById('proferror');
        const profform = document.getElementById('profform');

        function isFormEmpty() {
            return (
                profname.value.trim() === "" ||
                photolink.value.trim() === "" ||
                descriprion.value.trim() === ""
            );
        }

        function checkInput(inputElement) {
            if (inputElement.value.trim() === "") {
                inputElement.style.backgroundColor = '#a04c4d06'; // Цвет для пустого поля
            } else {
                inputElement.style.backgroundColor = 'white'; // Цвет для заполненного поля
            }

            if (!isFormEmpty()) {
                proferror.style.display = 'none';
                btn.style.display = 'block';
            }
        }

        btn.addEventListener('click', function(event) {
            if (isFormEmpty()) {
                event.preventDefault();
                proferror.style.display = 'block';
                btn.style.display = 'none';
            }
        });

        profname.addEventListener('input', function() {
            checkInput(profname);
        });

        photolink.addEventListener('input', function() {
            checkInput(photolink);
        });

        descriprion.addEventListener('input', function() {
            checkInput(descriprion);
        });
    </script>

</body>

</html>

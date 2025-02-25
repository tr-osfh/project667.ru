<?php


$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";
$connection = new mysqli($servername, $username, $password, $db);
if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

$sql = "SELECT `profname`, `description`, `photolink` FROM `professions`";

if ($stmt = $connection->prepare($sql)) {
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($line = $result->fetch_assoc()) {
            echo '<div class="professions_container" id="prof-container">';
            echo '    <div class="profession_block">';
            echo '        <img class="prof-photo"';
            echo '            src="' . $line['photolink'] . '" />';
            echo '        <div class="prof_content">';
            echo '            <div class="prof_title">' . $line['profname'] . '</div>';
            echo '            <div class="prof_description">';
            echo '                ' . $line['description'];
            echo '            </div>';
            echo '            <ul class="prof_requirements">';
            echo '                <li>Требование 1</li>';
            echo '                <li>Требование 2</li>';
            echo '                <li>Требование 3</li>';
            echo '                <li>Требование 4</li>';
            echo '                <li>Требование 5</li>';
            echo '                <li>Требование 6</li>';
            echo '            </ul>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
        }
    } else {
        echo "Профессий нет";
    }

    $stmt->close(); // Закрываем подготовленный запрос
} else {
    echo "Ошибка выполнения запроса: " . $connection->error; // Выводим ошибку, если запрос не удалось подготовить
}

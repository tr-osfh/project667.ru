<?php


$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";
$connection = new mysqli($servername, $username, $password, $db);
if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

$sql = "SELECT `profname`, `description`, `photolink`, `id` FROM `professions` WHERE `added` = 1";

if ($stmt = $connection->prepare($sql)) {
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        include "skillsList.php";
        while ($line = $result->fetch_assoc()) {
            $id = $line['id'];

            $sorted_qualities = getSkillsListForUser($id);

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
            if (!empty($sorted_qualities)) {
                foreach ($sorted_qualities as $quality) {
                    echo '<li>' . $quality['description'] .  ' Частота упоминаний: ' . $quality['frequency'] . '</li>';
                }
            } else {
                echo '<li> Список профессионально важных качеств пуст <li>';
            }
            echo '            </ul>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
        }
    } else {
        echo "Профессий нет";
    }

    $stmt->close();
} else {
    echo "Ошибка выполнения запроса: " . $connection->error;
}

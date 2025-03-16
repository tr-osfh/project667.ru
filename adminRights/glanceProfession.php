<?php
$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";
$connection = new mysqli($servername, $username, $password, $db);
if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = htmlspecialchars($_POST["id"]);
    $sql = "SELECT `profname`, `description`, `photolink`, `id` FROM `professions` WHERE `id` = $id";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->execute();

        $result = $stmt->get_result();
        $line = $result->fetch_assoc();
        echo '<div class="professions_container" id="prof-container">';
        echo '    <div class="profession_block">';
        echo '        <img class="prof-photo"';
        echo '            src="' . $line['photolink'] . '" />';
        echo '        <div class="prof_content">';
        echo '            <div class="prof_title">' . $line['profname'] . '</div>';
        echo '            <div class="prof_description">';
        echo '                ' . $line['description'];
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';


        $stmt->close();
    }
}

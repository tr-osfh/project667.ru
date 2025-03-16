<?php
$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";

$connection = new mysqli($servername, $username, $password, $db);

if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

$sql = "SELECT `id`, `description` FROM `pvk`";
if ($stmt = $connection->prepare($sql)) {
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table>";
        while ($line = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='padding: 10px;'>" . $line['id'] . "</td>";
            echo "<td style='padding: 10px;'>" . $line['description'] . "</td>";
            echo "<td style='padding: 10px;'>";
            echo "<button id = 'btn_pick_prof" . $line['id'] . "' class='not_selected'";
            echo "            data-id='".$line['id']."'";
            echo "            style='cursor:pointer'>";
            echo "        Установить";
            echo "    </button>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Нет доступных пвк";
    }

    $stmt->close();
} else {
    echo "Ошибка выполнения запроса: " . $connection->error;
}

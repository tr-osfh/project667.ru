<?php
$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";

$connection = new mysqli($servername, $username, $password, $db);

if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

$sql = "SELECT `id`, `profname` FROM `professions`";
if ($stmt = $connection->prepare($sql)) {
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr><th style='padding: 10px; text-align: left;'>ID</th>
            <th style='padding: 10px; text-align: left;'>Профессия</th></tr>";

        while ($line = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='padding: 10px;'>" . $line['id'] . "</td>";
            echo "<td style='padding: 10px;'>" . $line['profname'] . "</td>";
            echo "<td style='padding: 10px;'>";
            echo '<div class="forms">';
            echo '  <form action="" method="post">';
            echo '      <input type="hidden" name="id" value= "' . $line['id'] . '">';
            echo '      <button type="submit">Оценить</button>';
            echo '  </form>';
            echo '</div> ';
            echo "</td>";
            echo "<td style='padding: 10px;'>";
            echo '<div class="forms">';
            echo '  <form action="../../expertRights/deliteProfession.php" method="post">';
            echo '      <input type="hidden" name="id" value= "' . $line['id'] . '">';
            echo '      <button type="submit">УДАЛИТЬ</button>';
            echo '  </form>';
            echo '</div> ';
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Нет доступных профессий";
    }

    $stmt->close();
} else {
    echo "Ошибка выполнения запроса: " . $connection->error;
}

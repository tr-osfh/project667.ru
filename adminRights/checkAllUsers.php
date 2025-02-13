<?php
$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";

$connection = new mysqli($servername, $username, $password, $db);

if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

$sql = "SELECT `id`, `username`, `role` FROM `users`";
$res = [];
$tmp = $connection->query($sql);

if ($tmp) {
    echo "<table style='width: 100%; border-collapse: collapse;'>";
    echo "<tr><th style='padding: 10px; text-align: left;'>ID</th><th style='padding: 10px; text-align: left;'>Username</th><th style='padding: 10px; text-align: left;'>Role</th></tr>";
    while ($line = $tmp->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='padding: 10px;'>" . $line['id'] . "</td>";
        echo "<td style='padding: 10px;'>" . htmlspecialchars($line['username']) . "</td>";
        echo "<td style='padding: 10px;'>" . htmlspecialchars($line['role']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

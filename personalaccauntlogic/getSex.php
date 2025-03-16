<?php
function getSex()
{
    $servername = "localhost";
    $username = "u3003666_root";
    $password = "9MhtHL8QmFHjbiK";
    $db = "u3003666_project667";

    $connection = new mysqli($servername, $username, $password, $db);

    if ($connection->connect_error) {
        die("Ошибка: " . $connection->connect_error);
    }

    $id = $_SESSION["id"];
    $sql = "SELECT sex FROM user_data WHERE user_id = $id";
    $res = $connection->query($sql)->fetch_assoc()["sex"];
    return $res;
}

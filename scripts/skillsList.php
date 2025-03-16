<?php
function getSkillsList($id)
{
    $servername = "localhost";
    $username = "u3003666_root";
    $password = "9MhtHL8QmFHjbiK";
    $db = "u3003666_project667";
    $connection = new mysqli($servername, $username, $password, $db);
    if ($connection->connect_error) {
        die("Ошибка: " . $connection->connect_error);
    }

    // Исправленный SQL-запрос
    $sql = "
        SELECT `pvk_id`, COUNT(`pvk_id`) AS frequency
        FROM `selectedPVK`
        WHERE `profession_id` = ?
        GROUP BY `pvk_id`
        ORDER BY frequency DESC";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $sorted_qualities = [];
    while ($row = $result->fetch_assoc()) {
        $sorted_qualities[] = [
            'id' => $row['pvk_id'],
            'frequency' => $row['frequency']
        ];
    }

    if (!empty($sorted_qualities)) {
        $pvk_ids = array_column($sorted_qualities, 'id');

        // Проверяем, что массив $pvk_ids не пуст
        if (!empty($pvk_ids)) {
            $placeholders = implode(',', array_fill(0, count($pvk_ids), '?'));

            $sql2 = "
                SELECT `id`, `description`
                FROM `pvk`
                WHERE `id` IN ($placeholders)";

            $stmt2 = $connection->prepare($sql2);

            // Исправлено: используем spread operator для передачи массива
            $stmt2->bind_param(str_repeat('i', count($pvk_ids)), ...$pvk_ids);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            $pvk_names = [];
            while ($row = $result2->fetch_assoc()) {
                $pvk_names[$row['id']] = $row['description'];
            }

            foreach ($sorted_qualities as &$quality) {
                $quality['description'] = $pvk_names[$quality['id']]; // Используем 'id' вместо 'pvk_id'
            }
        }
    }
    return $sorted_qualities;
}

function getSkillsListForUser($id)
{
    $servername = "localhost";
    $username = "u3003666_root";
    $password = "9MhtHL8QmFHjbiK";
    $db = "u3003666_project667";
    $connection = new mysqli($servername, $username, $password, $db);
    if ($connection->connect_error) {
        die("Ошибка: " . $connection->connect_error);
    }

    // Исправленный SQL-запрос
    $sql = "
        SELECT `pvk_id`, COUNT(`pvk_id`) AS frequency
        FROM `final_pvk`
        WHERE `profession_id` = ?
        GROUP BY `pvk_id`
        ORDER BY frequency DESC";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $sorted_qualities = [];
    while ($row = $result->fetch_assoc()) {
        $sorted_qualities[] = [
            'id' => $row['pvk_id'],
            'frequency' => $row['frequency']
        ];
    }

    if (!empty($sorted_qualities)) {
        $pvk_ids = array_column($sorted_qualities, 'id');

        // Проверяем, что массив $pvk_ids не пуст
        if (!empty($pvk_ids)) {
            $placeholders = implode(',', array_fill(0, count($pvk_ids), '?'));

            $sql2 = "
                SELECT `id`, `description`
                FROM `pvk`
                WHERE `id` IN ($placeholders)";

            $stmt2 = $connection->prepare($sql2);

            // Исправлено: используем spread operator для передачи массива
            $stmt2->bind_param(str_repeat('i', count($pvk_ids)), ...$pvk_ids);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            $pvk_names = [];
            while ($row = $result2->fetch_assoc()) {
                $pvk_names[$row['id']] = $row['description'];
            }

            foreach ($sorted_qualities as &$quality) {
                $quality['description'] = $pvk_names[$quality['id']]; // Используем 'id' вместо 'pvk_id'
            }
        }
    }
    return $sorted_qualities;
}

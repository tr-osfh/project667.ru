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


    $sql = "SELECT `value1`, `value2`, `value3`, `value4`, `value5`, `value6`, `value7`, `profid` FROM `profession_data` WHERE `profid` = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $innerline = $result->fetch_assoc();
    if (!is_null($innerline)) {
        $v1 = $innerline['value1'];
        $v2 = $innerline['value2'];
        $v3 = $innerline['value3'];
        $v4 = $innerline['value4'];
        $v5 = $innerline['value5'];
        $v6 = $innerline['value6'];
        $v7 = $innerline['value7'];

        $pvk = [
            $v1 => "skill",
            $v2 => "knowlege",
            $v3 => "sport",
            $v4 => "creativity",
            $v5 => "communication",
            $v6 => "confidence",
            $v7 => "chill"
        ];

        ksort($pvk);
        $c = 0;
        $resPVK = array();
        foreach ($pvk as $value => $name) {
            $resPVK[$c] = $name;
            $c = $c + 1;
        }
    } else {
        $resPVK[0] = "Профессия не оценена экспертом!";
        $resPVK[1] = "Профессия не оценена экспертом!";
        $resPVK[2] = "Профессия не оценена экспертом!";
        $resPVK[3] = "Профессия не оценена экспертом!";
        $resPVK[4] = "Профессия не оценена экспертом!";
        $resPVK[5] = "Профессия не оценена экспертом!";
        $resPVK[6] = "Профессия не оценена экспертом!";
    }




    return $resPVK;
}

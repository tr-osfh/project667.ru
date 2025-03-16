<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$deepseek_api_key = 'sk-2ef5e53ce2e14db0baec0d275af6dba2';
$deepseek_api_url = 'https://api.deepseek.com/v1/chat/completions';
$selected_pvk = json_decode($_POST['selected_pvk'], true);

$host = 'localhost';
$dbname = 'u3003666_project667';
$username = 'u3003666_root';
$password = '9MhtHL8QmFHjbiK';
function ask_deepseek($prompt, $api_key, $api_url)
{
    $data = [
        'model' => 'deepseek-chat',
        'messages' => [
            ['role' => 'user', 'content' => $prompt]
        ],
        'temperature' => 0.7,
        'max_tokens' => 100,
    ];

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key,
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        die("Ошибка cURL: " . curl_error($ch));
    }
    curl_close($ch);

    return json_decode($result, true);
}

function intelligent_search($query, $db_config, $api_key, $api_url)
{
    $conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['dbname']);

    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    $sql = "SELECT id, description FROM pvk";
    $result = $conn->query($sql);

    $records = [];
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }

    $descriptions = array_column($records, 'description');

    $prompt = "Найди наиболее подходящие записи для запроса: '$query'. Вот список записей:\n" . implode("\n", $descriptions);

    $deepseek_response = ask_deepseek($prompt, $api_key, $api_url);

    if (!isset($deepseek_response['choices'][0]['message']['content'])) {
        die("Ошибка: Неверный формат ответа от DeepSeek API. Ответ: " . json_encode($deepseek_response));
    }

    $deepseek_result = $deepseek_response['choices'][0]['message']['content'];

    $matched_records = [];
    foreach ($records as $record) {
        if (strpos($deepseek_result, $record['description']) !== false) {
            $matched_records[] = $record;
        }
    }

    $conn->close();

    return $matched_records;
}

$search_query = $_POST['query'];

// Сбрасываем список только при обычном POST (не AJAX)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['action'])) {
    $_SESSION['selected_pvk'] = [];
}

// Инициализация массива если не существует
if (!isset($_SESSION['selected_pvk'])) {
    $_SESSION['selected_pvk'] = [];
}



// Обработка AJAX-запроса ДО основного кода
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');

    try {
        if (!isset($_SESSION['id'])) {
            throw new Exception('Требуется авторизация');
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            throw new Exception('Некорректный ID');
        }

        // Добавляем ID в массив, если его еще нет
        if (!in_array($id, $_SESSION['selected_pvk'])) {
            $_SESSION['selected_pvk'][] = $id;
        }

        echo json_encode([
            'status' => 'success',
            'selected' => $_SESSION['selected_pvk']
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
    exit(); // Важно: завершаем выполнение после AJAX
}

// Основной код ТОЛЬКО для POST без action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['action'])) {
    $search_query = $_POST['query'];
    $db_config = [
        'host' => 'localhost',
        'username' => 'u3003666_root',
        'password' => '9MhtHL8QmFHjbiK',
        'dbname' => 'u3003666_project667'
    ];

    $results = intelligent_search($search_query, $db_config, $deepseek_api_key, $deepseek_api_url);

    if (!empty($results)) {
        echo "<table class='result-table'>";
        foreach ($results as $record) {
            $id = htmlspecialchars($record['id']);
            $desc = htmlspecialchars($record['description']);
            $is_selected = in_array($id, $selected_pvk) ? 'selected' : 'not_selected';

            echo "<tr>
            <td>{$id}</td>
            <td>{$desc}</td>
            <td>
                <button id = 'btn_pick_prof{$id}' class='{$is_selected}' 
                        data-id='{$id}'
                        style='cursor:pointer'>
                    " . ($is_selected == 'selected' ? 'Установлено✓' : 'Установить') . "
                </button>
            </td>
          </tr>";
        }
        echo "</table>";
    }
}

<?php

/**
 * Производит реализацию показа данных переданных запросом, в таблице "изменения статуса"
 *
 * @param array  $operationParameters
 * @param        $link
 * @param string $method
 *
 * @return string
 */
function route(array $operationParameters, $link, string $method): string
{
    $id = mysqli_real_escape_string($link, $operationParameters['id']);

    if (!empty($id)) {
        $selectStatus = <<<SQL
        SELECT * 
        FROM status_changes
        WHERE id='$id'
SQL;
    } else {
        $selectStatus = <<<SQL
        SELECT * 
        FROM status_changes
SQL;
    }

    $resultStatus = mysqli_query($link, $selectStatus) or die(mysqli_error($link));
    for ($dataStatus = []; $row = mysqli_fetch_assoc($resultStatus); $dataStatus[] = $row) {
    };

    return json_encode([
        'method' => $method,
        'dataStatus' => $dataStatus,
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
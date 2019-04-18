<?php

/**
 * Производит реализацию показа данных переданных запросом, в таблице "операторы"
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
        $selectOperators = <<<SQL
        SELECT * 
        FROM operators
        WHERE id='$id'
SQL;
    } else {
        $selectOperators = <<<SQL
        SELECT * 
        FROM operators
SQL;
    }

    $resultOperators = mysqli_query($link, $selectOperators) or die(mysqli_error($link));
    for ($dataOperators = []; $row = mysqli_fetch_assoc($resultOperators); $dataOperators[] = $row) {
    };

    return json_encode([
        'method' => $method,
        'dataOperators' => $dataOperators,
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
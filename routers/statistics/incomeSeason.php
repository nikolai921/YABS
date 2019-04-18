<?php

/**
 * Производит реализацию показа отчета сезонному обороту, интервал группировки месяц, используются таблицы:
 * Оборот операций по карте
 *
 * @param array  $operationParameters
 * @param        $link
 * @param string $method
 *
 * @return string
 */
function route(array $operationParameters, $link, string $method): string
{
    $selectCards = <<<SQL
       SELECT sum(actual_receipt) as sum, MONTH(date) as month
FROM turnover_operations
GROUP BY month
ORDER BY sum DESC
SQL;
    $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
    for ($dataCards = []; $row = mysqli_fetch_assoc($resultCards); $dataCards[] = $row) {
    };

    return json_encode([
        'method' => $method,
        'dataCards' => $dataCards,
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
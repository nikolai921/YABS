<?php

/**
 * Производит реализацию показа данных переданных запросом, в таблице "праздники"
 *
 * @param array  $operationParameters
 * @param        $link
 * @param string $method
 *
 * @return string
 */
function route(array $operationParameters, $link, string $method) : string
{
    $id = mysqli_real_escape_string($link, $operationParameters['id']);

    if(!empty($id))
    {
        $selectHolidays = <<<SQL
        SELECT * 
        FROM date_holidays
        WHERE id='$id'
SQL;
    } else
    {
        $selectHolidays = <<<SQL
        SELECT * 
        FROM date_holidays
SQL;
    }

    $resultHolidays = mysqli_query($link, $selectHolidays) or die(mysqli_error($link));
    for ($dataHolidays = []; $row = mysqli_fetch_assoc($resultHolidays); $dataHolidays[] = $row) {};

    return json_encode([
        'method' => $method,
        'dataHolidays' => $dataHolidays
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));
}
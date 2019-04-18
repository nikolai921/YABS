<?php
/**
 * Производит реализацию добавления данных переданных запросом, в таблицу "праздники"
 *
 * @param array  $operationParameters
 * @param        $link
 * @param string $method
 *
 * @return string
 */
function route(array $operationParameters, $link, string $method) : string
{
    $date = mysqli_real_escape_string($link, $operationParameters['date']);
    $checkDate = date('Y-m-d', strtotime($date));
    $discountRate = mysqli_real_escape_string($link, $operationParameters['discountRate']);
    $name = mysqli_real_escape_string($link, $operationParameters['name']);

    $insertHolidays = <<< SQL
        INSERT INTO date_holidays (`date`, name, discount_rate)
        VALUES ('$checkDate', '$name', '$discountRate')
SQL;
    $result = mysqli_query($link, $insertHolidays) or die(mysqli_error($link));

    // Возвращаем id операции
    $selectHolidays = <<< SQL
    SELECT MAX(id) as id 
    FROM date_holidays     
SQL;
    $resultHolidays = mysqli_query($link, $selectHolidays) or die(mysqli_error($link));
    $dataHolidays = mysqli_fetch_assoc($resultHolidays);

    return json_encode([
        'method' => $method,
        'id' => $dataHolidays
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));

}
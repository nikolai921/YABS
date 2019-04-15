<?php

function route(array $operationParameters, $link, string $method) : string
{
    $turnoverLevel = mysqli_real_escape_string($link, $operationParameters['turnoverLevel']);
    $bonusAmountTable = mysqli_real_escape_string($link, $operationParameters['bonusAmountTable']);

    $insertTurnover = <<< SQL
        INSERT INTO bonus_rules (turnover_level, bonus_amount)
        VALUES ('$turnoverLevel', '$bonusAmountTable')
SQL;
    $result = mysqli_query($link, $insertTurnover) or die(mysqli_error($link));

    // Возвращаем id операции
    $selectTurnover = <<< SQL
    SELECT MAX(id) as id 
    FROM bonus_rules     
SQL;
    $resultTurnover = mysqli_query($link, $selectTurnover) or die(mysqli_error($link));
    $dataTurnover = mysqli_fetch_assoc($resultTurnover);

    return json_encode([
        'method' => $method,
        'id' => $dataTurnover
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));

}
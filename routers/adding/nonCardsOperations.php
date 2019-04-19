<?php

function route(array $operationParameters, $link, string $method) : string
{
    $date = mysqli_real_escape_string($link, $operationParameters['date']);
    $checkDate = date('Y-m-d', strtotime($date));
    $operatorsId = mysqli_real_escape_string($link, $operationParameters['operatorsId']);
    $scopeOperation = mysqli_real_escape_string($link, $operationParameters['scopeOperation']);

    $insertOperations = <<< SQL
        INSERT INTO unaddressed_operations (operators_id, scope_operation, date)
        VALUES ('$operatorsId', '$scopeOperation', '$checkDate')
SQL;
    $result = mysqli_query($link, $insertOperations) or die(mysqli_error($link));

    // Возвращаем id операции
    $selectOperations = <<< SQL
    SELECT MAX(id) as id 
    FROM date_holidays     
SQL;
    $resultOperations = mysqli_query($link, $selectOperations) or die(mysqli_error($link));
    $dataOperations = mysqli_fetch_assoc($resultOperations);

    return json_encode([
        'method' => $method,
        'id' => $dataOperations
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));

}
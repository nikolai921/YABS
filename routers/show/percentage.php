<?php

function route(array $operationParameters, $link, string $method): string
{
    $id = mysqli_real_escape_string($link, $operationParameters['id']);

    if (!empty($id)) {
        $selectPercentage = <<<SQL
        SELECT * 
        FROM percentage_changes
        WHERE id='$id'
SQL;
    } else {
        $selectPercentage = <<<SQL
        SELECT * 
        FROM percentage_changes
SQL;
    }

    $resultPercentage = mysqli_query($link, $selectPercentage) or die(mysqli_error($link));
    for ($dataPercentage = []; $row = mysqli_fetch_assoc($resultPercentage); $dataPercentage[] = $row) {
    };

    return json_encode([
        'method' => $method,
        'dataCards' => $dataPercentage,
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
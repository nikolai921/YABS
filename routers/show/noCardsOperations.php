<?php

function route(array $operationParameters, $link, string $method): string
{
    $id = mysqli_real_escape_string($link, $operationParameters['id']);

    if (!empty($id)) {
        $selectNoCards = <<<SQL
        SELECT * 
        FROM unaddressed_operations
        WHERE id='$id'
SQL;
    } else {
        $selectNoCards = <<<SQL
        SELECT * 
        FROM unaddressed_operations
SQL;
    }

    $resultNoCards = mysqli_query($link, $selectNoCards) or die(mysqli_error($link));
    for ($dataNoCards = []; $row = mysqli_fetch_assoc($resultNoCards); $dataNoCards[] = $row) {
    };

    return json_encode([
        'method' => $method,
        'dataBonus' => $dataNoCards,
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
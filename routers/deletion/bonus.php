<?php

function route(array $operationParameters, $link, string $method): string
{
    $id = mysqli_real_escape_string($link, $operationParameters['id']);

    if (!empty($id)) {
        $selectBonus = <<<SQL
        SELECT * 
        FROM bonus_rules
        WHERE id='$id'
SQL;
    } else {
        $selectBonus = <<<SQL
        DELETE * 
        FROM bonus_rules
SQL;
    }

    $resultBonus = mysqli_query($link, $selectBonus) or die(mysqli_error($link));
    for ($dataBonus = []; $row = mysqli_fetch_assoc($resultBonus); $dataBonus[] = $row) {
    };

    return json_encode([
        'method' => $method,
        'dataBonus' => $dataBonus,
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
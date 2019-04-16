<?php

function route(array $operationParameters, $link, string $method): string
{
    $id = mysqli_real_escape_string($link, $operationParameters['id']);

    if (!empty($id)) {
        $selectBonus = <<<SQL
        DELETE
        FROM percentage_changes
        WHERE id='$id'
SQL;
    } else {
        $selectBonus = <<<SQL
        DELETE
        FROM percentage_changes
        WHERE id > 0
SQL;
    }

    $resultBonus = mysqli_query($link, $selectBonus) or die(mysqli_error($link));


    return json_encode([
        'method' => $method,
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
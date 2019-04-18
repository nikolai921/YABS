<?php

function route(array $operationParameters, $link, string $method): string
{
    $id = mysqli_real_escape_string($link, $operationParameters['id']);

    if (!empty($id)) {
        $selectNoCards = <<<SQL
        DELETE
        FROM unaddressed_operations
        WHERE id='$id'
SQL;
    } else {
        $selectNoCards = <<<SQL
        DELETE
        FROM unaddressed_operations
        WHERE id > 0
SQL;
    }

    $resultCards = mysqli_query($link, $selectNoCards) or die(mysqli_error($link));

    return json_encode([
        'method' => $method,
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
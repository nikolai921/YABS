<?php

/**
 * Производит реализацию удаления данных переданных запросом, из таблицы "безадресные сделки"
 *
 * @param array  $operationParameters
 * @param        $link
 * @param string $method
 *
 * @return string
 */
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
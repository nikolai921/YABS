<?php

/**
 * Производит реализацию удаления данных переданных запросом, из таблицы "карты"
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
        $selectBonus = <<<SQL
        DELETE
        FROM cards
        WHERE id='$id'
SQL;
    } else {
        $selectBonus = <<<SQL
        DELETE
        FROM cards
        WHERE id > 10
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
<?php

/**
 * Производит реализацию показа данных переданных запросом, в таблице "карты"
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

    $identifier = mysqli_real_escape_string($link, $operationParameters['identifier']);
    if($identifier === 'telephone' )
    {
        $selectCards = <<<SQL
        SELECT * 
        FROM cards
        WHERE telephone='$id'
SQL;
    } elseif($identifier === 'numberCards')
    {
        $selectCards = <<<SQL
        SELECT * 
        FROM cards
        WHERE number='$id'
SQL;
    } else
    {
        $selectCards = <<<SQL
        SELECT * 
        FROM cards
SQL;
    }
    $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
    for ($dataCards = []; $row = mysqli_fetch_assoc($resultCards); $dataCards[] = $row) {
    };

    return json_encode([
        'method' => $method,
        'dataCards' => $dataCards,
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
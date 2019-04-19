<?php

function route(array $operationParameters, $link, string $method) : string
{
    $id = mysqli_real_escape_string($link, $operationParameters['id']);

    if(!empty($id))
    {
        $selectCards = <<<SQL
        SELECT * 
        FROM cards
        WHERE id='$id'
SQL;
    } else
    {
        $selectCards = <<<SQL
        SELECT * 
        FROM cards
SQL;
    }

    $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
    for ($dataCards = []; $row = mysqli_fetch_assoc($resultCards); $dataCards[] = $row) {};

    return json_encode([
        'method' => $method,
        'dataCards' => $dataCards
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));
}
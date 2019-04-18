<?php

function route(array $operationParameters, $link, string $method): string
{
    $selectCards = <<<SQL
       SELECT sum(actual_receipt) as actualReceipt, operators.name
FROM turnover_operations
         RiGHT JOIN operators
                    ON operators.id = turnover_operations.operators_id
WHERE (SELECT status FROM cards WHERE turnover_operations.cards_id = cards.id)=1
GROUP BY operators_id
ORDER BY actualReceipt DESC
SQL;
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
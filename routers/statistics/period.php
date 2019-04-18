<?php

function route(array $operationParameters, $link, string $method): string
{
    $intervalStart = mysqli_real_escape_string($link, $operationParameters['intervalStart']);
    $intervalEnd = mysqli_real_escape_string($link, $operationParameters['intervalEnd']);

    $selectBonus = <<<SQL
       SELECT sum(bonus_amount) as bonusAmount,  sum(bonus_accrual) as bonusAccural
FROM turnover_operations
WHERE (SELECT status FROM cards WHERE turnover_operations.cards_id = cards.id)=1
AND date BETWEEN '$intervalStart' AND '$intervalEnd'
SQL;
    $resultBonus = mysqli_query($link, $selectBonus) or die(mysqli_error($link));
    $dataBonus = mysqli_fetch_assoc($resultBonus);

    $selectReceipt = <<<SQL
       SELECT sum(actual_receipt) as actualReceipt
FROM turnover_operations
WHERE (SELECT status FROM cards WHERE turnover_operations.cards_id = cards.id)=1
AND date BETWEEN '$intervalStart' AND '$intervalEnd'
SQL;
    $resultReceipt = mysqli_query($link, $selectReceipt) or die(mysqli_error($link));
    $dataReceipt = mysqli_fetch_assoc($resultReceipt);

    return json_encode([
        'method' => $method,
        'dataCards' => $dataBonus,
        'actualReceipt' => $dataReceipt
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}




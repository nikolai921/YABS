<?php

/**
 * Производит реализацию показа отчета по карте, используются данные таблиц:
 * Карты
 * Оборот операций по карте
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
        SELECT id, owner, telephone, birthday, operators_id, number, balance, discount, turnover, status, issue  
        FROM cards
        WHERE telephone='$id'
SQL;
        $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
        $dataCards = mysqli_fetch_assoc($resultCards);

        $cardsId = $dataCards['id'];

        $selectHistory = <<<SQL
        SELECT scope_operation, actual_receipt, bonus_amount, bonus_accrual  
        FROM turnover_operations
        WHERE cards_id='$cardsId'
SQL;
        $resultHistory = mysqli_query($link, $selectHistory) or die(mysqli_error($link));
        for ($dataHistory = []; $row = mysqli_fetch_assoc($resultHistory); $dataHistory[] = $row) {
        };

    } elseif($identifier === 'numberCards')
    {
        $selectCards = <<<SQL
        SELECT id, owner, telephone, birthday, operators_id, number, balance, discount, turnover, status, issue 
        FROM cards
        WHERE number='$id'
SQL;
        $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
        $dataCards = mysqli_fetch_assoc($resultCards);

        $cardsId = $dataCards['id'];


        $selectHistory = <<<SQL
        SELECT scope_operation, actual_receipt, bonus_amount, bonus_accrual  
        FROM turnover_operations
        WHERE cards_id='$cardsId'
SQL;
        $resultHistory = mysqli_query($link, $selectHistory) or die(mysqli_error($link));
        for ($dataHistory = []; $row = mysqli_fetch_assoc($resultHistory); $dataHistory[] = $row) {
        };
    }

    return json_encode([
        'method' => $method,
        'dataCards' => $dataCards,
        'dataHistory' => $dataHistory
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
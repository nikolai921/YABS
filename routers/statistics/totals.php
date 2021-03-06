<?php

/**
 * Совокупные показатели деятельности программы лояльности
 *
 * @param array  $operationParameters
 * @param        $link
 * @param string $method
 *
 * @return string
 */
function route(array $operationParameters, $link, string $method): string
{
        $selectCards = <<<SQL
        SELECT count(id) as volumeCards, sum(balance) as totalBonuses,  sum(turnover) as totalTurnover 
        FROM cards
        WHERE status=1
SQL;
        $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
        $dataCards = mysqli_fetch_assoc($resultCards);

        $selectBonuses = <<<SQL
        SELECT sum(bonus_amount) as bonusAmount,  sum(bonus_accrual) as bonusAccural 
        FROM turnover_operations
        WHERE (SELECT status FROM cards WHERE turnover_operations.cards_id = cards.id)=1
SQL;

    $resultBonuses = mysqli_query($link, $selectBonuses) or die(mysqli_error($link));
    for ($dataBonuses = []; $row = mysqli_fetch_assoc($resultBonuses); $dataBonuses[] = $row) {
    };

    $percentBonusAmount = round(($dataBonuses[0]['bonusAmount'] / $dataBonuses[0]['bonusAccural'])*100);


    return json_encode([
        'method' => $method,
        'dataCards' => $dataCards,
        'dataBonuses' => $dataBonuses,
        'percentBonusAmount' => $percentBonusAmount
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
<?php

function route(array $operationParameters, $link, string $method): string
{
    $percentage = mysqli_real_escape_string($link, $operationParameters['percentage']);
    $operatorsId = mysqli_real_escape_string($link, $operationParameters['operatorsId']);
    $identifier = mysqli_real_escape_string($link, $operationParameters['identifier']);
    $telephone = mysqli_real_escape_string($link, $operationParameters['telephone']);
    $number = mysqli_real_escape_string($link, $operationParameters['number']);

    if($identifier === 'telephone' )
    {
        $selectCards = <<<SQL
        SELECT id 
        FROM cards
        WHERE telephone='$telephone'
SQL;
    }

    if($identifier === 'numberCards')
    {
        $selectCards = <<<SQL
        SELECT id 
        FROM cards
        WHERE number='$number'
SQL;
    }

    $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
    $dataCards = mysqli_fetch_assoc($resultCards);
    $cardsId = $dataCards['id'];

    // Добавление процента скидки в таблицы percentage_changes
    $insertPercentage = <<< SQL
        INSERT INTO percentage_changes (operators_id, cards_id, percentage_changes)
        VALUES ('$operatorsId', '$cardsId', '$percentage')
SQL;
    $result = mysqli_query($link, $insertPercentage) or die(mysqli_error($link));

    // Изменение процента скидки в таблицы cards
    $insertCards = <<< SQL
        UPDATE cards 
        SET discount='$percentage'
        WHERE id = '$cardsId'
SQL;
    $result = mysqli_query($link, $insertCards) or die(mysqli_error($link));

    // Возвращаем id операции
    $selectPercentage = <<< SQL
    SELECT MAX(id) as id 
    FROM percentage_changes     
SQL;
    $resultPercentage = mysqli_query($link, $selectPercentage) or die(mysqli_error($link));
    $dataPercentage = mysqli_fetch_assoc($resultPercentage);



    return json_encode([
        'method' => $method,
        'dataPercentage' => $dataPercentage['id'],
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
<?php

/**
 * Производит реализацию добавления данных переданных запросом, в таблицу "изменение статуса"
 *
 * @param array  $operationParameters
 * @param        $link
 * @param string $method
 *
 * @return string
 */
function route(array $operationParameters, $link, string $method): string
{
    $status = mysqli_real_escape_string($link, $operationParameters['status']);
    $operatorsId = mysqli_real_escape_string($link, $operationParameters['operatorsId']);
    $identifier = mysqli_real_escape_string($link, $operationParameters['identifier']);
    $telephone = mysqli_real_escape_string($link, $operationParameters['telephone']);
    $number = mysqli_real_escape_string($link, $operationParameters['number']);

    if ($identifier === 'telephone') {
        $selectCards = <<<SQL
        SELECT id 
        FROM cards
        WHERE telephone='$telephone'
SQL;
    }

    if ($identifier === 'numberCards') {
        $selectCards = <<<SQL
        SELECT id 
        FROM cards
        WHERE number='$number'
SQL;
    }

    $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
    $dataCards = mysqli_fetch_assoc($resultCards);
    $cardsId = $dataCards['id'];

    // Добавление status в таблицы percentage_changes
    $insertStatus = <<< SQL
        INSERT INTO status_changes (operators_id, cards_id, status_changes)
        VALUES ('$operatorsId', '$cardsId', '$status')
SQL;
    $result = mysqli_query($link, $insertStatus) or die(mysqli_error($link));

    // Изменение status в таблицы cards
    $insertCards = <<< SQL
        UPDATE cards 
        SET status='$status'
        WHERE id = '$cardsId'
SQL;
    $result = mysqli_query($link, $insertCards) or die(mysqli_error($link));

    // Возвращаем id операции
    $selectStatus = <<< SQL
    SELECT MAX(id) as id 
    FROM status_changes     
SQL;
    $resultStatus = mysqli_query($link, $selectStatus) or die(mysqli_error($link));
    $dataStatus = mysqli_fetch_assoc($resultStatus);

    return json_encode([
        'method' => $method,
        'dataStatus' => $dataStatus['id'],
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
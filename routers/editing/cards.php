<?php

function route(array $operationParameters, $link, string $method): string
{
    $id = mysqli_real_escape_string($link, $operationParameters['id']);
    $birthdayDay = mysqli_real_escape_string($link, $operationParameters['birthdayDay']);
    $birthdayMonth = mysqli_real_escape_string($link, $operationParameters['birthdayMonth']);
    $birthdayYear = mysqli_real_escape_string($link, $operationParameters['birthdayYear']);

    if (!empty($birthdayYear)) {
        $birthday = $birthdayYear . '-' . $birthdayMonth . '-' . $birthdayDay;
    } else {
        $birthday = '2019-' . $birthdayMonth . '-' . $birthdayDay;
    }

    $identifier = mysqli_real_escape_string($link, $operationParameters['identifier']);
    if ($identifier === 'telephone') {
        $selectCards = <<<SQL
        SELECT id, owner, telephone, humanSex, birthday, number, status
        FROM cards
        WHERE telephone='$id'
SQL;
    } elseif ($identifier === 'numberCards') {
        $selectCards = <<<SQL
        SELECT id, owner, telephone, humanSex, birthday, number, status
        FROM cards
        WHERE number='$id'
SQL;
    }

    $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
    $dataCards = mysqli_fetch_assoc($resultCards);

    $cardsId = $dataCards['id'];

    $statusTable = $dataCards['status'];

    $variableParameters = ['owner', 'telephone', 'humanSex', 'birthday', 'number'];

    if ($statusTable === '1') {

        $updateCards = '';

        foreach ($variableParameters as $parameter) {
            if ($parameter === 'birthday') {
                if (!empty($operationParameters['birthdayDay'] && $operationParameters['birthdayMonth'])) {
                    $updateCards .= "`$parameter` = '$birthday',";
                }
            } else {
                if (!empty($operationParameters[$parameter])) {
                    $updateCards .= "`$parameter` = '$operationParameters[$parameter]',";
                }
            }
        }
        $updateCards = rtrim($updateCards, ",");

        $update = "UPDATE cards
    SET $updateCards
    WHERE id = '$cardsId'";
        $result = mysqli_query($link, $update) or die(mysqli_error($link));

    } else {
        throw new InvalidArgumentException('Статус карты: "Не активна"');
    }

    return json_encode([
        'method' => $method,
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}
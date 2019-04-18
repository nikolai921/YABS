<?php

/**
 * Производит реализацию добавления данных переданных запросом, в таблицу "карты", т.е. регистрация клиента
 *
 * @param array  $operationParameters
 * @param        $link
 * @param string $method
 *
 * @return string
 */

function route(array $operationParameters, $link, string $method) : string
{
    $operatorsId = mysqli_real_escape_string($link, $operationParameters['operatorsId']);
    $owner = mysqli_real_escape_string($link, $operationParameters['owner']);
    $humanSex = mysqli_real_escape_string($link, $operationParameters['humanSex']);
    $telephone = mysqli_real_escape_string($link, $operationParameters['telephone']);
    $birthdayDay = mysqli_real_escape_string($link, $operationParameters['birthdayDay']);
    $birthdayMonth = mysqli_real_escape_string($link, $operationParameters['birthdayMonth']);
    $birthdayYear = mysqli_real_escape_string($link, $operationParameters['birthdayYear']);

    if(!empty($birthdayYear))
    {
        $birthday = $birthdayYear . '-' . $birthdayMonth . '-' . $birthdayDay;
    } else
    {
        $birthday = '1000-' . $birthdayMonth . '-' . $birthdayDay;
    }

    $number = mt_rand(1000,9999) . mt_rand(1000,9999) . mt_rand(1000,9999) . mt_rand(1000,9999);

    $insertPercentage = <<< SQL
        INSERT INTO cards (owner, telephone, humanSex, birthday, operators_id, number)
        VALUES ('$owner', '$telephone', '$humanSex', '$birthday', '$operatorsId', '$number')
SQL;
    $result = mysqli_query($link, $insertPercentage) or die(mysqli_error($link));

    // Возвращаем id операции
    $selectCards = <<< SQL
    SELECT MAX(id) as id 
    FROM cards     
SQL;
    $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
    $dataCards = mysqli_fetch_assoc($resultCards);

    return json_encode([
        'method' => $method,
        'id' => $dataCards
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));

}
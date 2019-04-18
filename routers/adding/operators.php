<?php

/**
 * Производит реализацию добавления данных переданных запросом, в таблицу "операторы"
 *
 * @param array  $operationParameters
 * @param        $link
 * @param string $method
 *
 * @return string
 * @throws \Exception
 */
function route(array $operationParameters, $link, string $method) : string
{
    $nameOperators = mysqli_real_escape_string($link, $operationParameters['nameOperators']);
    $accessLevel = mysqli_real_escape_string($link, $operationParameters['accessLevel']);

    $selectOperators = <<< SQL
    SELECT * 
    FROM operators  
    WHERE  name='$nameOperators'  
SQL;
    $resultOperators = mysqli_query($link, $selectOperators) or die(mysqli_error($link));
    $dataOperators = mysqli_fetch_assoc($resultOperators);

    if(empty($dataOperators))
    {
        $unique_key = random_int(999999, 9999999);
        $hashKey = base64_encode($nameOperators . ':' .$unique_key);

        $insertHashKey = <<< SQL
        INSERT INTO operators (name, accessLevel, unique_key, hashKey)
        VALUES ('$nameOperators', '$accessLevel', '$unique_key', '$hashKey')
SQL;
        $result = mysqli_query($link, $insertHashKey) or die(mysqli_error($link));

        // Возвращаем id операции
        $selectOperators = <<< SQL
    SELECT MAX(id) as id 
    FROM operators     
SQL;
        $resultOperators = mysqli_query($link, $selectOperators) or die(mysqli_error($link));
        $dataOperators = mysqli_fetch_assoc($resultOperators);

        return json_encode([
            'method' => $method,
            'id' => $dataOperators['id']
        ]);
    } else
    {
        throw new InvalidArgumentException('Оператор с таким логином уже существует');
    }

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));

}
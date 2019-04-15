<?php


// Получение данных из тела запроса


function getFormData( string $method) : array
{
    $bodyRequest = [];

    // GET или POST: данные возвращаем как есть
    if ($method === 'GET')
    {
        $bodyRequest = $_GET;
    } elseif ($method === 'POST')
    {
        $bodyRequest = $_POST;
    } else
    {
        // PUT, PATCH или DELETE

        $exploded = explode('&', file_get_contents('php://input'));

        foreach($exploded as $pair) {
            $item = explode('=', $pair);
            if (count($item) == 2) {
                $bodyRequest[urldecode($item[0])] = urldecode($item[1]);
            }
        }
    }

    return $bodyRequest;
}


// Авторизация

function operatorAuthorization($link) : int
{
       if(!empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW']))
    {
        $login = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        $selectOperators = <<<SQL
        SELECT * 
        FROM operators 
        WHERE name='$login' AND unique_key='$password'
SQL;
        $resultOperators = mysqli_query($link, $selectOperators) or die(mysqli_error($link));
        $dataOperators = mysqli_fetch_assoc($resultOperators);
        if(!empty($dataOperators))
        {
            $operatorsId = $dataOperators['id'];
        } else
        {
            throw new InvalidArgumentException('Оператор не найден, ключ авторизации указан неверно');
        }

    } else
    {
        throw new InvalidArgumentException('Не указан ключ авторизации');
    }

    return $operatorsId;
}

//Разборка Url

function parsUrl() : array
{
    if(!empty($_GET['function']))
    {
        $url = $_GET['function'];
    } else
    {
        $url = '';
    }
    $url = rtrim($url, '/');
    return explode('/', $url);
}
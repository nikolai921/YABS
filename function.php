<?php

/**
 * Получение данных из тела запроса
 *
 * @param string $method
 *
 * @return array
 *
 */
function getFormData(string $method): array
{
    $bodyRequest = [];

    // GET или POST: данные возвращаем как есть
    if ($method === 'GET') {
        $bodyRequest = $_GET;
    } elseif ($method === 'POST') {
        $bodyRequest = $_POST;
    } else {
        // PUT, PATCH или DELETE

        $exploded = explode('&', file_get_contents('php://input'));

        foreach ($exploded as $pair) {
            $item = explode('=', $pair);
            if (count($item) === 2) {
                $bodyRequest[urldecode($item[0])] = urldecode($item[1]);
            }
        }
    }

    return $bodyRequest;
}

/**
 * Авторизация оператора, и реализация проверки на доступ к выполнению запроса
 *
 * @param $link
 *
 * @return int
 */
function operatorAuthorization($link): int
{
    if (!empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW'])) {
        $login = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        $selectOperators = <<<SQL
        SELECT * 
        FROM operators 
        WHERE name='$login' AND unique_key='$password'
SQL;
        $resultOperators = mysqli_query($link, $selectOperators) or die(mysqli_error($link));
        $dataOperators = mysqli_fetch_assoc($resultOperators);
        if (!empty($dataOperators)) {
            $operatorsId = $dataOperators['id'];
            $operatorsAccessLevel = $dataOperators['accessLevel'];
        } else {
            throw new InvalidArgumentException('Оператор не найден, ключ авторизации указан неверно');
        }

        $access = $_GET['function'];

        if ($operatorsAccessLevel === 'менеджер' ) {
            if ($access === 'adding/operations') {
                throw new InvalidArgumentException('Нет прав доступа к этому запросу');
            }

        }

        if ($operatorsAccessLevel === 'кассир') {
            if ($access !== 'adding/operations' && $access !== 'adding/noCardsOperations') {
                throw new InvalidArgumentException('Нет прав доступа к этому запросу');
            }

        }

        if ($operatorsAccessLevel === 'клиент') {
            $restriction = preg_match('#^show/cards/.*$#', $access);

            if ($restriction === 0) {
                throw new InvalidArgumentException('Нет прав доступа к этому запросу');
            }

        }


    } else {
        throw new InvalidArgumentException('Не указан ключ авторизации');
    }

    return $operatorsId;
}

/**
 * Производим разборку URL
 *
 * @return array
 */
function parsUrl(): array
{
    if (!empty($_GET['function'])) {
        $url = $_GET['function'];
    } else {
        $url = '';
    }
    $url = rtrim($url, '/');
    return explode('/', $url);
}


/**
 * Проверка входных параметров на соответствие валидности
 *
 * @param $options
 *
 * @return array
 */
function checkParameters($options): array
{
    $operationParameters = [
        'operatorsId' => '',
        'owner' => $_REQUEST['owner'],
        'name' => $_REQUEST['name'],
        'nameOperators' => $_REQUEST['nameOperators'],
    ];

    if (!empty($options['scopeOperation'])) {
        $scopeOperation = preg_match('#^\d*(\.{1}\d{1,2})?$#', $options['scopeOperation']);
        if ($scopeOperation === 1) {
            $operationParameters['scopeOperation'] = $options['scopeOperation'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр scopeOperation');
        }
    }

    if (!empty($options['bonusAmount'])) {
        $bonusAmount = preg_match('#^\d*(\.{1}\d{1,2})?$#', $options['bonusAmount']);
        if ($bonusAmount === 1) {
            $operationParameters['bonusAmount'] = $options['bonusAmount'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр bonusAmount');
        }
    }

    if (!empty($options['bonusProgram'])) {
        $bonusProgram = preg_match('#(^bonus$)|(^interest$)#', $options['bonusProgram']);
        if ($bonusProgram === 1) {
            $operationParameters['bonusProgram'] = $options['bonusProgram'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр bonusProgram');
        }
    }

    if (!empty($options['identifier'])) {
        $identifier = preg_match('#(^telephone$)|(^numberCards$)#', $options['identifier']);
        if ($identifier === 1) {
            $operationParameters['identifier'] = $options['identifier'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр identifier');
        }
    }

    if (!empty($options['number'])) {
        $number = preg_match('#^\d*(\.{1}\d{1,2})?$#', $options['number']);
        if ($number === 1) {
            $operationParameters['number'] = $options['number'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр number');
        }
    }

    if (!empty($options['id'])) {
        $id = preg_match('#\d*#', $options['id']);
        if ($id === 1) {
            $operationParameters['id'] = $options['id'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр id');
        }
    }

    if (!empty($options['telephone'])) {
        $telephone = preg_match('#^7\d{3}\d{7}$#', $options['telephone']);
        if ($telephone === 1) {
            $operationParameters['telephone'] = $options['telephone'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр telephone');
        }
    }

    if (!empty($options['humanSex'])) {
        $humanSex = preg_match('#(^male$)|(^female$)#', $options['humanSex']);
        if ($humanSex === 1) {
            $operationParameters['humanSex'] = $options['humanSex'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр humanSex');
        }
    }

    if (!empty($options['turnoverLevel'])) {
        $turnoverLevel = preg_match('#^\d*(\.{1}\d{1,2})?$#', $options['turnoverLevel']);
        if ($turnoverLevel === 1) {
            $operationParameters['turnoverLevel'] = $options['turnoverLevel'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр turnoverLevel');
        }
    }

    if (!empty($options['bonusAmountTable'])) {
        $bonusAmountTable = preg_match('#^\d*(\.{1}\d{1,2})?$#', $options['bonusAmountTable']);
        if ($bonusAmountTable === 1) {
            $operationParameters['bonusAmountTable'] = $options['bonusAmountTable'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр bonusAmountTable');
        }
    }

    if (!empty($options['date'])) {
        $date = preg_match('#^\d{4}\-\d{2}\-\d{2}$#', $options['date']);
        if ($date === 1) {
            $operationParameters['date'] = $options['date'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр date');
        }
    }

    if (!empty($options['discountRate'])) {
        $discountRate = preg_match('#^\d*(\.{1}\d{1,2})?$#', $options['discountRate']);
        if ($discountRate === 1) {
            $operationParameters['discountRate'] = $options['discountRate'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр discountRate');
        }
    }

    if (!empty($options['percentage'])) {
        $percentage = preg_match('#^\d{1,2}(\.{1}\d{1,2})?$#', $options['percentage']);
        if ($percentage === 1) {
            $operationParameters['percentage'] = $options['percentage'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр percentage');
        }
    }

    if (!empty($options['accessLevel'])) {
        $accessLevel = preg_match('#^кассир$|^менеджер$#u', $options['accessLevel']);
        if ($accessLevel === 1) {
            $operationParameters['accessLevel'] = $options['accessLevel'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр accessLevel');
        }
    }

    if (!empty($options['intervalStart'])) {
        $intervalStart = preg_match('#^\d{4}\-\d{2}\-\d{2}$#', $options['intervalStart']);
        if ($intervalStart === 1) {
            $operationParameters['intervalStart'] = $options['intervalStart'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр intervalStart');
        }
    }

    if (!empty($options['intervalEnd'])) {
        $intervalEnd = preg_match('#^\d{4}\-\d{2}\-\d{2}$#', $options['intervalEnd']);
        if ($intervalEnd === 1) {
            $operationParameters['intervalEnd'] = $options['intervalEnd'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр intervalEnd');
        }
    }

    if (!empty($options['birthdayDay'])) {
        $birthdayDay = preg_match('#^\d{2}$#', $options['birthdayDay']);
        if ($birthdayDay === 1) {
            $operationParameters['birthdayDay'] = $options['birthdayDay'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр birthdayDay');
        }
    }

    if (!empty($options['birthdayMonth'])) {
        $birthdayMonth = preg_match('#^\d{2}$#', $options['birthdayMonth']);
        if ($birthdayMonth === 1) {
            $operationParameters['birthdayMonth'] = $options['birthdayMonth'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр birthdayMonth');
        }
    }

    if (!empty($options['birthdayYear'])) {
        $birthdayYear = preg_match('#^\d{4}$#', $options['birthdayYear']);
        if ($birthdayYear === 1) {
            $operationParameters['birthdayYear'] = $options['birthdayYear'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр birthdayYear');
        }
    }

    if (!empty($options['status'])) {
        $status = preg_match('#^[0-1]$#', $options['status']);
        if ($status === 1) {
            $operationParameters['status'] = $options['status'];
        } else {
            throw new InvalidArgumentException('Некорректно введен параметр status');
        }
    }

    return $operationParameters;
}
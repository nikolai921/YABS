<?php

declare(strict_types=1);

/**
 * Подключение к БД и установка набора символов
 */

$link = mysqli_connect('localhost', 'stud0201', 'Asdfg13579', 'YABS');

if (!mysqli_set_charset($link, "utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", mysqli_error($link));
    exit();
} else {
    printf("Текущий набор символов: %s\n", mysqli_character_set_name($link));
}

require_once 'function.php';

/**
 * Получаем метод запроса и разбираем URL
 */


$method = $_SERVER['REQUEST_METHOD'];

$urls = parsUrl();

/**
 * Получаем набор параметров переданных в массиве $_REQUEST
 */

$Parameters = [
    'operatorsId' => '',
    'scopeOperation' => $_REQUEST['scopeOperation'],
    'bonusAmount' => $_REQUEST['bonusAmount'],
    'bonusProgram' => $_REQUEST['bonusProgram'],
    'identifier' => $_REQUEST['identifier'],
    'number' => $_REQUEST['number'],
    'function' => $_REQUEST['function'],
    'id' => $urls[2],
    'owner' => $_REQUEST['owner'],
    'telephone' => $_REQUEST['telephone'],
    'humanSex' => $_REQUEST['humanSex'],
    'birthdayDay' => $_REQUEST['birthdayDay'],
    'birthdayMonth' => $_REQUEST['birthdayMonth'],
    'birthdayYear' => $_REQUEST['birthdayYear'],
    'turnoverLevel' => $_REQUEST['turnoverLevel'],
    'bonusAmountTable' => $_REQUEST['bonusAmountTable'],
    'date' => $_REQUEST['date'],
    'name' => $_REQUEST['name'],
    'discountRate' => $_REQUEST['discountRate'],
    'nameOperators' => $_REQUEST['nameOperators'],
    'percentage' => $_REQUEST['percentage'],
    'status' => $_REQUEST['status'],
    'accessLevel' => $_REQUEST['accessLevel'],
    'intervalStart' => $_REQUEST['intervalStart'],
    'intervalEnd' => $_REQUEST['intervalEnd'],
];

/**
 * Производим проверку входных параметров на валидность
 */

$operationParameters = checkParameters($Parameters);

$authorizationOperator = operatorAuthorization($link);

$operationParameters['operatorsId'] = $authorizationOperator;

/**
 * Производим загрузку и запуск основной функции обработки запроса
 */

if (!empty($authorizationOperator)) {
    $bodyRequest = getFormData($method);

    require_once 'routers/' . $urls[0] . '/' . $urls[1] . '.php';

    echo route($operationParameters, $link, $method);
}
















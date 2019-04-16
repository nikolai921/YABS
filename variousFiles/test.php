<?php


declare(strict_types=1);

$link = mysqli_connect('localhost', 'root', '13579', 'YABS');

if (!mysqli_set_charset($link, "utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", mysqli_error($link));
    exit();
} else {
    printf("Текущий набор символов: %s\n", mysqli_character_set_name($link));
}

$operationParameters = [
    'operatorsId' => 1,
    'cardsId' => 10,
    'scopeOperation' => 10555.56,
    'bonusAmount' => 100000,
    'bonusProgram' => 'bonus'
];

$operationParametersJson = json_encode($operationParameters);


//print_r($level);
print_r($operationParametersJson);
//print_r($dataDiscount);


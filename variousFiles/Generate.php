<?php

$link = mysqli_connect('localhost', 'root', '13579', 'DB_rarus3');

if (!mysqli_set_charset($link, "utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", mysqli_error($link));
    exit();
} else {
    printf("Текущий набор символов: %s\n", mysqli_character_set_name($link));
}

$domen = [
    '@mail.ru',
    '@yandex.ru',
    '@rambler.ru',
    '@gmail.com',
    '@yahoo.com',
    '@worker.com',
    '@job.com',
    '@company.com'
];

$link->begin_transaction();
for($i = 1;$i < 500001; $i++)
{
////    $body = mt_rand(1,9) . mt_rand(1,9) .mt_rand(1,9) . mt_rand(1,9) . mt_rand(1,9) . mt_rand(1,9);
////    $string = $body . $domen[mt_rand(0,7)];
////    $body = mt_rand(1,5);
//        $string = mt_rand(1,9) . mt_rand(1,9) . mt_rand(1,9) . mt_rand(1,9) . mt_rand(1,9);
//        $insert = "INSERT INTO telegram(token, contacts_id) VALUES ('$string', '$i')";
//        $result = mysqli_query($link, $insert) or die(mysqli_error($link));
////
////
//////    $insert = "UPDATE contacts SET id='$string' WHERE id='$i'";
//////    $result = mysqli_query($link, $insert) or die(mysqli_error($link));
////
////      $insert = "UPDATE contacts SET customer_id='$body' WHERE id='$i'";
////      $result = mysqli_query($link, $insert);
////
}
$link->commit();
//for($i = 1;$i < 20000; $i++)
//{
//    $contact = rand(1,100000);
//    $group = rand(1,35);
//
//    $insert = "INSERT INTO connect_group_cont(contact_id, group_id) VALUES ('$contact', '$group')";
//    $result = mysqli_query($link, $insert);
//
//}



$cityList = [
    'Москва',
    'Санкт-Петербург',
    'Новосибирск',
    'Екатеринбург',
    'Нижний Новгород',
    'Казань',
    'Челябинск',
    'Омск',
    'Самара',
    'Ростов-на-Дону',
    'Уфа',
    'Красноярск',
    'Пермь',
    'Воронеж',
    'Волгоград',
    'Краснодар',
    'Саратов',
    'Тюмень',
    'Тольятти',
    'Ижевск',
    'Барнаул',
    'Ульяновск',
    'Иркутск',
    'Хабаровск',
    'Ярославль',
    'Владивосток',
    'Махачкала',
    'Томск',
    'Оренбург',
    'Кемерово',
    'Новокузнецк',
    'Севастополь',
    'Симферополь',
];

$firm = [
    'Склад',
    'Офис',
    'Кафе',
    'Стройматериалы',
    'Разработка',
    'Маркетинг',
    'Менеджмент',
    'Сбыт',
    'Финансы',
    'Банк',
    'Ресторан',
    'Офис центр'
];

//foreach($cityList as $elem)
//{
//    $insert = "INSERT INTO groups(name, customer_id) VALUES ('$elem', 5)";
//
//    $result = mysqli_query($link, $insert) or die(mysqli_error($link));
//}

//$link->begin_transaction();
//for($i = 200000; $i < 500001; $i++)
//{
//    $contact = rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);
//    $group = rand(1,175);
//
//    $insert = "INSERT INTO connect_groups_cont (contact_id, groups_id) VALUES ('$contact', '$group')";
//    $result = mysqli_query($link, $insert);
//}
//$link->commit();
//for($i = 1; $i <= 10000; $i++)
//{
//    $contact = rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(1,9);
//    $group = 35;
//
//    $insert = "UPDATE connect_group_cont SET group_id = '$group' WHERE id='$contact'";
//    $result = mysqli_query($link, $insert) or die(mysqli_error($link));
//}



//print_r($surFamaleNames);





//
//$insert = "INSERT INTO contacts (name, number, contact_db_id, volume) VALUES ('Петров Александр Иванович',1 ,1, 1)";
//
//$result = mysqli_query($link, $insert) or die(mysqli_error($link));

//for($i = 1;$i < 171; $i++) {
//
//    $body = $firm[rand(0,10)] . ' ' . $cityList[rand(0,32)];
//    $insert = "UPDATE groups SET name='$body' WHERE id='$i'";
//    $result = mysqli_query($link, $insert);
//
//}
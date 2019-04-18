<?php

declare(strict_types=1);

$link = mysqli_connect('localhost', 'stud0201', 'Asdfg13579', 'YABS');

if (!mysqli_set_charset($link, "utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", mysqli_error($link));
    exit();
} else {
    printf("Текущий набор символов: %s\n", mysqli_character_set_name($link));
}

$maleNames = [];
$patrMaleNames = [];
$surMaleNames = [];

$famaleNames = [];
$patrFamaleNames = [];
$surFamaleNames = [];

$maleName = 'Александр Марк Георгий Артемий Дмитрий Константин Давид Эмиль Максим Тимур Платон Назар Сергей Олег Анатолий ';
$maleName .= 'Савва Андрей Ярослав Григорий Ян Алексей Антон Демид Рустам Артём Николай Данила Игнат Илья Глеб Станислав Влад ';
$maleName .= 'Кирилл Данил Василий Альберт Михаил Савелий Федор Тамерлан Никита Вадим Родион Айдар Матвей Степан Леонид Роберт ';
$maleName .= 'Роман Юрий Одиссей Адель Егор Богдан Валерий Марсель Арсений Артур Святослав Ильдар Иван Семен Борис Самир ';
$maleName .= 'Денис Макар Эдуард Тихон Евгений Лев Марат Рамиль Даниил Виктор Герман Ринат Тимофей Елисей Даниэль Радмир ';
$maleName .= 'Владислав Виталий Петр Филипп Игорь Вячеслав Амир Арсен Владимир Захар Всеволод Ростислав Павел Мирон Мирослав Святогор Руслан Дамир Гордей Яромир';

$maleNames = explode(' ', $maleName);
$countmaleNames = count($maleNames);

$patrMaleName = 'Александрович Маркович Георгиевич Артемиевич Дмитриевич Константинович Давидович Эмильевич Максимович Тимурович Платонович Назарович Сергеевич Олегович Анатолиевич ';
$patrMaleName .= 'Саввович Андреевич Ярославович Григориевич Янович Алексеевич Антонович Демидович Рустамович Артёмович Николаевич Данилеевич Игнатович Глебович Станиславович ';
$patrMaleName .= 'Кириллович Данилович Василий Альбертович Михаилович Савельевич Федорович Тамерланович Никита Вадимович Родионович Айдарович Матвеевич Степанович Леонидович Робертович ';
$patrMaleName .= 'Романович Юриевич Одиссеевич Адельевич Егорович Богданович Валериевич Марсельевич Арсениевич Артурович Святославович Ильдарович Иванович Семенович Борисович Самирович ';
$patrMaleName .= 'Денисович Макарович Эдуардович Тихонович Евгениевич Левович Маратович Рамильевич Даниилович Викторович Германович Ринатович Тимофеевич Елисеевич Даниэльевич Радмирович ';
$patrMaleName .= 'Владиславович Виталиевич Петрович Филиппович Игорьевич Вячеславович Амирович Арсенович Владимирович Захарович Всеволодович Ростиславович Павелович Миронович Мирославович Святогорович Русланович Дамирович Гордеевич Яромирович';

$patrMaleNames = explode(' ', $patrMaleName);
$countpatrMaleNames = count($patrMaleNames);

$surMaleName = 'Иванов Смирнов Кузнецов Попов Васильев Петров Соколов Михайлов Новиков Федоров Морозов Волков Алексеев ';
$surMaleName .= 'Лебедев Семенов Егоров Павлов Козлов Степанов Николаев Орлов Андреев Макаров Никитин Захаров Зайцев Соловьев Борисов Яковлев Григорьев Романов Воробьев Сергеев Кузьмин Фролов Александров Дмитриев ';
$surMaleName .= 'Королев Гусев Киселев Ильин Максимов Поляков Сорокин Виноградов Ковалев Белов Медведев Антонов Тарасов Жуков Баранов Филиппов Комаров Давыдов Беляев Герасимов Богданов Осипов Сидоров Матвеев ';
$surMaleName .= 'Титов Марков Миронов Крылов Куликов Карпов Власов Мельников Денисов Гаврилов Тихонов Казаков Афанасьев Данилов Савельев Тимофеев Фомин Чернов Абрамов Мартынов Ефимов Федотов Щербаков Назаров Калинин Исаев Чернышев Быков ';
$surMaleName .= 'Маслов Родионов Коновалов Лазарев Воронин Климов Филатов Пономарев Голубев Кудрявцев Прохоров Наумов Потапов Журавлев Овчинников Трофимов Леонов Соболев Ермаков Колесников Гончаров Емельянов Никифоров ';
$surMaleName .= 'Грачев Котов Гришин Ефремов Архипов Громов Кириллов Малышев Панов Моисеев Румянцев Акимов Кондратьев Бирюков Горбунов Анисимов Еремин Тихомиров Галкин Лукьянов Михеев Скворцов Юдин Белоусов Нестеров Симонов Прокофьев ';
$surMaleName .= 'Харитонов Князев Цветков Левин Митрофанов Воронов Аксенов Софронов Мальцев Логинов Горшков Савин Краснов Майоров Демидов Елисеев Рыбаков Сафонов Плотников Демин Хохлов Фадеев Молчанов Игнатов Литвинов Ершов ';
$surMaleName .= 'Ушаков Дементьев Рябов Мухин Калашников Леонтьев Лобанов Кузин Корнеев Евдокимов Бородин Платонов Некрасов Балашов Бобров Жданов Блинов Игнатьев Коротков Муравьев Крюков Беляков Богомолов Дроздов Лавров ';
$surMaleName .= 'Зуев Петухов Ларин Никулин Серов Терентьев Зотов Устинов Фокин Самойлов Константинов Сахаров Шишкин Самсонов Черкасов Чистяков Носов Спиридонов Карасев Авдеев Воронцов Зверев Владимиров Селезнев Нечаев Кудряшов ';
$surMaleName .= 'Седов Фирсов Андрианов Панин Головин Терехов Ульянов Шестаков Агеев Никонов Селиванов Баженов Гордеев Кожевников Пахомов Зимин Костин Широков Филимонов Ларионов Овсянников Сазонов Суворов Нефедов Корнилов ';
$surMaleName .= 'Любимов Львов Горбачев Копылов Лукин Токарев Кулешов Шилов Большаков Панкратов Родин Шаповалов Покровский Бочаров Никольский Маркин Горелов Агафонов Березин Ермолаев Зубков Куприянов Трифонов Масленников Круглов Третьяков Колосов ';
$surMaleName .= 'Рожков Артамонов Шмелев Лаптев Лапшин Федосеев Зиновьев Зорин Уткин Столяров Зубов Ткачев Дорофеев Антипов Завьялов Свиридов Золотарев Кулаков Мещеряков Макеев Дьяконов Гуляев Петровский Бондарев Поздняков Панфилов Кочетков ';
$surMaleName .= 'Суханов Рыжов Старостин Калмыков Колесов Золотов Кравцов Субботин Шубин Щукин Лосев Винокуров Лапин Парфенов Исаков';

$surMaleNames = explode(' ', $surMaleName);
$countsurMaleNames = count($surMaleNames);

$famaleName = 'Анастасия Марина Мирослава Марьяна Анна Светлана Галина Анжелика Мария Варвара Людмила Нелли Елена Софья Валентина Влада Дарья Диана Нина Виталина Алина Яна Эмилия Майя ';
$famaleName .= 'Ирина Кира Камилла Тамара Екатерина Ангелина Альбина Мелания Арина Маргарита Лилия Лиана Полина Ева Любовь Василина Ольга Алёна Лариса Зарина Юлия Дарина Эвелина Алия ';
$famaleName .= 'Татьяна Карина Инна Владислава Наталья Василиса Агата Самира Виктория Олеся Амелия Антонина Елизавета Аделина Амина Ника Ксения Оксана Эльвира Мадина Милана Таисия Ярослава Наташа ';
$famaleName .= 'Вероника Надежда Стефания Снежана Алиса Евгения Регина Каролина Валерия Элина Алла Юлиана Александра Злата Виолетта Ариана Ульяна Есения Лидия Эльмира Кристина Милена Амалия Ясмина София Вера Наталия Сабина';

$famaleNames = explode(' ', $famaleName);
$countfamaleNames = count($famaleNames);

$patrFamaleName = 'Александровна Марковна Георгиевна Артемиевна Дмитриевна Константиновна Давидовна Эмильевна Максимовна Тимуровна Платоновна Назаровна Сергеевна Олеговна Анатолиевна ';
$patrFamaleName .= 'Саввовна Андреевна Ярославовна Григориевна Яновна Алексеевна Антоновна Демидовна Рустамовна Артёмовна Николайевна Даниловна Игнатовна Глебовна Станиславовна ';
$patrFamaleName .= 'Кирилловна Даниловна Василиевна Альбертовна Михаиловна Савелиевна Федоровна Тамерлановна Никитовна Вадимовна Родионовна Айдаровна Матвеевна Степановна Леонидовна Робертовна ';
$patrFamaleName .= 'Романовна Юриевна Одиссеевна Адельевна Егоровна Богдановна Валериевна Марсельевна Арсениевна Артуровна Святославовна Ильдаровна Ивановна Семеновна Борисовна Самировна ';
$patrFamaleName .= 'Денисовна Макаровна Эдуардовна Тихоновна Евгениевна Левовна Маратовна Рамильевна Данииловна Викторовна Германовна Ринатовна Тимофеевна Елисеевна Даниэльевна Радмировна ';
$patrFamaleName .= 'Владиславовна Виталиевна Петровна Филипповна Игорьевна Вячеславовна Амировна Арсеновна Владимировна Захаровна Всеволодовна Ростиславовна Павлоовна Мироновна Мирославовна Святогоровна Руслановна Дамировна Гордеевна Яромировна';

$patrFamaleNames = explode(' ', $patrFamaleName);
$countpatrFamaleNames = count($patrFamaleNames);


foreach ($surMaleNames as $elem)
{
    $surFamaleNames[] = $elem . 'a';
}
$countsurFamaleNames = count($surFamaleNames);


$numberRegion = [495, 798, 833, 807, 491, 493, 805];

// Генерируем таблицу customers


//$link->begin_transaction();
//for($i = 1; $i < 2; $i++)
//{
//    $sex = rand(1, 2);
//    if($sex === 1)
//    {
//        $name = $surMaleNames[rand(0,309)] . ' ' . $maleNames[rand(0,99)] . ' ' . $patrMaleNames[rand(0,97)];
//    } else
//    {
//        $name = $surFamaleNames[rand(0,309)] . ' ' . $famaleNames[rand(0,99)] . ' ' . $patrFamaleNames[rand(0,97)];
//    }
//
//    $humanSex = ['male', 'female'];
//    $body = $humanSex[mt_rand(0,1)];
//
////    echo $name;
//    $number = 7 . $numberRegion[rand(0,6)] . rand(100,999) . rand(10,99) . rand(10,99);
////    echo $number;
//    $volume = rand(1949,2000) . '-' . rand(1,12) . '-' . rand(1,28);
//    $date = rand(2017,2019) . '-' . rand(1,12) . '-' . rand(1,28);
//    $checkDate = strtotime($date);
////    echo '!!!!' . $volume;
//
//        $variat = mt_rand(0,9);
//
//            $numberCard = mt_rand(1000,9999) . mt_rand(1000,9999) . mt_rand(1000,9999) . mt_rand(1000,9999);
//
//            $operator = [1, 4, 5];
//            $operator_id = $operator[mt_rand(0,2)];
//
//
//        $customer = $i;
//
//        if($variat < 3)
//        {
//            $status = 1;
//        } else
//        {
//            $status = 1;
//        }
//
//
//    $insert = "INSERT INTO cards (owner, telephone, humanSex, birthday, operators_id, number, status) VALUES ('$name', '$number', '$body', '$volume', '$operator_id', '$numberCard', '$status')";
//
//    $result = mysqli_query($link, $insert) or die(mysqli_error($link));
//
//}
//$link->commit();


//Генерируем таблицу cards

/*
$link->begin_transaction();
for($i = 1; $i < 1001; $i++)
{
$variat = mt_rand(0,9);
if($variat < 4)
{
    $select = "SELECT telephone FROM customers WHERE id='$i'";
    $result = mysqli_query($link, $select) or die(mysqli_error($link));
    $telephone = mysqli_fetch_assoc($result);
    $number = $telephone['telephone'];
} else
{
    $number = mt_rand(1000,9999) . mt_rand(1000,9999) . mt_rand(1000,9999) . mt_rand(1000,9999);
}

$customer = $i;

    if($variat < 3)
    {
        $status = 0;
    } else
    {
        $status = 1;
    }


    $insert = "INSERT INTO cards (customer_id, number, status)  VALUES ('$customer', '$number', '$status')";

    $result = mysqli_query($link, $insert) or die(mysqli_error($link));

}
$link->commit();
*/

require_once '../routers/adding/operations.php';

//  Совокупные параметры

for($i=1; $i < 1001; $i++) {

    $operator = [1, 4, 5];
    $operator_id = $operator[mt_rand(0, 2)];
    $cardsId = mt_rand(1, 1000);
    $scope_operation = mt_rand(500, 5000) . '.' . mt_rand(10, 99);
    $date = rand(2017, 2019) . '-' . rand(1, 12) . '-' . rand(1, 28);
    $checkDate = strtotime($date);
    $bonus_amount = mt_rand(500, 7000) . '.' . mt_rand(10, 99);

//    $selectCards = "SELECT * FROM cards WHERE id='$cardsId'";
//    $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
//    $dataCards = mysqli_fetch_assoc($resultCards);

//    $selectCards = "INSERT INTO unaddressed_operations (operators_id, scope_operation, date)
//        VALUES ('$operator_id', '$scope_operation', '$date')";
////    $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
////    $dataCards = mysqli_fetch_assoc($resultCards);
//
//    $result = mysqli_query($link, $selectCards) or die(mysqli_error($link));

    $insert = "UPDATE cards SET issue='$date' WHERE id = '$i'";

    $result = mysqli_query($link, $insert) or die(mysqli_error($link));



    $operationParameters = [
        'operatorsId' => $operator_id,
        'scopeOperation' => $scope_operation,
        'bonusAmount' => $bonus_amount,
        'bonusProgram' => 'bonus',
        'identifier' => 'telephone',
        'number' => $dataCards['telephone'],
        'function' => $_REQUEST['function'],
        'id' => $urls[2],
        'owner' => $_REQUEST['owner'],
        'telephone' => $_REQUEST['humanSex'],
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
        'accessLevel' => $_REQUEST['accessLevel']
    ];

//    route($operationParameters, $link, '$_GET');

//    $insert = "INSERT INTO turnover_operations (operators_id, cards_id, scope_operation, bonus_amount, date)  VALUES ('$operators_id', '$cardsId', '$scope_operation', '$bonus_amount_table', '$date')";
//
//    $result = mysqli_query($link, $insert) or die(mysqli_error($link));

}



//
////  1. Совершение операции (сделки)
//
//$selectCards = "SELECT * FROM cards WHERE id='$cards_id'";
//$resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
//$dataCards = mysqli_fetch_assoc($resultCards);
//
//$balance = $dataCards['balance'];
//$discount = $dataCards['discount'];
//$turnover = $dataCards['turnover'];
//
//if($card_use === 1)
//{
////    Вывести ошибку если хочет списать бонусы, а их мало
//    if($bonus_amount <= $balance)
//    {
//        $bonus_amount_table = 100;
//        $balance_changes = $balance - $bonus_amount_table;
//        $balance = $balance_changes;
//    } else
//    {
//        $bonus_amount_table = 0;
//    }
//}
//
//$bonus_accrual_table = ($scope_operation - $bonus_amount_table) *($discount/100);
//$written_of = $scope_operation *($discount/100);
//
//// Переключение по программам лояльности
//$actual_receipt = $scope_operation - $bonus_accrual_table;
//
//
//$insert = "INSERT INTO turnover_operations (operators_id, cards_id, scope_operation, actual_receipt, card_use, bonus_amount, bonus_accrual, written_of, date)  VALUES ('$operators_id', '$cards_id', '$scope_operation', '$actual_receipt', '$card_use', '$bonus_amount_table', '$bonus_accrual_table','$written_of', '$date')";
//
//$result = mysqli_query($link, $insert) or die(mysqli_error($link));
//
//// Работаем со смежными таблицами
//
//// Таблица cards
//
//$balanceNew = $balance + $bonus_accrual_table;
//$turnoverNew = $turnover + $actual_receipt;
//
//$selectCards = "SELECT MAX(id) as level FROM bonus_rules WHERE '$turnoverNew' >= turnover_level";
//$resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
//$dataCards = mysqli_fetch_assoc($resultCards);
//
//$level = $dataCards['level'];
//
//if($level > $discount)
//{
//    $discount = $level;
//
//    $insert = "INSERT INTO percentage_changes (operators_id, cards_id, percentage_changes, date)  VALUES ('$operators_id', '$cards_id', '$level', '$date')";
//
//    $result = mysqli_query($link, $insert) or die(mysqli_error($link));
//}
//
//$insert = "UPDATE cards SET balance='$balanceNew', discount='$discount', turnover='$turnoverNew' WHERE id = '$cards_id'";
//
//$result = mysqli_query($link, $insert) or die(mysqli_error($link));










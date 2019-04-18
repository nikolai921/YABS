<?php

function route(array $operationParameters, $link, string $method): string
{
    //
    $operatorsId = mysqli_real_escape_string($link, $operationParameters['operatorsId']);
    $identifier = mysqli_real_escape_string($link, $operationParameters['identifier']);
    $number = mysqli_real_escape_string($link, $operationParameters['number']);
    $scopeOperation = mysqli_real_escape_string($link, $operationParameters['scopeOperation']);
    $bonusAmount = mysqli_real_escape_string($link, $operationParameters['bonusAmount']);
    $bonusProgram = mysqli_real_escape_string($link, $operationParameters['bonusProgram']);

    if ($identifier === 'telephone') {
        $selectCards = <<<SQL
        SELECT * 
        FROM cards 
        WHERE telephone='$number'
SQL;
        $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
        $dataCards = mysqli_fetch_assoc($resultCards);
    } elseif ($identifier === 'numberCards') {
        $selectCards = <<<SQL
        SELECT * 
        FROM cards 
        WHERE number='$number'
SQL;
        $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
        $dataCards = mysqli_fetch_assoc($resultCards);
    } else {
        throw new InvalidArgumentException('Неверно указан идентификатор клиента');
    }

    //  Данные по операции (сделки)

    $status = $dataCards['status'];
    $balance = $dataCards['balance'];
    $discount = $dataCards['discount'];
    $turnover = $dataCards['turnover'];
    $cardsId = $dataCards['id'];

    //    Прверка статуса карты

    if ($status === '1') {

        //    Если клиент хочет списать больше бонусов чем у него есть производится списание всего объема бонусов
        //    Проверка объема списания бонусов, на равенство 50% от объема покупки

        if ($bonusAmount <= $balance) {
            if ($bonusAmount < floor($scopeOperation / 2)) {
                $bonusAmountTable = $bonusAmount;
                $balanceChanges = $balance - $bonusAmountTable;
                $balance = $balanceChanges;
            } else {
                $bonusAmountTable = floor($scopeOperation / 2);
                $balanceChanges = $balance - $bonusAmountTable;
                $balance = $balanceChanges;
            }
        } else {
            if ($balance < floor($scopeOperation / 2)) {
                $bonusAmountTable = $balance;
                $balanceChanges = $balance - $bonusAmountTable;
                $balance = $balanceChanges;
            } else {
                $bonusAmountTable = floor($scopeOperation / 2);
                $balanceChanges = $balance - $bonusAmountTable;
                $balance = $balanceChanges;
            }
        }

        // Проверка на праздники и дни рождения

        $birthday = date('d-m', strtotime($dataCards['birthday']));
        $today = date('d-m', time());
        $todayFull = date('Y-m-d', time());

        $selectCoefficient = <<<SQL
        SELECT discount_rate 
        FROM date_holidays 
        WHERE date='$todayFull'
SQL;
        $resultCoefficient = mysqli_query($link, $selectCoefficient) or die(mysqli_error($link));
        $dataCoefficient = mysqli_fetch_assoc($resultCoefficient);

        if ($birthday === $today) {

            $selectCoefficient = <<<SQL
        SELECT discount_rate 
        FROM date_holidays 
        WHERE name='День рождения'
SQL;
            $resultCoefficient = mysqli_query($link, $selectCoefficient) or die(mysqli_error($link));
            $dataCoefficient = mysqli_fetch_assoc($resultCoefficient);

            $discountCoefficient = $dataCoefficient['discount_rate'];

        } elseif (!empty($dataCoefficient)) {
            $discountCoefficient = $dataCoefficient['discount_rate'];
        } else {
            $discountCoefficient = 1;
        }

        if (($discount * $discountCoefficient) > 50) {
            $discountAccrual = 0.5;
        } else {
            $discountAccrual = ($discount / 100 * $discountCoefficient);
        }

        $bonusAccrualTable = ($scopeOperation - $bonusAmountTable) * $discountAccrual;
        $writtenOf = $scopeOperation * $discountAccrual;

        // Переключение по программам лояльности

        if ($bonusProgram === 'bonus') {
            $actualReceipt = $scopeOperation - $bonusAmountTable;
        } elseif ($bonusProgram === 'interest') {
            $actualReceipt = $scopeOperation - $writtenOf;
        }

        //Запись операции в таблицу

        $insertTurnover = <<< SQL
    INSERT INTO turnover_operations 
    (operators_id, cards_id, scope_operation, actual_receipt, bonus_amount, bonus_accrual, written_of)  
    VALUES 
    ('$operatorsId', '$cardsId', '$scopeOperation', '$actualReceipt', '$bonusAmountTable', '$bonusAccrualTable','$writtenOf')
SQL;
        $result = mysqli_query($link, $insertTurnover) or die(mysqli_error($link));

        // Работаем со смежными таблицами

        $balanceNew = $balance + $bonusAccrualTable;
        $turnoverNew = $turnover + $actualReceipt;

        $selectDiscount = <<< SQL
    SELECT MAX(bonus_amount) as level 
    FROM bonus_rules 
    WHERE '$turnoverNew' >= turnover_level
SQL;

        $resultDiscount = mysqli_query($link, $selectDiscount) or die(mysqli_error($link));
        $dataDiscount = mysqli_fetch_assoc($resultDiscount);

        // Таблица percentage_changes

        $level = $dataDiscount['level'];

        if ($level > $discount) {
            $discount = $level;

            $insertPercentage = <<< SQL
        INSERT INTO percentage_changes (operators_id, cards_id, percentage_changes)  
        VALUES ('$operatorsId', '$cardsId', '$level')
SQL;
            $result = mysqli_query($link, $insertPercentage) or die(mysqli_error($link));

            $selectPercent = <<< SQL
    SELECT MAX(id) as id 
    FROM percentage_changes     
SQL;
            $resultPercent = mysqli_query($link, $selectPercent) or die(mysqli_error($link));
            $dataPercent = mysqli_fetch_assoc($resultPercent);
            $idPercent = $dataPercent['id'];
        }

        // Таблица cards

        $updateCards = <<< SQL
    UPDATE cards 
    SET balance='$balanceNew', discount='$discount', turnover='$turnoverNew' 
    WHERE id = '$cardsId'
SQL;
        $result = mysqli_query($link, $updateCards) or die(mysqli_error($link));
    } else {
        throw new InvalidArgumentException('Статус карты: "Не активна"');
    }

    // Возвращаем id операции

    $selectOperations = <<< SQL
    SELECT MAX(id) as id 
    FROM turnover_operations     
SQL;
    $resultOperations = mysqli_query($link, $selectOperations) or die(mysqli_error($link));
    $dataOperations = mysqli_fetch_assoc($resultOperations);

    $idOperations = $dataOperations['id'];

    $updatePercent = <<< SQL
    UPDATE percentage_changes 
    SET operations_id ='$idOperations'
    WHERE id = '$idPercent'
SQL;
    $result = mysqli_query($link, $updatePercent) or die(mysqli_error($link));

    return json_encode([
        'method' => $method,
        'idOperations' => $idOperations,
        'idCards' => $cardsId,
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);

}

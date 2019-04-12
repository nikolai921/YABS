<?php

function addOperations(array $operationParameters, $link)
{
    $operatorsId = $operationParameters['operatorsId'];
    $cardsId = $operationParameters['cardsId'];
    $scopeOperation = $operationParameters['scopeOperation'];
    $bonusAmount = $operationParameters['bonusAmount'];
    $bonusProgram = $operationParameters['bonusProgram'];

    //  1. Совершение операции (сделки)

    $selectCards = <<<SQL
        SELECT * 
        FROM cards 
        WHERE id='$cardsId'
SQL;
    $resultCards = mysqli_query($link, $selectCards) or die(mysqli_error($link));
    $dataCards = mysqli_fetch_assoc($resultCards);

    $balance = $dataCards['balance'];
    $discount = $dataCards['discount'];
    $turnover = $dataCards['turnover'];

    //    Если клиент хочет списать больше бонусов чем у него есть производится списание всего объема бонусов
    //    Проверка на равенство 50% от покупки

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

    $customer = $dataCards['customer_id'];
    // День рождения

    $selectCustomer = <<<SQL
        SELECT birthday 
        FROM customers 
        WHERE id='$customer'
SQL;
    $resultCustomer = mysqli_query($link, $selectCustomer) or die(mysqli_error($link));
    $dataCustomer = mysqli_fetch_assoc($resultCustomer);

    $birthday = date('d-m', strtotime($dataCustomer['birthday']));
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

    if($bonusProgram === 'bonus')
    {
        $actualReceipt = $scopeOperation - $bonusAmountTable;
    } elseif($bonusProgram === 'interest')
    {
        $actualReceipt = $scopeOperation - $writtenOf;
    }

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

    $level = $dataDiscount['level'];

    if ($level > $discount) {
        $discount = $level;
        // Таблица percentage_changes
        $insertPercentage = <<< SQL
        INSERT INTO percentage_changes (operators_id, cards_id, percentage_changes)  
        VALUES ('$operatorsId', '$cardsId', '$level')
SQL;
        $result = mysqli_query($link, $insertPercentage) or die(mysqli_error($link));
    }

    // Таблица cards

    $insertCards = <<< SQL
    UPDATE cards 
    SET balance='$balanceNew', discount='$discount', turnover='$turnoverNew' 
    WHERE id = '$cardsId'
SQL;
    $result = mysqli_query($link, $insertCards) or die(mysqli_error($link));
}


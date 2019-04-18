<?php
/**
 * Производит реализацию показа данных переданных запросом, в таблице "оборот по операциям"
 *
 * @param array  $operationParameters
 * @param        $link
 * @param string $method
 *
 * @return string
 */
function route(array $operationParameters, $link, string $method): string
{
    $id = mysqli_real_escape_string($link, $operationParameters['id']);

    if (!empty($id)) {
        $selectTurnover = <<<SQL
        SELECT * 
        FROM turnover_operations
        WHERE id='$id'
SQL;
    } else {
        $selectTurnover = <<<SQL
        SELECT * 
        FROM turnover_operations
SQL;
    }

    $resultTurnover = mysqli_query($link, $selectTurnover) or die(mysqli_error($link));
    for ($dataTurnover = []; $row = mysqli_fetch_assoc($resultTurnover); $dataTurnover[] = $row) {
    };

    return json_encode([
        'method' => $method,
        'dataTurnover' => $dataTurnover,
    ]);

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode([
        'error' => 'Bad Request',
    ]);
}

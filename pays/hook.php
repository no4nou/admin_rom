<meta charset="utf-8">
<?
$json_str = file_get_contents('php://input');
$json = json_decode( $json_str, true );

///////////////////////////////////////////     преобразуем строку в переменные
$messageId = $json[messageId];
$hookId = $json[hookId];
$txnId = $json[payment][txnId];
$date = $json[payment][date];
$type = $json[payment][type];
$status = $json[payment][status];
$errorCode = $json[payment][errorCode];
$personId = $json[payment][personId];
$account = $json[payment][account];
$comment = $json[payment][comment];
$provider = $json[payment][provider];
$amount = $json[payment][sum][amount];
$currency = $json[payment][sum][currency];
$c_amount = $json[payment][commission][c_amount];
$c_currency = $json[payment][commission][c_currency];
$t_amount = $json[payment][total][t_amount];
$t_currency = $json[payment][total][t_currency];
$signFields = $json[payment][signFields];
$hash = $json[hash];
$version = $json[version];
$test = $json[test];
///////////////////////////////////////////////////////////////////
if($status == "SUCCESS"){
include_once('../admin/lib.php'); // Подключаемся к БД
//Функция возвращает упорядоченную строку значений параметров webhook и хэш подписи webhook для проверки
$oid = explode(':',$comment);
file_put_contents('fgh.txt',$oid[1]);
order_succ($oid[1], '../step/stata/');
}
$error = array('response' => 'OK');

header('Content-Type: application/json');
$jsonres = json_encode($error);
echo $jsonres;
error_log('error code' . $jsonres);
?>
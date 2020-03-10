<?
include_once('../admin/opt/ups.php');
include_once('./db.php');
if (!isset($_COOKIE['id'])){ 
    setcookie('id', $ipuser, time() + 3600*24*30*12, "/");
    foreach($sum as $key => $value){
        $summa = explode('-', $value);
        $summa = mt_rand($summa[0],$summa[1]);
        setcookie('sum'.($key+1), $summa, time() + 3600*24*30*12, "/");
    }  
}
header("Location: /");
//echo $_SERVER['REMOTE_ADDR'];
//print_r($_COOKIE);
exit();

//https://money.yandex.ru/transfer?receiver=410016511345817&sum=100&successURL=http%3A%2F%2Fprivopros.ml%2Fdfghgdfd&quickpay-back-url=http%3A%2F%2Fprivopros.ml%2Fdfghgdfd&shop-host=privopros.ml&label=1&targets=-&comment=-&origin=form&selectedPaymentType=AC&destination=-%3B%0A-&form-comment=-&short-dest=-
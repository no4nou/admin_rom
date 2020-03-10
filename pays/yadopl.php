<?
include_once('../admin/opt/kosh.php');
include_once('../admin/opt/ups.php');
if(empty($_REQUEST['pay'])){exit();}
$kosh = $arr[0];
$arr[]=array_shift($arr);
        $text = "<?php
        \$arr = array(
            ";
        foreach($arr as $value){
            $text .= "'$value',
            ";
        }
        $text .= ");";
        file_put_contents('../admin/opt/kosh.php', $text, LOCK_EX);
$url = urlencode('http://'.$_SERVER['HTTP_HOST'].'/pays/outopl.php?out='.$_REQUEST['pay']);
$backurl = urlencode('http://'.$_SERVER['HTTP_HOST'].'/');
if (!isset($_COOKIE['sum'.$_REQUEST['pay']])){
    header("Location: /");
}else{
    $summa = $_COOKIE['sum'.$_REQUEST['pay']];
}
$order = urlencode('Order-id:'.rand(10000,99999));
$link = "https://money.yandex.ru/quickpay/confirm.xml?receiver=$kosh&formcomment=$order&short-dest=$order&label=1&quickpay-form=donate&targets=$order&sum=$summa&comment=$order&need-fio=false&need-email=false&need-phone=false&need-address=false&successURL=$url&paymentType=AC";
//echo $link;
//подключение к файлу базы данных
$today = date("d.m.Y"); 
if(!file_exists('../step/stata/'.$today.'.db')){
    $db = new SQLite3('../step/stata/'.$today.'.db');
    $db->exec("CREATE TABLE 'user'
               ('ip' VARCHAR(20), 
               'open' INT(11), 
               'oplata' INT(11), 
               'sum' INT(11), 
               'success' INT(11), 
               'succsumm' INT(11))");
}else{
    $db = new SQLite3('../step/stata/'.$today.'.db');
}

	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']){
		if(strpos($_SERVER['HTTP_X_FORWARDED_FOR'],".")>0 && strpos($_SERVER['HTTP_X_FORWARDED_FOR'],",")>0){
			$ip = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
			$ipuser = trim($ip[0]);
		}
		elseif(strpos($_SERVER['HTTP_X_FORWARDED_FOR'],".")>0 && strpos($_SERVER['HTTP_X_FORWARDED_FOR'],",")===false){
			$ipuser = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
		}
	}
	if(!isset($ipuser)){
		$ipuser = trim($_SERVER['REMOTE_ADDR']);
	}
    $res_test = $db->querySingle("SELECT * FROM user WHERE ip='$ipuser'");
    
			if(!empty($res_test)){
				$db->exec("UPDATE user SET oplata=oplata+1,sum=sum+$summa WHERE ip='$ipuser'");
                
			}else{
                $db->exec("INSERT INTO user VALUES ('$ipuser',0,1,'$summa',0,0)");
                
			}
header("Location: ".$link);
exit();
<?
include_once('../admin/lib.php');
include_once('../admin/opt/kosh.php');
include_once('../admin/opt/ups.php');
if(!empty($_REQUEST['outs'])){
    $order = order_form($_REQUEST['outs'],'../step/stata/');
    $url = '../'.$url[($order['url']-1)];
    header("Location: ".$url);
    exit();
}
if(empty($_REQUEST['out'])){exit();}

$url = '../'.$url[($_REQUEST['out']-1)];
if (!isset($_COOKIE['sum'.$_REQUEST['out']])){
    header("Location: /");
}else{
    $summa = $_COOKIE['sum'.($_REQUEST['out'])];
}
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
				$db->exec("UPDATE user SET success=success+1, succsumm=succsumm+$summa WHERE ip='$ipuser'");
                
			}else{
                $db->exec("INSERT INTO user VALUES ('$ipuser',0,1,$summa,1,$summa)");
                
			}
header("Location: ".$url);
exit();
<?
//подключение к файлу базы данных
$today = date("d.m.Y"); 
if(!file_exists('./stata/'.$today.'.db')){
    $db = new SQLite3('./stata/'.$today.'.db');
    $db->exec("CREATE TABLE 'user'
               ('ip' VARCHAR(20), 
               'open' INT(11), 
               'oplata' INT(11), 
               'sum' INT(11), 
               'success' INT(11), 
               'succsumm' INT(11))");
}else{
    $db = new SQLite3('./stata/'.$today.'.db');
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
				$db->exec("UPDATE user SET open=open+1 WHERE ip='$ipuser'");
                
			}else{
                $db->exec("INSERT INTO user VALUES ('$ipuser',1,0,0,0,0)");
                
			}
//выводим демо данные
/*
$results = $db->query('SELECT * FROM user');
while ($row = $results->fetchArray()) {
    echo "Результат<br>";
    echo "ip:".$row['ip']." Open: ".$row['open']." Pay: ".$row['oplata'];
}
//Закрываем соединение с базой.
$db->close();*/
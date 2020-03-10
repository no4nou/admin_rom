<?
function stata($day){
    $today = $day;
    $ip = 'none'; $open = 0; $oplata = 0; $sum = 0; $success = 0; $succsumm = 0;
    if(file_exists('../step/stata/'.$today.'.db')){
    $db = new SQLite3('../step/stata/'.$today.'.db');
    $results = $db->query('SELECT * FROM user');
    while ($row = $results->fetchArray()) {
        $open = $row['open'];
        $oplata = $row['oplata'];
        $sum = $row['sum'];
        $success = $row['success'];
        $succsumm = $row['succsumm'];
    }
    $db->close();
    }
    $arr = array($open,$oplata,$sum,$success,$succsumm);
    return $arr;
}
function stata_all($day){
    $today = $day;
    $ip = 'none'; $open = 0; $oplata = 0; $sum = 0; $success = 0; $succsumm = 0;
    if(file_exists('../step/stata/'.$today.'.db')){
    $db = new SQLite3('../step/stata/'.$today.'.db');
    $results = $db->query('SELECT SUM(open), SUM(oplata), SUM(sum), SUM(success), SUM(succsumm) FROM user');
    while ($row = $results->fetchArray()) {
        $open = $row['SUM(open)'];
        $oplata = $row['SUM(oplata)'];
        $sum = $row['SUM(sum)'];
        $success = $row['SUM(success)'];
        $succsumm = $row['SUM(succsumm)'];
    }
    $db->close();
    }
    $arr = array($open,$oplata,$sum,$success,$succsumm);
    return $arr;
}
function stata_edit($ip,$sum,$day,$bp='../step/stata/'){
    $today = $day;
    if(!file_exists($bp.$today.'.db')){
    $db = new SQLite3($bp.$today.'.db');
    $db->exec("CREATE TABLE 'user'
               ('ip' VARCHAR(20), 
               'open' INT(11), 
               'oplata' INT(11), 
               'sum' INT(11), 
               'success' INT(11), 
               'succsumm' INT(11))");
}else{
    $db = new SQLite3($bp.$today.'.db');
}
    $res_test = $db->querySingle("SELECT * FROM user WHERE ip='$ip'");
    
			if(!empty($res_test)){
				$db->exec("UPDATE user SET oplata=oplata+1,sum=sum+$sum,success=success+1,succsumm=succsumm+$sum WHERE ip='$ip'");
                
			}else{
                $db->exec("INSERT INTO user VALUES ('$ip',0,1,'$sum',1,'$sum')");
                
			}
}
function order_add($ip,$id,$sum,$url,$bp='../step/stata/'){
     if(!file_exists($bp.'orders.db')){
        $dbo = new SQLite3($bp.'orders.db');
        $dbo->exec("CREATE TABLE 'orders'
               ('ip' VARCHAR(20), 
               'id' INT(11),  
               'sum' INT(11), 
               'success' INT(11),
               'url' TEXT)");
        }else{
            $dbo = new SQLite3($bp.'orders.db');
        }
        $res_o = $dbo->querySingle("SELECT * FROM orders WHERE id='$id'");
			if(!empty($res_o)){
				$dbo->exec("UPDATE orders SET sum=$sum WHERE id='$id'");
			}else{
                $dbo->exec("INSERT INTO orders VALUES ('$ip','$id','$sum',0,'$url')");  
			}
            $dbo->close();
}
function order_succ($id,$bp='../step/stata/'){
     $dbo = new SQLite3($bp.'orders.db');
        $dbo->exec("UPDATE orders SET success=1 WHERE id='$id'");
     $dbo->close();
}
function order_form($id,$bp='../step/stata/'){
     $db = new SQLite3($bp.'orders.db');
     $results = $db->query('SELECT * FROM orders WHERE id='.$id);
     while ($row = $results->fetchArray()) {
        $stack = array(
        'ip' => $row['ip'],
        'id' => $row['id'],
        'sum' => $row['sum'],
        'success' => $row['success'],
        'url' => $row['url'],
        );
    }
    $db->close();
    return $stack;   
}
function qiwi_kosh($n='',$bp='./'){
    $id = ''; $num = ''; $token = ''; $status = ''; $sum = ''; $blok = ''; $aktiv ='';
    if(file_exists($bp.'database/qkosh.db')){
    $db = new SQLite3($bp.'database/qkosh.db');
    $stack = array();
    $w = '';
    if($n != ''){$w = ' WHERE id='.$n;}
    $results = $db->query('SELECT * FROM kosh'.$w);
    while ($row = $results->fetchArray()) {
        array_push($stack, array(
        'id' => $row['id'],
        'num' => $row['num'],
        'token' => $row['token'],
        'hook' => $row['hook'],
        'key' => $row['key'],
        'status' => $row['status'],
        'sum' => $row['sum'],
        'blok' => $row['blok'],
        'aktiv' => $row['aktiv'],
        ));
    }
    $db->close();
    }
    return $stack;
}
function qiwi_blok($token){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/person-profile/v1/profile/current?authInfoEnabled=false&contractInfoEnabled=true&userInfoEnabled=false');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Authorization: Bearer '.$token
                )
                );
    $out = curl_exec($curl);
    curl_close($curl);
    $obj = json_decode($out,true);
    $block = $obj['contractInfo']['blocked'];
    if($block === false){
        $r = 'ok';
    }else{
        $r = 'block';
    }
    return $r;
}
function qiwi_balans($num, $token){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/funding-sources/v2/persons/'.$num.'/accounts');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Authorization: Bearer '.$token
                )
                );
    $out = curl_exec($curl);
    curl_close($curl);
    $obj = json_decode($out,true);
    $balans = $obj['accounts'][0]['balance']['amount'];
    $cur = $obj['accounts'][0]['balance']['currency'];
    return $balans;
}
function qiwi_hook_see($token){
    $url='https://edge.qiwi.com/payment-notifier/v1/hooks/active';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Bearer '.$token));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //Получаем данные

    $response = curl_exec($ch);
    $json = json_decode( $response, true );
    if(isset($json[errorCode])){
        $my_hook = 'no';
    }else{
    $my_hook = $json[hookId];
    }
    return $my_hook;
}
function qiwi_hook_del($hook,$token){
    $url='https://edge.qiwi.com/payment-notifier/v1/hooks/' . $hook;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $json = json_decode( $response, true );
    if(isset($json[errorCode])){
        $rr = 'no';
    }else{
        $rr = 'ok';//$json[response];
         }
         return $rr;
    }
function qiwi_hook_add($token){
    $domen = urlencode('http://'.$_SERVER['HTTP_HOST'].'/pays/hook.php');
    $url='https://edge.qiwi.com/payment-notifier/v1/hooks?hookType=1&param='.$domen.'&txnType=2';
    $data = array('hookType'=>'1','param'=>$domen,'txnType'=>'2');
    $data_json = json_encode($data);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token,'Content-Length: ' . strlen($data_json)));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $json = json_decode( $response, true );
    if(isset($json[errorCode])){
        $err = 'no';
    }else{
        $err = $json[hookId];
    }
    return $err;
}
function qiwi_key($hook,$token){
    $url='https://edge.qiwi.com/payment-notifier/v1/hooks/'.$hook.'/key';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $json = json_decode( $response, true );
    $err = $json[key];
    return $err;
}
function qiwi_key_reload($hook,$token){
    $url='https://edge.qiwi.com/payment-notifier/v1/hooks/'.$hook.'/newkey';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: */*','Authorization: Bearer '.$token));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $json = json_decode( $response, true );
    $rr = $json[key];
    return $rr;
    }
function qiwi_out($num,$token,$sum){
    $url='https://edge.qiwi.com/sinap/api/v2/terms/99/payments';
    $rr = json_encode(array(
    "id"=>"".(1000*date("U"))."",
        "sum"=>array(
          "amount"=>$sum,
          "currency"=>"643"
        ),
        "paymentMethod"=>array(
          "type"=>"Account",
          "accountId"=>"643"
        ),
        "comment"=>"test",
        "fields"=>array(
          "account"=>"+".$num.""
        )
));
    $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Accept: application/json','Authorization: Bearer '.$token));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $rr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $out = curl_exec($ch);
    curl_close($ch);
    $obj = json_decode($out,true);
    $state = $obj['transaction']['state']['code'];
    return $state;
}
function qiwi_out_card($num,$token,$sum){
    $field = 'cardNumber='.$num;
    $url='https://qiwi.com/card/detect.action'; //запрос карты
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json','Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $json = json_decode( $response, true );
    $id = $json['message'];   
    
    $sum = ($sum - 50) / (1 + 0.02);
    $url='https://edge.qiwi.com/sinap/api/v2/terms/'.$id.'/payments';
    $rr = json_encode(array(
    "id"=>"".(1000*date("U"))."",
        "sum"=>array(
          "amount"=>$sum,
          "currency"=>"643"
        ),
        "paymentMethod"=>array(
          "type"=>"Account",
          "accountId"=>"643"
        ),
        "fields"=>array(
          "account"=>"".$num.""
        )
    ));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Accept: application/json','Authorization: Bearer '.$token));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $rr);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $out = curl_exec($ch);
    curl_close($ch);
    $obj = json_decode($out,true);
    $state = $obj['transaction']['state']['code'];
    return $state;
}
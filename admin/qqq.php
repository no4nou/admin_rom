<?
    $field = 'cardNumber=5536913781048679';
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
    echo $json['code']['value'];
    echo $json['message'];
    
    
    
    
    $rr = json_encode(array(
    "id"=>"".(1000*date("U"))."",
        "sum"=>array(
          "amount"=>100,
          "currency"=>"643"
        ),
        "paymentMethod"=>array(
          "type"=>"Account",
          "accountId"=>"643"
        ),
        "comment"=>"test",
        "fields"=>array(
          "account"=>"+78987"
        )
));
echo  $rr.'   '.(1000*date("U"));
/*
$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/funding-sources/v2/persons/79675317438/accounts');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Authorization: Bearer 12024f4fea5918fabd05d62891f21072'
                )
                );
    $out = curl_exec($curl);
    curl_close($curl);
    $obj = json_decode($out,true);
    //print_r($obj['accounts'][0]['balance']['amount']);
    $balans = $obj['accounts'][0]['balance']['amount'];
    echo $balans;
    
    echo '<br><br>';
$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/person-profile/v1/profile/current?authInfoEnabled=false&contractInfoEnabled=true&userInfoEnabled=false');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Authorization: Bearer 5f5cfd5d22698846ea190c752d560a82'
                )
                );
    $out = curl_exec($curl);
    echo $out;
    curl_close($curl);
    echo '<br><br>';
    $obj = json_decode($out,true);
    $block = $obj['contractInfo']['blocked'];
    if($block === false){
        echo 'ok';
    }else{
        echo 'block';
    }*/
    ?>
    <meta charset="utf-8">
                    <form action="" method="POST">
                            <input type="submit" name="profile" value="profile">
                            <input type="submit" name="balance" value="balance">
                            <input type="submit" name="identification" value="identification">
                            <input type="submit" name="show_hook" value="show_hook">
                            <input type="submit" name="del_hook" value="del_hook">
                            <input type="submit" name="new_hook" value="new_hook">
                            <input type="submit" name="key" value="key">
                            <input type="submit" name="new_key" value="new_key">
                            <input type="submit" name="test" value="test">
                    <form>
        </br>
<?php
include_once('config.php');
include_once('lib.php');

     $db = new SQLite3('../step/stata/orders.db');
     $results = $db->query('SELECT * FROM orders');
     $stack = array();
     while ($row = $results->fetchArray()) {
        array_push($stack, array(
        'ip' => $row['ip'],
        'id' => $row['id'],
        'sum' => $row['sum'],
        'success' => $row['success'],
        'url' => $row['url'],
        ));
    }
    $db->close();
    //print_r($stack);   


//print_r(qiwi_kosh(1));

  $token = '5f5cfd5d22698846ea190c752d560a82';               // мои данные
  $wallet = '79803301604';
  $host = 'http://'.$_SERVER['SERVER_NAME'];
  $domen = $host.'/pays/hook.php';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// просмотр профиля
      if( isset( $_POST['profile'] ) )
    {
        $url='https://edge.qiwi.com/person-profile/v1/profile/current';  

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json','Content-Type: application/json','Authorization: Bearer '.$token));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                        //Получаем данные

$response = curl_exec($ch);
json_decode($response);
echo $response;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// запрос баланса
      if( isset( $_POST['balance'] ) )
    {
        $url='https://edge.qiwi.com/funding-sources/v2/persons/'.$wallet.'/accounts';  

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json','Authorization: Bearer '.$token));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$json = json_decode( $response, true );
echo 'Баланс: '.$json[accounts][0][balance][amount];
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Идентификация
      if( isset( $_POST['identification'] ) )
    {
        $url='https://edge.qiwi.com/identification/v1/persons/'.$wallet.'/identification';  

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json','Authorization: Bearer '.$token));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                        //Получаем данные

$response = curl_exec($ch);
$json = json_decode( $response, true );
$id = $json[id];
echo '<ul><li>ID: '.$id.'</li><li>'.
'firstName: '.$json[firstName].'</li><li>'.
'middleName: '.$json[middleName].'</li><li>'.
'lastName: '.$json[lastName].'</li><li>'.
'birthDate: '.$json[birthDate].'</li><li>'.
'passport: '.$json[passport].'</li><li>'.
'inn: '.$json[inn].'</li><li>'.
'snils: '.$json[snils].'</li><li>'.
'oms: '.$json[oms].'</li><li>'.
'type: '.$json[type].'</li></ul>';

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// просмотр хука
    if( isset( $_POST['show_hook'] ) )
    {
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
    echo 'Хука еще нет! '.$json[userMessage];
}else{
$my_hook = 'хук: '. $json[hookId].'</br>домен: '. $json[hookParameters][url];
echo $my_hook;
    }
    }
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// удаление хука
if( isset( $_POST['del_hook'] ) )
    {
        $url='https://edge.qiwi.com/payment-notifier/v1/hooks/active';  // находим хук

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Bearer '.$token));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//Получаем данные

$response = curl_exec($ch);
$json = json_decode( $response, true );
$hookId = $json[hookId];

        //удаляем
$url='https://edge.qiwi.com/payment-notifier/v1/hooks/' . $hookId;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
$response = curl_exec($ch);
$json = json_decode( $response, true );
if(isset($json[errorCode])){
    echo 'Нечего удалять. '.$json[userMessage];
}else{
    echo $json[response];
     }
    }

    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// создание хука
        if( isset( $_POST['new_hook'] ) )
    {
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
    echo 'Хук уже создан! '.$json[userMessage];
}else{
    echo 'Создан хук: '. $json[hookId]. '</br>для домена: '.$json[hookParameters][url];
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// получение ключа
      if( isset( $_POST['key'] ) )
    {
        $url='https://edge.qiwi.com/payment-notifier/v1/hooks/active';  // находим хук

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Bearer '.$token));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                        //Получаем данные

$response = curl_exec($ch);
$json = json_decode( $response, true );
$hookId = $json[hookId];
                                                                        //Получаем ключ
$url='https://edge.qiwi.com/payment-notifier/v1/hooks/'.$hookId.'/key';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$json = json_decode( $response, true );
echo 'КЛЮЧ:   '.$json[key];
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// изменение ключа
      if( isset( $_POST['new_key'] ) )
    {
       $url='https://edge.qiwi.com/payment-notifier/v1/hooks/active';  // находим хук

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Bearer '.$token));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                        //Получаем данные

$response = curl_exec($ch);
$json = json_decode( $response, true );
$hookId = $json[hookId];
                                                                        //Получаем ключ
$url='https://edge.qiwi.com/payment-notifier/v1/hooks/'.$hookId.'/newkey';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer f6dfdf8523f3cee2914136d860b9e01c'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$json = json_decode( $response, true );
echo 'НОВЫЙ КЛЮЧ:   '.$json[key];
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// тест
if( isset( $_POST['test'] ) )
    {
       $url='https://edge.qiwi.com/payment-notifier/v1/hooks/test';
       
       $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$json = json_decode( $response, true );
echo $response;

}

?>

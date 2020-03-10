<?
if(empty($_REQUEST['pay'])){exit();}

ini_set('display_errors', 'On');
include_once('../admin/opt/optopl.php');
if($optopl == 'ya'){
    header("Location: yadopl.php?pay=".$_REQUEST['pay']);
    exit();    
    
}
include_once('../admin/lib.php');

if (!isset($_COOKIE['sum'.$_REQUEST['pay']])){
    header("Location: /");
}else{
    $summa = $_COOKIE['sum'.$_REQUEST['pay']];
}
$kosh = qiwi_kosh('','../admin/');
$id = rand(10000,99999);
$order = 'Order-id:'.$id;

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
$url = 'http://'.$_SERVER['HTTP_HOST'].'/pays/outopl.php?outs='.$id;

// расчет вывода $xam = ($amount - 50) / (1 + 0.02);
  //**********************запись ордера**********//          
 order_add($ipuser,$id,$summa,$_REQUEST['pay'],'../step/stata/');
$qiwi = $kosh[0]['num'];
    $dbq = new SQLite3('../admin/database/qkosh.db');
if(count($kosh) > 1){
    //echo count($kosh);
    $tes = 0;
    foreach($kosh as $key=>$value){
        if($value['aktiv'] == 1){
        if($tes == 1){
            $dbq->exec("UPDATE kosh SET blok=0 WHERE num='".$value['num']."'");
            break;
        }
        if($value['blok'] == 0){
            $qiwi = $value['num'];
            $dbq->exec("UPDATE kosh SET blok=1 WHERE num='".$value['num']."'");
            $tes = 1;
        }
        }
    }
    if($tes == 0){
        $qiwi = $kosh[0]['num'];
        $dbq->exec("UPDATE kosh SET blok=0, aktiv=1 WHERE num='".$kosh[1]['num']."'");
    }
}else{                                                 
    $dbq->exec("UPDATE kosh SET blok=0, aktiv=1 WHERE num='".$kosh[0]['num']."'");
}
$qwer = "extra['account']=$qiwi&amountInteger=$summa&currency=643&extra['comment']=$order&blocked[0]=sum&blocked[1]=account&blocked[2]=comment";
$link = 'https://qiwi.com/payment/form/99?'.$qwer;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Оплата товара</title>
	<style>
		body, html {
			background: #f5f5f5;
		}
		* {
			font-family: Verdana, Arial, sans-serif;
		}
		h3 {
			font-size: 22px;
			text-align: center;
		}
		@media (max-device-width: 600px) {
			h3 {
				font-size: 16px;
			}
		}
		#steps {
			position: relative;
			height: 440px;
			padding: 20px;
		}
		#steps>* {
			position: absolute;
		}
		.step {
			padding: 20px;
			border: 2px solid #ff8c1b;
			border-radius: 6px;
			display: inline-block;
			font-size: 14px;
		}
		.step-header {
			font-weight: bold;
			margin-bottom: 6px;
		}
		.step-1 {
			top: 50px;
			left: 50px;
		}
		.qiwi-instruction-1 {
			left: 200px;
		}
		.step-2 {
			left: 35px;
			top: 264px;
			width: 120px;
		}
		.qiwi-instruction-2 {
			top: 200px;
			left: 200px;
		}
		.step-3 {
			top: 264px;
			right: 0;
			width: 178px;
		}
		a.btn-submit-card {
			text-decoration: none !important;
			margin-top: 10px;
			display: block;
			text-align: center;
			width: 90%;
			margin: 0 auto;
			background: #ff8c1b;
			padding: 14px 0;
			color: #fff !important;
			border-radius: 6px;
		}
		#payInstruct {
			width: 800px;
			min-width: 800px;
			max-width: 100%;
			margin: 0 auto;
			padding: 20px;
			padding-top: 0;
			padding-bottom: 40px;
			background: #fff;
			border-radius: 6px;
			border: 1px solid #eee;
		}
		img {
			max-width: 100%; 
			display: block;
		}
	</style>
</head>
<body>
	<div id="payInstruct">
		<h3>Как оплатить банковской картой без регистрации<br>в QIWI-кошельке на следующей странице</h3>
		<div id="steps">
			<div class="step step-1">
				<div class="step-header">Шаг 1</div>
				<div class="step-info"><u>Нажмите сюда</u></div>
			</div>
			<div class="step step-2">
				<div class="step-header">Шаг 2</div>
				<div class="step-info"><u>Введите данные вашей карты</u></div>
			</div>
			<div class="step step-3">
				<div class="step-header">Шаг 3</div>
				<div class="step-info">Оплатите и получите оплаченную услугу</div>
			</div>
			<img class="qiwi-instruction-1" src="img/qiwi-instruction-1.jpg">
			<img class="qiwi-instruction-2" src="img/qiwi-instruction-2.jpg">
		</div>
		<a href="#" class="btn-submit-card">Перейти к оплате ></a>
	</div>
	<iframe src="<?=$link?>" 
	frameborder="0" id="payFrame" style="height: 0; width: 100%;"></iframe>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
		$(function(){
			$(document).on('click', '.btn-submit-card', function(e){
				e.preventDefault();
				$('#payInstruct').hide();
				$('#payFrame').css({height: '100vh'});

				setTimeout(function(){
					setInterval(function(){
					   $.post('edit.php', { tip: 'opl', data: '<?=$id?>:<?=$ipuser?>:<?=$summa?>' })
                       .done(function(data) {
                        if(data == 1){
                            window.location.href = '<?=$url?>';
                        }                                                
                        });
					}, 5000);
				}, 12000);
			});
		});
	</script>
</body>
</html>
<?
include_once('config.php');
include_once('lib.php');
include_once('./opt/kosh.php');
include_once('./opt/ups.php');
include_once('./opt/optopl.php');
if($optopl == 'ya'){$yact = ' active'; $ya = ' checked'; $yatext = 'Активен для оплаты'; $qiwitext = 'Применить для оплаты'; $billix_text = 'Применить для оплаты';}
if($optopl == 'qiwi'){$qiwact = ' active'; $qiwcheck = ' checked'; $qiwitext = 'Активен для оплаты'; $yatext = 'Применить для оплаты'; $billix_text = 'Применить для оплаты';}
if($optopl == 'billix'){$billix_act = ' active'; $billix_check = ' checked'; $billix_text = 'Активен для оплаты'; $qiwitext = 'Применить для оплаты'; $yatext = 'Применить для оплаты';}
if (!isset($_COOKIE['hash'])){
    if(empty($_POST['pass'])){
?>
<form method="post">
<input type="text" name="pass" reguired />
<button type="submit" name="submit">ENTER</button>
</form>
<?
exit();
}else{
    if($_POST['pass'] == $pass){
        setcookie("hash", $pass, time() + 3600*24*30*12, "/");
        header("Location: /admin");
        exit();
    }else{
        echo "ERROR PASS";
        exit();
    }
}
}
if($_COOKIE['hash'] != $pass){
    setcookie('hash', '', time() - 100, '/');
    echo "ERROR LOGIN PASS ".$_COOKIE['hash'];
    header("Location: admin.php");
    exit();
}else{?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>админка</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="cd-modal.css" />
		</head>
    <body>

    <div class="container-fluid">
<div class="row">

<div class="col-6 offset-3">

    <br />
    <button class="btn btn-primary btn-lg btn-block cd-modal-trigger" data-names="7">Настройка системы</button>
<br />
<button class="btn btn-warning btn-lg btn-block cd-modal-trigger" data-names="1">Настройка ЯД кошельков</button>
<br />
<button class="btn btn-warning btn-lg btn-block cd-modal-trigger" data-names="5">Настройка Qiwi кошельков</button>
    <br />
    <button class="btn btn-warning btn-lg btn-block cd-modal-trigger" data-names="6">Настройка Billix</button>
<br />
<button class="btn btn-info btn-lg btn-block cd-modal-trigger" data-names="2">Настройка апселлов</button>
<br />
<button class="btn btn-success btn-lg btn-block cd-modal-trigger" data-names="3">Статистика</button>
<br />
<button class="btn btn-danger btn-lg btn-block cd-modal-trigger" data-names="4">Инструкция</button>
<br />

</div><!-- ./col-md-6 col-md-offset-3 -->

</div><!-- ./row -->
</div><!-- ./container -->

<?include_once('yaa.php');?>

<?include_once('qiw.php');?>

    <?include_once('billix.php');?>
    <?include_once('system.php');?>

<div class="cd-modal 2" tabindex="-1" role="dialog">
 <div class="modal-content bg-info" role="document">
 <h1>Настройка апселлов</h1>
 <div class="row">
 <?
 for($i = 0; $i < 5; $i++){
    $eve = explode('-', $sum[$i]);
    ?>
    <div class="col">
        <div class="row">
            <div class="col-12">
                <label for="recipient-aps<?=($i+1)?>" class="form-control-label">upsell №<?=($i+1)?></label>
                <input type="text" name="aps<?=($i+1)?>" class="btn-block" id="recipient-aps<?=($i+1)?>" value="<?=$url[$i]?>" />
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="recipient-sum<?=($i+1)?>-min" class="form-control-label">цена <?=($i+1)?> min</label>
                <input type="number" step="1" name="sum<?=($i+1)?>-min" class="btn-block" id="recipient-sum<?=($i+1)?>-min" value="<?=$eve[0]?>" />
            </div>
            <div class="col">
                <label for="recipient-sum<?=($i+1)?>-max" class="form-control-label">цена <?=($i+1)?> max</label>
                <input type="number" step="1" name="sum<?=($i+1)?>-max" class="btn-block" id="recipient-sum<?=($i+1)?>-max" value="<?=$eve[1]?>" />
            </div>
        </div>
        <hr />
    </div>
 <?}?>
 </div>

  <div class="row">
 <?
 for($i = 5; $i < 10; $i++){
    $eve = explode('-', $sum[$i]);
    ?>
    <div class="col">
        <div class="row">
            <div class="col-12">
                <label for="recipient-aps<?=($i+1)?>" class="form-control-label">upsell №<?=($i+1)?></label>
                <input type="text" name="aps<?=($i+1)?>" class="btn-block" id="recipient-aps<?=($i+1)?>" value="<?=$url[$i]?>" />
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="recipient-sum<?=($i+1)?>-min" class="form-control-label">цена <?=($i+1)?> min</label>
                <input type="number" step="1" name="sum<?=($i+1)?>-min" class="btn-block" id="recipient-sum<?=($i+1)?>-min" value="<?=$eve[0]?>" />
            </div>
            <div class="col">
                <label for="recipient-sum<?=($i+1)?>-max" class="form-control-label">цена <?=($i+1)?> max</label>
                <input type="number" step="1" name="sum<?=($i+1)?>-max" class="btn-block" id="recipient-sum<?=($i+1)?>-max" value="<?=$eve[1]?>" />
            </div>
        </div>
        <hr />
    </div>
 <?}?>
 </div>

  <div class="row">
 <?
 for($i = 10; $i < 15; $i++){
    $eve = explode('-', $sum[$i]);
    ?>
    <div class="col">
        <div class="row">
            <div class="col-12">
                <label for="recipient-aps<?=($i+1)?>" class="form-control-label">upsell №<?=($i+1)?></label>
                <input type="text" name="aps<?=($i+1)?>" class="btn-block" id="recipient-aps<?=($i+1)?>" value="<?=$url[$i]?>" />
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="recipient-sum<?=($i+1)?>-min" class="form-control-label">цена <?=($i+1)?> min</label>
                <input type="number" step="1" name="sum<?=($i+1)?>-min" class="btn-block" id="recipient-sum<?=($i+1)?>-min" value="<?=$eve[0]?>" />
            </div>
            <div class="col">
                <label for="recipient-sum<?=($i+1)?>-max" class="form-control-label">цена <?=($i+1)?> max</label>
                <input type="number" step="1" name="sum<?=($i+1)?>-max" class="btn-block" id="recipient-sum<?=($i+1)?>-max" value="<?=$eve[1]?>" />
            </div>
        </div>
        <hr />
    </div>
 <?}?>
 </div>

 <div class="row">
    <div class="col-4 offset-4">
        <button class="btn btn-warning btn-lg btn-block send" data-play="aps">Применить</button>
    </div>
 </div>
 </div> <!-- .modal-content -->

 <a href="#0" class="modal-close">Close</a>
</div> <!-- .cd-modal -->


<div class="cd-modal 3" tabindex="-1" role="dialog">
 <div class="modal-content bg-success text-white" role="document">
 <h1>Статистика</h1>
    <div class="row">
        <div class="col-8 offset-2">
            <table class="table table-dark table-striped table-bordered">
    <thead>
      <tr>
        <th>Дата</th>
        <th>Переходы</th>
        <th>На оплату</th>
        <th>Возможный профит</th>
        <th>Оплачено</th>
        <th>Текущий профит</th>
        <th>EPC руб.</th>
      </tr>
    </thead>
    <tbody>
    <?
    for($i=0; $i<7; $i++){
        $dat = date('d.m.Y', time() - 86400 * $i);
        $stata = stata_all($dat);

        $stata[4] > 0 && $stata[0] > 0 ? $epc = round(($stata[4] / $stata[0]), 2) : $epc = 0;

        ?>
      <tr>
        <td class="data<?=($i+1)?>"><?=$dat?></td>
        <td class="open<?=($i+1)?>"><?=$stata[0]?></td>
        <td class="oplata<?=($i+1)?>"><?=$stata[1]?></td>
        <td class="sum<?=($i+1)?>"><?=$stata[2]?></td>
        <td class="success<?=($i+1)?>"><?=$stata[3]?></td>
        <td class="succsumm<?=($i+1)?>"><?=$stata[4]?></td>
        <td class="epc<?=($i+1)?>"><?=$epc?></td>
      </tr>
      <?}?>
    </tbody>
  </table>
        </div>
    </div>

 </div> <!-- .modal-content -->

 <a href="#0" class="modal-close">Close</a>
</div> <!-- .cd-modal -->


<div class="cd-modal 4" tabindex="-1" role="dialog">
 <div class="modal-content" role="document">
 <h1>Инструкция</h1>

<img src="http://drawings-girls.ucoz.net/2016/10/rijaia-devushka-s-rukoi-demona.jpg" class="img-responsive" alt="" />

 <h2>
1) Кошельки
 </h2>
 <p>
Для использования только одного кошелька необходимо вписать его номер в ЛЮБОЕ из полей формы настроек, после применения кошелек автоматически встанет на первое место.
 </p>
 <p>
Для смены кошельков необходимо прописать в ЛЮБЫХ полях формы настроек два или более номеров, при каждом посещении страницы оплаты кошельки будут меняться.
 </p>
 <h2>
2) Апселлы
 </h2>
 <p>
Каждый блок определяет собой апселл, в поле upsell №... необходимо прописывать страницу на которую должен попадать мамонт ПОСЛЕ оплаты.
 </p>
 <p>
Поля цена мин и макс определяют ценовой диапазон для конкретного апселла. генерируется случайно и остается персональной для каждого мамонта.
 </p>
 <h2>
3) Установки
 </h2>
 <p>
Каждая цена апселла определяется уникальной и в местах где она должна отображаться на странице оффера прописывается как &lt;?=$_COOKIE['sumX']?&gt; где Х - номер апселл стоимости
 </p>
 <p>
Для направления мамонта на оплату применима ссылка вида &lt;a href="/pays/opl.php?pay=Х"&gt;текст ссылки&lt;/a&gt; где Х - номер оплаты определенного апселла.
 </p>
 <p>
Для корректной отработки статистики необходимо пиарить ссылку <b>http://<?=$_SERVER['HTTP_HOST']?>/step/</b>
 </p>
 </div> <!-- .modal-content -->

 <a href="#0" class="modal-close">Close</a>
</div> <!-- .cd-modal -->

<div class="cd-transition-layer">
 <div class="bg-layer"></div>
</div> <!-- .cd-transition-layer -->

<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="modernizr.js"></script>
<script src="rotate-number.min.js"></script>
<script src="main.js?<?=date("U")?>"></script>
<script>
jQuery(document).ready(function($){
    $('[data-toggle="tooltip"]').tooltip();
	//cache some jQuery objects
	var modalTrigger = $('.cd-modal-trigger'),
		transitionLayer = $('.cd-transition-layer'),
		transitionBackground = transitionLayer.children();
		//modalWindow = $('.cd-modal');

	var frameProportion = 1.78, //png frame aspect ratio
		frames = 25, //number of png frames
		resize = false;

	//set transitionBackground dimentions
	setLayerDimensions();
	$(window).on('resize', function(){
		if( !resize ) {
			resize = true;
			(!window.requestAnimationFrame) ? setTimeout(setLayerDimensions, 300) : window.requestAnimationFrame(setLayerDimensions);
		}
	});

	//open modal window
	modalTrigger.on('click', function(event){
	   var names = $(this).data('names');
       var modalWindow = $('.'+names);
       //alert(modalWindow.text());
		event.preventDefault();
		transitionLayer.addClass('visible opening');
		var delay = ( $('.no-cssanimations').length > 0 ) ? 0 : 600;
		setTimeout(function(){
			modalWindow.addClass('visible');
		}, delay);
	});

	//close modal window
	$('.modal-close').on('click', function(event){
		event.preventDefault();
		transitionLayer.addClass('closing');
		$('div').parent('.cd-modal').removeClass('visible');
		transitionBackground.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
			transitionLayer.removeClass('closing opening visible');
			transitionBackground.off('webkitAnimationEnd oanimationend msAnimationEnd animationend');
		});
	});

	function setLayerDimensions() {
		var windowWidth = $(window).width(),
			windowHeight = $(window).height(),
			layerHeight, layerWidth;

		if( windowWidth/windowHeight > frameProportion ) {
			layerWidth = windowWidth;
			layerHeight = layerWidth/frameProportion;
		} else {
			layerHeight = windowHeight*1.2;
			layerWidth = layerHeight*frameProportion;
		}

		transitionBackground.css({
			'width': layerWidth*frames+'px',
			'height': layerHeight+'px',
		});

		resize = false;
	}
});
</script>
    </body>
    </html>
<?}?>

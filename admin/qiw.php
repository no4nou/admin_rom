<?

$viv = $dba->querySingle("SELECT * FROM viplata WHERE ids=1", true);
if($viv['tip'] == 'card'){ $card = ' checked'; $cact = ' active';}
if($viv['tip'] == 'tel'){ $tel = ' checked'; $tact = ' active';}
?>
<div class="cd-modal 5" tabindex="-1" role="dialog">
 <div class="modal-content bg-warning" role="document">
 <h1>Настройка Qiwi кошельков</h1>
 
 <div class="row">
 <div class="col-4 offset-4">
    <label class="btn btn-block btn-primary<?=$qiwact?>">
            <input type="radio" class="optopl" name="options" id="qiwi" autocomplete="off" value="qiwi"<?=$qiwcheck?>> <?=$qiwitext?>
        </label>
        <br />
        <p></p>
 </div>
 </div>
    <div class="row">
        <div class="col-10 offset-1">
        <div class="row">
        <div class="col-3">
        <label for="vivod-sum" class="form-control-label">сумма к выводу</label>
        <input id="vivod-sum" class="form-control btn-primary sumvivod" type="text" value="<?=$viv['sum']?>">
        </div>
        <div class="col-3">
        <label for="vivod-num" class="form-control-label">номер кошелька</label>
        <input id="vivod-num" class="form-control btn-primary numvivod" type="text" value="<?=$viv['num']?>"></div>
        <div class="col-3">
        <label for="vivod-chek" class="form-control-label">тип кошелька</label>
        <div id="vivod-chek" class="btn-group aero" data-toggle="buttons">
        <label class="btn btn-primary<?=$cact?>">
            <input type="radio" name="options" id="option1" autocomplete="off" value="card"<?=$card?>> Карта
        </label>
        <label class="btn btn-primary<?=$tact?>">
            <input type="radio" name="options" id="option2" autocomplete="off" value="tel"<?=$tel?>> Qiwi
        </label>
        </div></div>
        <div class="col-3">
        <label for="vivod-but" class="form-control-label">.</label>
        <button id="vivod-but" class="btn btn-primary btn-block save" >Применить</button></div>
        </div>
            <table class="table table-dark table-striped table-bordered">
    <thead>
      <tr>
        <th>№</th>
        <th>Кошелек</th>
        <th>Токен</th>
        <th>Hook</th>
        <th>Key</th>
        <th>Статус</th>
        <th>Баланс</th>
        <th>Текущий</th>
        <th>Работа</th>
        <th>Вывел</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody>
    <?
    $arr = qiwi_kosh();
    for($i=0; $i <10; $i++){?>
    <tr>
        <td class="align-middle"><?=($i+1)?></td>
        <td class="align-middle"><input class="form-control form-control-sm btn-dark qiwi qkosh<?=$i?>" type="text" value="<?=$arr[$i]['num']?>"></td>
        <td class="align-middle"><input class="form-control form-control-sm btn-dark qtoken<?=$i?>" type="text" value="<?=$arr[$i]['token']?>"></td>
        <td class="align-middle"><input class="form-control form-control-sm btn-dark qhook<?=$i?>" type="text" value="<?=$arr[$i]['hook']?>"></td>
        <td class="align-middle"><input class="form-control form-control-sm btn-dark qkey<?=$i?>" type="text" value="<?=$arr[$i]['key']?>"></td>
        <td class="align-middle qstatus<?=$i?>"><? if($arr[$i]['status'] == 1) echo 'online'; else echo 'blocked'; ?></td>
        <td class="align-middle qbalans<?=$i?>"></td>
        <td class="align-middle qblok<?=$i?>"><?if($arr[$i]['blok'] == 0){echo '+';}else{echo '+';}?></td>
        <td class="align-middle qaktiv<?=$i?>"><?if($arr[$i]['aktiv'] == 0){echo 'неактив';}else{echo 'актив';}?></td>
        <td class="align-middle qsum<?=$i?>"><?=$arr[$i]['sum']?></td>
        <td class="align-middle">
        <table>
        <tr>
        <td>
        <button class="btn btn-success btn-sm btn-block cd-modal-trigger viv" data-num="<?=$i?>" data-toggle="tooltip" title="Вывод средств с кошелька не дожидаясь установленного лимита">Вывод</button>
        </td>
        <td>
        <button class="btn btn-info btn-sm btn-block cd-modal-trigger reloads" data-num="<?=$i?>" data-toggle="tooltip" title="Переключатель доступности кошелька для оплаты">Перек.</button>
        </td>
        <td>
        <button class="btn btn-danger btn-sm btn-block cd-modal-trigger qadd" data-num="<?=$i?>" data-toggle="tooltip" title="Запись нового кошелька или получение и обновление ключей рабочего кошелька">Save</button>
        </td>
        <td>
        <button class="btn btn-dark btn-sm btn-block cd-modal-trigger gdel" data-num="<?=$i?>" data-toggle="tooltip" title="Удаление кошелька">DEL</button>
        </td>
        </tr>
        </table>
        </td>
      </tr>
      <?}?>
    </tbody>
  </table>
 <hr />
 <hr />
        <h1>Примечание:</h1>
        <p>Для ротации, необходимо указать два и более кошельков. Для использования одного кошелька - указывать только первый номер!!!</p>
   
        </div>
    </div>
 
 </div> <!-- .modal-content -->

 <a href="#0" class="modal-close">Close</a>
</div> <!-- .cd-modal -->
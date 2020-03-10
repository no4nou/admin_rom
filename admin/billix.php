<?php
include './opt/billix.php';
!empty($billix['mid']) ? $bm = $billix['mid'] : $bm = '' ;
!empty($billix['api_key']) ? $bak = $billix['api_key'] : $bak = '' ;
!empty($billix['secret_key']) ? $bsk = $billix['secret_key'] : $bsk = '' ;
?>
<div class="cd-modal 6" tabindex="-1" role="dialog">
    <div class="modal-content bg-warning" role="document">
        <h1>Настройка Billix</h1>
        <div class="row">
            <div class="col-4 offset-4">
                <label class="btn btn-block btn-primary<?=$billix_act?>">
                    <input type="radio" class="optopl" name="options" id="billix" autocomplete="off" value="billix"<?=$billix_check?>> <?=$billix_text?>
                </label>
                <br />
                <p></p>
            </div>
        </div>

        <div class="row">
            <div class="col-1">
                <label for="mid" class="form-control-label">MID</label>
                <input id="mid" class="form-control btn-primary billix_mid" type="text" value="<?=$bm?>">
            </div>
            <div class="col-3">
                <label for="api_key" class="form-control-label">API ключ</label>
                <input id="api_key" class="form-control btn-primary billix_api" type="text" value="<?=$bak?>">
            </div>
            <div class="col-3">
                <label for="secret_key" class="form-control-label">Секретный ключ </label>
                <input id="secret_key" class="form-control btn-primary billix_secret" type="text" value="<?=$bsk?>">
            </div>
            <div class="col-2">
                <label for="save_billix" class="form-control-label">.</label>
                <button id="save_billix" class="btn btn-primary btn-block save_billix" >Применить</button>
            </div>
        </div>
        <hr />
        <hr />
        <hr />
        <hr />
        <hr />
        <hr />
        <div class="row">
            <div class="col-8 offset-2">
                <!--<h1>Примечание:</h1>
                <p>Для ротации, необходимо указать два и более кошельков. Для использования одного кошелька - указывать только первый номер!!!</p>-->
            </div>
        </div>
    </div> <!-- .modal-content -->

    <a href="#0" class="modal-close">Close</a>
</div> <!-- .cd-modal -->

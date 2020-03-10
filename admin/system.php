<?php
include './opt/plserv.php';
!empty($system['api_domain']) ? $sad = $system['api_domain'] : $sad = '' ;
!empty($system['offer_domain']) ? $sod = $system['offer_domain'] : $sod = '' ;
?>
<div class="cd-modal 7" tabindex="-1" role="dialog">
    <div class="modal-content bg-light" role="document">
        <h1>Настройка системы</h1>

        <hr />

        <div class="row">
            <div class="col-4 offset-4">
                <label for="domain" class="form-control-label">Домен платежки</label>
                <input id="domain" class="form-control btn-primary api_domain" type="text" value="<?=$sad?>">
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-4 offset-4">
                <label for="domain_offer" class="form-control-label">Домен офера</label>
                <input id="domain_offer" class="form-control btn-primary offer_domain" type="text" value="<?=$sod?>">
            </div>
        </div>

        <div class="row">
            <div class="col-4 offset-4">
                <hr align="center" width="300" color="Red" />
            </div>
        </div>

        <div class="row">
            <div class="col-4 offset-4">
                <button id="save_setting" class="btn btn-primary btn-block save_setting" >Применить</button>
            </div>
        </div>

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

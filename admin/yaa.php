<div class="cd-modal 1" tabindex="-1" role="dialog">
    <div class="modal-content bg-warning" role="document">
        <h1>Настройка ЯД кошельков</h1>
        <div class="row">
            <div class="col-4 offset-4">
                <label class="btn btn-block btn-primary<?=$yact?>">
                    <input type="radio" class="optopl" name="options" id="ya" autocomplete="off" value="ya"<?=$ya?>> <?=$yatext?>
                </label>
                <br />
                <p></p>
            </div>
        </div>

        <div class="row">
            <?
            for($i = 0; $i < 5; $i++){?>
                <div class="col">
                    <label for="recipient-kosh<?=($i+1)?>" class="form-control-label">кошелек №<?=($i+1)?></label>
                    <input type="text" name="kosh<?=($i+1)?>" class="btn-block" id="recipient-kosh<?=($i+1)?>" value="<?=$arr[$i]?>" />
                </div>
            <?}?>
        </div>
        <hr />
        <hr />
        <div class="row">
            <?
            for($i = 5; $i < 10; $i++){?>
                <div class="col">
                    <label for="recipient-kosh<?=($i+1)?>" class="form-control-label">кошелек №<?=($i+1)?></label>
                    <input type="text" name="kosh<?=($i+1)?>" class="btn-block" id="recipient-kosh<?=($i+1)?>" value="<?=$arr[$i]?>" />
                </div>
            <?}?>
        </div>
        <hr />
        <hr />
        <div class="row">
            <div class="col-4 offset-4">
                <button class="btn btn-info btn-lg btn-block send" data-play="kosh">Применить</button>
            </div>
        </div>
        <hr />
        <hr />
        <div class="row">
            <div class="col-8 offset-2">
                <h1>Примечание:</h1>
                <p>Для ротации, необходимо указать два и более кошельков. Для использования одного кошелька - указывать только первый номер!!!</p>
            </div>
        </div>
    </div> <!-- .modal-content -->

    <a href="#0" class="modal-close">Close</a>
</div> <!-- .cd-modal -->

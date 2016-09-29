<div class="row">
    <div class="span12 indent-bottom3">
        <h2>Активация промо-кода</h2>
    </div>

    <div class="span12">
        <?if(!empty($this->action->error)):?>
            <div class="alert alert-error">
                <strong>Ошибка!</strong> <?=$this->action->error?>
            </div>
        <?php elseif (!empty($this->action->success)):?>
            <div class="alert alert-success">
                <?=$this->action->success?>
            </div>
        <?endif?>
    </div>

    <form method="POST">
    <div class="span12 indent-bottom2">
        <div class="control-group">
            <label><sreong>Фамилия и Имя</sreong> или <strong>rocID</strong></label>
            <input type="text" placeholder="Введите ФИО" class="input-xlarge ui-autocomplete-input" name="Activation[Name]" id="NameOrRocid" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" value="<?if( isset ($activation)) echo $activation['Name']?>">
            <input type="hidden" name="Activation[RocId]" id="RocId" value="<?if( isset ($activation)) echo $activation['RocId']?>"/>
            <p class="help-block">
                <strong>Заметка:</strong> Просто начните набирать фамилию и имя или rocID пользователя. Здесь автоматически будут отображаться результаты поиска.
            </p>
        </div>
    </div>
    <div class="span12 indent-bottom1">
        <div class="control-group">
            <label>Промо-код</label>
            <input type="text" name="Activation[Coupon]" value="<?if( isset ($activation)) echo $activation['Coupon']?>" />
        </div>
    </div>
    <div class="span12">
        <input type="submit" value="Активировать" class="btn btn-primary" name="" />
    </div>
    </form>
</div>
<ul class="nav nav-pills">
    <li>
        <a href="<?=RouteRegistry::GetUrl('partner', 'coupon', 'index');?>">Промо-коды</a>
    </li>
    <li>
        <a href="<?=RouteRegistry::GetUrl('partner', 'coupon', 'users');?>">Активированные промо-коды</a>
    </li>
    <li class="active">
        <a href="<?=RouteRegistry::GetUrl('partner', 'coupon', 'activation');?>">Активация промо-кода</a>
    </li>
</ul>

<div class="row">
    <div class="span12 indent-bottom3">
        <h2>Активация промо-кода</h2>
    </div>
    
    <div class="span12">
        <?php if ( isset ($this->Error)):?>
            <div class="alert alert-error">
                <strong>Ошибка!</strong> <?php echo $this->Error;?>
            </div>
        <?php elseif ( isset ($this->Success)):?>
            <div class="alert alert-success">
                <?php echo $this->Success;?>
            </div>
        <?php endif;?>
    </div>
   
    <form method="POST">
    <div class="span12 indent-bottom2">
        <div class="control-group">
            <label><sreong>Фамилия и Имя</sreong> или <strong>rocID</strong></label>
            <input type="text" placeholder="Введите ФИО" class="input-xlarge ui-autocomplete-input" name="Activation[Name]" id="NameOrRocid" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" value="<?php if ( isset ($this->FieldValues)) echo $this->FieldValues['Name'];?>">
            <input type="hidden" name="Activation[RocId]" id="RocId" value="<?php if ( isset ($this->FieldValues)) echo $this->FieldValues['RocId'];?>"/>
            <p class="help-block">
                <strong>Заметка:</strong> Просто начните набирать фамилию и имя или rocID пользователя. Здесь автоматически будут отображаться результаты поиска.
            </p>
        </div>
    </div>
    <div class="span12 indent-bottom1">
        <div class="control-group">
            <label>Промо-код</label>
            <input type="text" name="Activation[Coupon]" value="<?php if ( isset ($this->FieldValues)) echo $this->FieldValues['Coupon'];?>" />
        </div>
    </div>
    <div class="span12">
        <input type="submit" value="Активировать" class="btn btn-primary" name="" />
    </div>
    </form>
</div>

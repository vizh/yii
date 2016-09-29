<?php
/**
 * @var \partner\components\Controller $this
 */


$this->setPageTitle(\Yii::t('app', 'Создание счета'));
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-user"></i> <?=\Yii::t('app', 'Выбор плательщика для формирования счета')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="form-group">
            <?$this->widget('zii.widgets.jui.CJuiAutoComplete', [
                'name' => 'payer',
                'source' => '/ajax/users',
                'options'=> [
                    'minLength' => '2',
                    'select' => 'js:function (event, ui) {
                        window.location.href = "/order/edit/?payer=" + ui.item.value;
                    }'
                ],
                'htmlOptions' => [
                    'class' => 'form-control'
                ],
                'scriptFile' => false,
                'cssFile' => false
            ])?>
            <span class="help-block"><?=\Yii::t('app','Введите ФИО, RUNET-ID или Email участника, и выберите его из выпадающего списка для продолжения.')?></span>
        </div>
    </div>
</div>
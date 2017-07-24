<?php
use partner\components\Controller;
use application\widgets\ActiveForm;

/**
 * @var Controller $this
 */
?>
<?$this->setPageTitle('Коды счетчиков')?>
<?$activeForm = $this->beginWidget(ActiveForm::className())?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-pencil"></i> <?=\Yii::t('app', 'Коды счетчиков')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=$activeForm->errorSummary($form)?>
        <p>
            Счетчики бывают двух вариантов: видимые и невидимые.
            Как правило для сайта не имеет большого смысла размещать много счетчиков — достаточно одного-двух.
            На страницах сервиса RUNET–ID могут быть размещены только невидимые счетчики.
        </p>
        <p>
            Скопируйте HTML-код счетчика (или счетчиков) в поле ниже и они автоматически будут добавлены на все страницы, связанные с вашим мероприятием.
        </p>
        <div class="form-group">
            <?= $activeForm->textArea($form, 'Head', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('Head')]); ?>
        </div>
        <div class="form-group">
            <?= $activeForm->textArea($form, 'Body', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('Body')]); ?>
        </div>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary'])?>
    </div>
</div>
<?$this->endWidget()?>

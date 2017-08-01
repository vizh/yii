<?php

/**
 * @var Controller $this
 * @var ActiveForm $activeForm
 */

use application\helpers\Flash;
use partner\components\Controller;
use application\widgets\ActiveForm;

$this->setPageTitle('Коды счетчиков');

$event = $this->getEvent();

?>


<?=CHtml::beginForm('', 'POST', array('class' => 'form-horizontal'))?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-pencil"></i> <?=Yii::t('app', 'Коды счетчиков')?></span>
    </div>
    <div class="panel-body">
        <?=Flash::html()?>
        <?=CHtml::errorSummary($event)?>
        <p>Счетчики бывают двух вариантов: видимые и невидимые. Как правило для сайта не имеет большого смысла размещать много счетчиков — достаточно одного-двух. На страницах сервиса RUNET–ID могут быть размещены только невидимые счетчики.</p>
        <p>Скопируйте HTML-код счетчика (или счетчиков) в поле ниже и они автоматически будут добавлены на все страницы, связанные с вашим мероприятием.</p>
        <div class="form-group">
            <?=CHtml::textArea('CounterHeadHTML', $event->CounterHeadHTML, [
                'class' => 'form-control',
                'placeholder' => $event->getAttributeLabel('CounterHeadHTML'),
                'rows' => 10
            ])?>
        </div>
        <div class="form-group">
            <?=CHtml::textArea('CounterBodyHTML', $event->CounterBodyHTML, [
                'class' => 'form-control',
                'placeholder' => $event->getAttributeLabel('CounterBodyHTML'),
                'rows' => 10
            ])?>
        </div>
    </div>
    <div class="panel-footer">
        <?=CHtml::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary'])?>
    </div>
</div>
<?=CHtml::endForm()?>

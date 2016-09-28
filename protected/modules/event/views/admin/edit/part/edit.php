<?php
/**
 * @var $form \event\models\forms\admin\Part
 */
?>

<?=\CHtml::form('','POST', ['class' => 'form-horizontal'])?>
<div class="btn-toolbar">
    <a class="btn" href="<?=Yii::app()->createUrl('/event/admin/edit/parts', ['eventId' => $form->Part->EventId])?>"><span class="icon-arrow-left"></span> Назад</a>
    <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
</div>

<div class="well">
    <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>

    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Title', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHtml::activeTextField($form, 'Title', ['class' => 'input-xxlarge'])?>
        </div>
    </div>

    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Order', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHtml::activeTextField($form, 'Order', ['class' => 'input-xlarge'])?>
        </div>
    </div>
</div>
<?=\CHtml::endForm()?>



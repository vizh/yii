<?php

/**
 * @var \application\components\controllers\AdminMainController $this
 * @var \raec\models\forms\Edit $form
 * @var \raec\models\Commission $commission
 */

$this->getClientScripts()->registerPackage('runetid.ckeditor');
$this->setPageTitle($commission->Id === null
    ? Yii::t('app', 'Новая комиссия РАЭК')
    : $commission->Title
);

?>
<?=CHtml::form('', 'POST', ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'])?>
    <div class="btn-toolbar">
        <?=CHtml::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
    </div>
    <div class="well">
        <div class="row-fluid">
            <?if(Yii::app()->getUser()->hasFlash('success')):?>
                <div class="alert alert-success"><?=Yii::app()->getUser()->getFlash('success')?></div>
            <?endif?>
            <?=CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>

            <div class="span8">
                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'Title', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?=CHtml::activeTextField($form, 'Title', ['class' => 'input-block-level'])?>
                    </div>
                </div>

                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'Description', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?=CHtml::activeTextArea($form, 'Description', ['class' => 'input-block-level'])?>
                    </div>
                </div>

                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'Url', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?=CHtml::activeTextField($form, 'Url', ['class' => 'input-block-level'])?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?=CHtml::endForm()?>
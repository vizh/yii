<?/**
 * @var \partner\components\Controller $this
 * @var CActiveForm $activeForm
 * @var \partner\models\forms\program\Section $form
 */

use application\helpers\Flash;

$this->setPageTitle(\Yii::t('app', 'Редактирование секции'));
\Yii::app()->getClientScript()->registerPackage('runetid.ckeditor');
?>
<?php $activeForm = $this->beginWidget('CActiveForm');?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><span class="fa fa-pencil"></span> <?=\Yii::t('app', 'Редактирование секции');?></span>
        <?php if ($form->isUpdateMode()):?>
            <div class="panel-heading-controls">
                <?=\CHtml::link(\Yii::t('app', 'Участники'), ['participants', 'id' => $form->getActiveRecord()->Id], ['class' => 'btn btn-outline btn-success btn-xs']);?>
            </div>
        <?php endif;?>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?php if ($form->isUpdateMode()):?>
            <ul class="nav nav-tabs nav-tabs-simple m-bottom_20">
                <?php foreach (\Yii::app()->params['Languages'] as $lang):?>
                    <li <?php if ($lang === $form->getLocale()):?>class="active"<?php endif;?>>
                        <?=\CHtml::link($lang, ['section', 'id' => $form->getActiveRecord()->Id, 'locale' => $lang]);?>
                    </li>
                <?php endforeach;?>
            </ul>
        <?php endif;?>
        <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>');?>
        <?=Flash::html();?>
        <div class="form-group">
            <?=$activeForm->label($form, 'Title');?>
            <?=$activeForm->textField($form, 'Title', ['class' => 'form-control']);?>
        </div>
        <div class="form-group">
            <?=$activeForm->label($form, 'ShortTitle');?>
            <?=$activeForm->textField($form, 'ShortTitle', ['class' => 'form-control']);?>
        </div>
        <div class="form-group">
            <?=$activeForm->label($form, 'Info');?>
            <?=$activeForm->textArea($form, 'Info', ['class' => 'form-control']);?>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <?=$activeForm->label($form, 'Date');?>
                    <?=$activeForm->dropDownList($form, 'Date', $form->getDateData(), ['class' => 'form-control']);?>
                </div>
                <div class="col-sm-4">
                    <?=$activeForm->label($form, 'TimeStart');?>
                    <?=$activeForm->textField($form, 'TimeStart', ['class' => 'form-control', 'placeholder' => \Yii::t('app','С')]);?>
                </div>
                <div class="col-sm-4">
                    <?=$activeForm->label($form, 'TimeEnd');?>
                    <?=$activeForm->textField($form, 'TimeEnd', ['class' => 'form-control', 'placeholder' => \Yii::t('app','До')]);?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?=$activeForm->label($form, 'Hall');?>
            <?=$activeForm->dropDownList($form, 'Hall', \CHtml::listData($form->getEvent()->Halls, 'Id', 'Title'), ['class' => 'form-control', 'multiple' => true]);?>
            <?=$activeForm->textField($form, 'HallNew', ['class' => 'form-control m-top_10', 'placeholder' => \Yii::t('app', 'Название для нового зала')]);?>
        </div>

        <div class="panel panel-info panel-dark">
            <div class="panel-heading">
                <span class="panel-title"><?=\Yii::t('app', 'Атрибуты секции');?></span>
            </div>
            <div class="panel-body">
                <?php foreach($form->getAttributeList() as $name):?>
                    <div class="form-group">
                        <label><?=$name;?></label>
                        <?=$activeForm->textField($form, 'Attribute[' . $name . ']', ['class' => 'form-control']);?>
                    </div>
                <?php endforeach;?>
                <?=$activeForm->label($form, 'AttributeNew');?>
                <div class="row">
                    <div class="col-sm-6">
                        <?=$activeForm->textField($form, 'AttributeNew[Name]', ['class' => 'form-control', 'placeholder' => \Yii::t('app', 'Название')]);?>
                    </div>
                    <div class="col-sm-6">
                        <?=$activeForm->textField($form, 'AttributeNew[Value]', ['class' => 'form-control', 'placeholder' => \Yii::t('app', 'Значение')]);?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?=$activeForm->label($form, 'TypeId');?>
            <?=$activeForm->dropDownList($form, 'TypeId', $form->getTypeData(), ['class' => 'form-control']);?>
        </div>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']);?>
        <?php if ($form->isUpdateMode()):?>
            <?=\CHtml::link(\Yii::t('app', 'Удалить'), ['deletesection', 'id' => $form->getActiveRecord()->Id], ['class' => 'btn btn-danger pull-right']);?>
        <?php endif;?>
    </div>
</div>
<?php $this->endWidget();?>


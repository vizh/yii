<?php
/**
 * @var \event\models\section\Section $section
 * @var \partner\models\forms\program\Participant $form
 * @var \partner\components\Controller $this
 */

use \partner\models\forms\program\Participant;
use application\helpers\Flash;
use event\models\section\Role;

$this->setPageTitle(\Yii::t('app','Редактирование участников секции'));
?>

<?=Flash::html();?>

<?=\CHtml::form('', 'POST');?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><span class="fa fa-plus"></span> <?=\Yii::t('app', 'Новый участник');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=\CHtml::errorSummary($form, '<div class="alert alert-danger">', '</div>');?>
        <?$this->renderPartial('participants/select', ['form' => $form]);?>
        <div class="form-group">
            <?=\CHtml::activeLabel($form, 'Role');?>
            <?=\CHtml::activeDropDownList($form, 'RoleId', \CHtml::listData(Role::model()->findAll(), 'Id', 'Title'), ['class' => 'form-control']);?>
        </div>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Добавить'), ['class' => 'btn btn-primary']);?>
    </div>
</div>
<?=\CHtml::endForm();?>


<?php if (!empty($section->LinkUsers)):?>
    <?php foreach ($section->LinkUsers as $link):?>
        <?=\CHtml::form('', 'POST');?>
        <div class="panel panel-warning">
            <div class="panel-heading">
                <span class="panel-title"><span class="fa fa-group"></span> <?=\Yii::t('app', 'Участник секции');?></span>
            </div> <!-- / .panel-heading -->
            <div class="panel-body">
                <?php $form = new Participant($link);?>
                <?$this->renderPartial('participants/select', ['form' => $form]);?>

                <div class="form-group">
                    <?=\CHtml::activeLabel($form, 'Role');?>
                    <?=\CHtml::activeDropDownList($form, 'RoleId', \CHtml::listData(Role::model()->findAll(), 'Id', 'Title'), ['class' => 'form-control']);?>
                </div>

                <div class="form-group">
                    <?=\CHtml::activeLabel($form, 'ReportTitle');?>
                    <?=\CHtml::activeTextField($form, 'ReportTitle', ['class' => 'form-control']);?>
                </div>

                <div class="form-group">
                    <?=\CHtml::activeLabel($form, 'ReportThesis');?>
                    <?=\CHtml::activeTextArea($form, 'ReportThesis', ['class' => 'form-control']);?>
                </div>

                <div class="form-group">
                    <?=\CHtml::activeLabel($form, 'ReportUrl');?>
                    <?=\CHtml::activeTextField($form, 'ReportUrl', ['class' => 'form-control']);?>
                </div>

                <div class="form-group">
                    <?=\CHtml::activeLabel($form, 'VideoUrl');?>
                    <?=\CHtml::activeTextField($form, 'VideoUrl', ['class' => 'form-control']);?>
                </div>

                <div class="form-group">
                    <?=\CHtml::activeLabel($form, 'ReportFullInfo');?>
                    <?=\CHtml::activeTextArea($form, 'ReportFullInfo', ['class' => 'form-control']);?>
                </div>
                <div class="form-group">
                    <?if ($link->Report !== null && !empty($link->Report->Url)):?>
                        <a href="<?=$link->Report->Url;?>" class="m-bottom_5"><?=\Yii::t('app', 'Скачать презентацию');?></a>
                    <?endif;?>
                </div>
                <div class="checkbox">
                    <label>
                        <?=\CHtml::activeCheckBox($form, 'Delete', ['uncheckValue' => null]);?> <?=$form->getAttributeLabel('Delete');?>
                    </label>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?=\CHtml::activeLabel($form, 'Order');?>
                        <?=CHtml::activeTextField($form, 'Order', ['class' => 'form-control']);?>
                    </div>
                </div>
                <?=\CHtml::activeHiddenField($form, 'Id');?>
            </div>
            <div class="panel-footer">
                <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить изменения'), ['class' => 'btn btn-primary']);?>
            </div>
        </div>
        <?=\CHtml::endForm();?>
    <?php endforeach;?>
<?php endif;?>

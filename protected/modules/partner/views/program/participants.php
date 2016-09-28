<?php
/**
 * @var \event\models\section\Section $section
 * @var Participant[] $forms
 * @var \partner\components\Controller $this
 * @var CActiveForm $activeForm
 */

use application\helpers\Flash;
use \partner\models\forms\program\Participant;

$this->setPageTitle(\Yii::t('app','Редактирование участников секции'));
\Yii::app()->getClientScript()->registerPackage('runetid.ckeditor');
?>

<?=Flash::html()?>

<?php
$form = array_shift($forms);
$activeForm = $this->beginWidget('CActiveForm', ['id' => $form->getId()])?>
    <div class="panel panel-info panel-dark">
        <div class="panel-heading">
            <span class="panel-title"><span class="fa fa-group"></span> <?=\Yii::t('app', 'Новый участник секции')?></span>
        </div> <!-- / .panel-heading -->
        <div class="panel-body">
            <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
            <?$this->renderPartial('participants/select', ['form' => $form, 'activeForm' => $activeForm])?>
            <div class="form-group m-top_20">
                <?=$activeForm->label($form, 'RoleId')?>
                <?=$activeForm->dropDownList($form, 'RoleId', $form->getRoleData(), ['class' => 'form-control'])?>
            </div>
        </div>
        <div class="panel-footer">
            <?=\CHtml::submitButton(\Yii::t('app', 'Добавить'), ['class' => 'btn btn-primary'])?>
        </div>
    </div>
<?$this->endWidget()?>


<?foreach($forms as $form):?>
    <?$activeForm = $this->beginWidget('CActiveForm', ['id' => $form->getId()])?>
        <?if($form->hasErrors()):?>
            <script type="text/javascript">
                $(function () {
                    window.location.hash = "#<?=$form->getId()?>";
                });
            </script>
        <?endif?>
        <?=\CHtml::hiddenField('ParticipantId', $form->getActiveRecord()->Id)?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <span class="panel-title"><span class="fa fa-group"></span> <?=\Yii::t('app', 'Участник секции')?></span>
            </div> <!-- / .panel-heading -->
            <div class="panel-body">
                <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
                <?$this->renderPartial('participants/select', ['form' => $form, 'activeForm' => $activeForm])?>
                <div class="form-group m-top_20">
                    <?=$activeForm->label($form, 'RoleId')?>
                    <?=$activeForm->dropDownList($form, 'RoleId', $form->getRoleData(), ['class' => 'form-control'])?>
                </div>
                <div id="accordion-example" class="panel-group panel-group-info m-top_20">
                    <div class="panel">
                        <div class="panel-heading">
                            <a href="#<?=$form->getId()?>_report" data-toggle="collapse" class="accordion-toggle <?if(!$form->hasErrors()):?>collapsed<?endif?>"><?=\Yii::t('app', 'Информация о докладе')?></a>
                        </div>
                        <div class="panel-collapse <?if(!$form->hasErrors()):?>collapse<?php else:?>collapse in<?endif?>" id="<?=$form->getId()?>_report">
                            <div class="panel-body">
                                <div class="form-group">
                                    <?=$activeForm->label($form, 'ReportTitle')?>
                                    <?=$activeForm->textField($form, 'ReportTitle', ['class' => 'form-control'])?>
                                </div>
                                <div class="form-group">
                                    <?=$activeForm->label($form, 'ReportThesis')?>
                                    <?=$activeForm->textArea($form, 'ReportThesis', ['class' => 'form-control'])?>
                                </div>
                                <div class="form-group">
                                    <?=$activeForm->label($form, 'ReportUrl')?>
                                    <?=$activeForm->textField($form, 'ReportUrl', ['class' => 'form-control'])?>
                                </div>
                                <div class="form-group">
                                    <?=$activeForm->label($form, 'VideoUrl')?>
                                    <?=$activeForm->textField($form, 'VideoUrl', ['class' => 'form-control'])?>
                                </div>
                                <div class="form-group">
                                    <?=$activeForm->label($form, 'ReportFullInfo')?>
                                    <?=$activeForm->textArea($form, 'ReportFullInfo', ['class' => 'form-control'])?>
                                </div>
                                <?if(!empty($form->getActiveRecord()->Report) && !empty($form->getActiveRecord()->Report->Url)):?>
                                    <div class="form-group">
                                        <a href="<?=$form->getActiveRecord()->Report->Url?>" class="btn btn-xs"><?=\Yii::t('app', 'Скачать презентацию')?></a>
                                    </div>
                                <?endif?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <?=$activeForm->label($form, 'Order')?>
                        <?=$activeForm->textField($form, 'Order', ['class' => 'form-control'])?>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить изменения'), ['class' => 'btn btn-primary'])?>
                <button type="submit" class="btn btn-danger pull-right" name="<?=\CHtml::activeName($form, 'Delete')?>" value="1"><?=\Yii::t('app', 'Удалить')?></button>
            </div>
        </div>
    <?$this->endWidget()?>
<?endforeach?>

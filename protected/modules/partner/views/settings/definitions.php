<?php
/**
 * @var partner\components\Controller $this
 * @var event\models\forms\UserAttributeGroup[] $forms
 * @var application\widgets\ActiveForm $activeForm
 * @var Event $event
 */

use application\helpers\Flash;
use event\models\Event;

$this->setPageTitle(\Yii::t('app', 'Дополнительные атрибуты пользователей'));
?>
<?=Flash::html()?>
<?php foreach ($forms as $form):?>
    <?php $activeForm = $this->beginWidget('\application\widgets\ActiveForm', ['scrollIfHasErrors' => $form]);?>
        <?php if ($form->getActiveRecord() !== null):?>
            <?=\CHtml::hiddenField('Id', $form->getActiveRecord()->Id);?>
        <?php endif;?>
        <div class="panel <?php if ($form->isUpdateMode()):?>panel-info<?php else:?>panel-warning<?php endif;?>">
            <div class="panel-heading">
                <span class="panel-title"><i class="fa fa-object-group"></i> <?=\Yii::t('app', $form->isUpdateMode() ? 'Группа атрибутов' : 'Новая группа атрибутов');?></span>
            </div> <!-- / .panel-heading -->
            <div class="panel-body">
                <?=$activeForm->errorSummary($form);?>
                <div class="row">
                    <div class="col-sm-10">
                        <?=$activeForm->label($form, 'Title');?>
                        <?=$activeForm->textField($form, 'Title', ['class' => 'form-control']);?>
                    </div>
                    <div class="col-sm-2">
                        <?=$activeForm->label($form, 'Order');?>
                        <?=$activeForm->dropDownList($form, 'Order', [0,1,2,3,4,5,6,7,8,9,10], ['class' => 'form-control']);?>
                    </div>
                </div>
                <?php if ($form->isUpdateMode()):?>
                <div class="panel-group panel-group-info m-top_20">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="accordion-toggle"><i class="fa fa-list-alt"></i> <?=\Yii::t('app', 'Атрибуты');?></span>
                        </div>
                        <div class="panel-body">
                            <?php foreach ($form->Definitions as $i => $definition):?>
                                <div class="definition">
                                    <?=$activeForm->hiddenField($form, "Definitions[$i][Delete]", ['disabled' => !$definition->isFullyEditable()]);?>
                                    <?php if ($definition->getActiveRecord() === null): ?>
                                        <p><strong><?=Yii::t('app', 'Новый атрибут')?></strong></p>
                                    <?php endif;?>
                                    <?=$activeForm->errorSummary($definition);?>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <?=$activeForm->label($definition, 'ClassName')?>
                                            <?=$activeForm->dropDownList($form, "Definitions[$i][ClassName]", $definition->getClassNameData(), ['class' => 'form-control', 'disabled' => !$definition->isFullyEditable()])?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?=$activeForm->label($definition, 'Name')?>
                                            <?=$activeForm->textField($form, "Definitions[$i][Name]", ['class' => 'form-control', 'disabled' => !$definition->isFullyEditable()])?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?=$activeForm->label($definition, 'Title')?>
                                            <?=$activeForm->textField($form, "Definitions[$i][Title]", ['class' => 'form-control'])?>
                                        </div>
                                        <div class="col-sm-2">
                                            <?=$activeForm->label($definition, 'Order')?>
                                            <?=$activeForm->dropDownList($form, "Definitions[$i][Order]", [0,1,2,3,4,5,6,7,8,9,10], ['class' => 'form-control'])?>
                                        </div>
                                    </div>
                                    <?php if ($definition->isFullyEditable()): ?>
                                        <?=$definition->getParamsHtml($activeForm, $form, "Definitions[$i]")?>
                                    <?php endif ?>
                                    <div class="row m-top_10">
                                        <div class="col-sm-8">
                                            <div class="checkbox">
                                                <label>
                                                    <?=$activeForm->checkBox($form, "Definitions[$i][Required]")?> <?=$definition->getAttributeLabel('Required')?>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <?=$activeForm->checkBox($form, "Definitions[$i][UseCustomTextField]")?> <?=$definition->getAttributeLabel('UseCustomTextField')?>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <?=$activeForm->checkBox($form, "Definitions[$i][Public]")?> <?=$definition->getAttributeLabel('Public')?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 text-right-sm <?php if (!$definition->isFullyEditable()):?>hide<?php endif;?>">
                                            <?=\CHtml::link(\Yii::t('app', 'Удалить'), '#', ['class' => 'btn btn-danger btn-delete']);?>
                                        </div>
                                    </div>
                                    <?php if ($definition->getActiveRecord() !== null):?>
                                        <hr/>
                                    <?php endif;?>
                                </div>

                                <?if($definition->Name):?>
                                    <div class="text-right">
                                        <?if($definition->Name === 'ean17' && in_array($event->Id, [2514, 2534])):?>
                                            <?=CHtml::tag('button', [
                                                'type' => 'submit',
                                                'name' => 'GroupData',
                                                'value' => 'true',
                                                'class' => 'btn btn-danger'
                                            ], \Yii::t('app', 'Распределить по группам и пронумеровать'))?>
                                        <?endif?>

                                        <?=CHtml::tag('button', [
                                            'type' => 'submit',
                                            'name' => 'EraseData',
                                            'value' => $definition->Name,
                                            'class' => 'btn btn-warning'
                                        ], \Yii::t('app', 'Очистить данные'))?>
                                    </div>
                                <?endif?>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <?php endif;?>
            </div>
            <div class="panel-footer">
                <?=CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary'])?>
            </div>
        </div>
    <?php $this->endWidget();?>
<?php endforeach ?>

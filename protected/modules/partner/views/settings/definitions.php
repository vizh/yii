<?php
/**
 * @var partner\components\Controller $this
 * @var event\models\forms\UserAttributeGroup[] $forms
 * @var application\widgets\ActiveForm $activeForm
 * @var Event $event
 */

use application\components\AbstractDefinition;
use application\helpers\Flash;
use event\models\Event;

$this->setPageTitle(Yii::t('app', 'Дополнительные атрибуты пользователей'));
?>
<?=Flash::html()?>
<?foreach($forms as $form):?>
    <?$activeForm = $this->beginWidget('\application\widgets\ActiveForm', ['scrollIfHasErrors' => $form])?>
        <?if($form->getActiveRecord() !== null):?>
            <?=CHtml::hiddenField('Id', $form->getActiveRecord()->Id)?>
        <?endif?>
        <div class="panel <?if($form->isUpdateMode()):?>panel-info<?else:?>panel-warning<?endif?>">
            <div class="panel-heading">
                <span class="panel-title"><i class="fa fa-object-group"></i> <?=Yii::t('app', $form->isUpdateMode() ? 'Группа атрибутов' : 'Новая группа атрибутов')?></span>
            </div> <!-- / .panel-heading -->
            <div class="panel-body">
                <?=$activeForm->errorSummary($form)?>
                <div class="row">
                    <div class="col-sm-10">
                        <?=$activeForm->label($form, 'Title')?>
                        <?=$activeForm->textField($form, 'Title', ['class' => 'form-control'])?>
                    </div>
                    <div class="col-sm-2">
                        <?=$activeForm->label($form, 'Order')?>
                        <?=$activeForm->dropDownList($form, 'Order', [0,1,2,3,4,5,6,7,8,9,10], ['class' => 'form-control'])?>
                    </div>
                </div>
                <?if($form->isUpdateMode()):?>
                <div class="panel-group panel-group-info m-top_20">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="accordion-toggle"><i class="fa fa-list-alt"></i> <?=Yii::t('app', 'Атрибуты')?></span>
                        </div>
                        <div class="panel-body">
                            <?foreach($form->Definitions as $i => $definition):?>
                                <?php
                                    if ($definition->ClassName) {
                                        $rawDefinition = "application\\components\\attribute\\$definition->ClassName";
                                        /** @var AbstractDefinition $rawDefinition */
                                        $rawDefinition = new $rawDefinition();
                                    }
                                ?>
                                <div class="definition" style="margin-bottom:2em">
                                    <?=$activeForm->hiddenField($form, "Definitions[$i][Delete]", ['disabled' => !$definition->isFullyEditable()])?>
                                    <?if($definition->getActiveRecord() === null):?>
                                        <?if($i !== 0):?>
                                            <br><br>
                                        <?endif?>
                                        <h2><?=Yii::t('app', 'Новый атрибут')?></h2>
                                    <?endif?>
                                    <?=$activeForm->errorSummary($definition)?>
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
                                    <?if($definition->isFullyEditable()):?>
                                        <?=$definition->getParamsHtml($activeForm, $form, "Definitions[$i]")?>
                                    <?endif?>
                                    <br>
                                    <div class="row m-top_10">
                                        <div class="col-sm-1">&nbsp;</div>
                                        <div class="col-sm-7" style="border-left:1px solid silver;padding-top:8px">
                                            <div class="checkbox">
                                                <label>
                                                    <?=$activeForm->checkBox($form, "Definitions[$i][Required]")?>
                                                    <?=$definition->getAttributeLabel('Required')?>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <?=$activeForm->checkBox($form, "Definitions[$i][UseCustomTextField]")?>
                                                    <?=$definition->getAttributeLabel('UseCustomTextField')?>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <?=$activeForm->checkBox($form, "Definitions[$i][Public]")?>
                                                    <?=$definition->getAttributeLabel('Public')?>
                                                </label>
                                            </div>
                                            <?if($rawDefinition && $rawDefinition::isTranslatableAllowed()):?>
                                                <div class="checkbox">
                                                    <label>
                                                        <?=$activeForm->checkBox($form, "Definitions[$i][Translatable]")?>
                                                        <?=$definition->getAttributeLabel('Translatable')?>
                                                    </label>
                                                </div>
                                            <?endif?>
                                        </div>
                                        <div class="col-sm-4 text-right-sm">
                                            <?if($definition->isFullyEditable()):?>
                                                <?=CHtml::link(Yii::t('app', 'Удалить'), '#', ['class' => 'btn btn-danger btn-delete'])?>
                                            <?endif?>
                                            <?if($definition->Name):?>
                                                <div class="text-right">
                                                    <?if($definition->Name === 'ean17' && in_array($event->Id, [2514, 2534])):?>
                                                        <?=CHtml::tag('button', [
                                                            'type' => 'submit',
                                                            'name' => 'GroupData',
                                                            'value' => 'true',
                                                            'class' => 'btn btn-danger'
                                                        ], Yii::t('app', 'Распределить по группам и пронумеровать'))?>
                                                    <?endif?>

                                                    <?=CHtml::tag('button', [
                                                        'type' => 'submit',
                                                        'name' => 'EraseData',
                                                        'value' => $definition->Name,
                                                        'class' => 'btn btn-warning'
                                                    ], Yii::t('app', 'Очистить данные'))?>
                                                </div>
                                            <?endif?>
                                        </div>
                                    </div>
                                </div>
                            <?endforeach?>
                        </div>
                    </div>
                </div>
                <?endif?>
            </div>
            <div class="panel-footer">
                <?=CHtml::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary'])?>
            </div>
        </div>
    <?$this->endWidget()?>
<?endforeach?>

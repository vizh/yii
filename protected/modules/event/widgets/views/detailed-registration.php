<?php
/**
 * @var event\widgets\DetailedRegistration $this
 * @var event\models\UserData $userData
 */

use application\components\attribute\BooleanDefinition;
use application\models\attribute\Group;

?>
<div class="registration" id="<?=$this->getNameId();?>">
    <?=isset($this->WidgetRegistrationTitle)? $this->WidgetRegistrationTitle : CHtml::tag('h5', ['class' => 'title text-center'], Yii::t('app', 'Регистрация'))?>
    <?php if (isset($this->WidgetRegistrationBeforeInfo)): ?>
        <?=$this->WidgetRegistrationBeforeInfo;?>
    <?php endif ?>
    <?=CHtml::beginForm('', 'post', ['enctype' => 'multipart/form-data']);?>
    <?=CHtml::errorSummary($this->form, '<div class="alert alert-error">', '</div>');?>

    <?php if (!$this->form->hasErrors('Invite')): ?>
        <?php foreach ($this->form->getUsedAttributes() as $attribute): ?>
            <div class="row-fluid">
                <div class="control-group" id="control-group_<?=$attribute?>">
                    <?php if ($attribute === 'Document'): ?>
                        <h5 class="title"><?=$this->form->getAttributeLabel('Document')?></h5>
                    <?php else: ?>
                        <?=CHtml::activeLabel($this->form, $attribute, ['class' => 'control-label'])?>
                    <?php endif ?>

                    <div class="controls">
                        <?php if ($attribute == 'Birthday'):?>
                            <?=CHtml::activeTextField($this->form, $attribute, [
                                'disabled' => $this->form->isDisabled($attribute),
                                'class' => 'span12',
                                'placeholder' => \Yii::t('app', 'Например: 01.01.1980')
                            ])?>
                        <?php elseif ($attribute == 'Document'):?>
                            <?=$this->form->Document->renderEditView($this->getController(), true);?>
                        <?php elseif ($attribute == 'ContactAddress'):?>
                            <?php $this->widget('contact\widgets\AddressControls', [
                                'form' => $this->form->ContactAddress,
                                'address' => false,
                                'place' => false,
                                'inputClass' => 'span12',
                                'inputPlaceholder' => false,
                                'disabled' => $this->form->isDisabled($attribute)
                            ]) ?>
                        <?php elseif ($attribute == 'Photo'):?>
                            <?php if ($this->form->isUpdateMode()): ?>
                                <?=CHtml::image($this->form->getActiveRecord()->getPhoto()->get50px(),'',['class'=>'img-polaroid']);?>
                            <?php else: ?>
                                <?=CHtml::activeFileField($this->form, $attribute);?>
                                <p class="help-block m-top_5">
                                    <?=Yii::t('app', 'Фотографии должны быть предоставлены в цветном исполнении, с четким изображением лица, строго в анфас, без головного убора. Размер изображения овала лица на фотографии должен занимать не менее 80 процентов от размера фотографии. Задний фон светлее изображения лица, ровный, без полос, пятен и посторонних предметов.')?>
                                </p>
                            <?php endif ?>
                        <?php else: ?>
                            <?=CHtml::activeTextField($this->form, $attribute, [
                                'disabled' => $this->form->isDisabled($attribute),
                                'class' => 'span12'
                            ])?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
        <hr/>


        <?php if ($this->form->getUserData() !== null): ?>
            <?php $group = null ?>
            <?php foreach($this->form->getUserData()->getManager()->getDefinitions() as $definition):?>
                <?php
                    if ((!isset($this->WidgetRegistrationShowHiddenUserDataFields) || $this->WidgetRegistrationShowHiddenUserDataFields == 0) && !$definition->public) {
                        continue;
                    }
                ?>

                <?php if ($group == null || $group->Id !== $definition->groupId): ?>
                    <?php $group = Group::model()->findByPk($definition->groupId) ?>
                    <?php if ($group !== null): ?>
                        <hr>
                    <?php endif ?>
                    <?php if (isset($this->WidgetRegistrationShowUserDataGroupLabel) && $this->WidgetRegistrationShowUserDataGroupLabel == 1): ?>
                        <p><strong><?=CHtml::encode($group->Title)?></strong></p>
                    <?php endif ?>
                <?php endif ?>

                <div class="row-fluid">
                    <div class="control-group" id="control-group_<?=$definition->name?>">
                        <?php if (!($definition instanceof BooleanDefinition)): ?>
                            <label class="control-label">
                                <?=CHtml::encode($definition->title)?>
                                <?php if ($definition->required): ?>
                                    <span class="required-asterisk">*</span>
                                <?php endif ?>
                            </label>
                        <?php endif ?>
                        <div class="controls">
                            <?=$definition->activeEdit($this->form->getUserData()->getManager(), [
                                'class' => ($definition instanceof BooleanDefinition) ? '' : 'span12'
                            ])?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <hr>
        <?php endif ?>

        <?php if ($this->form->getRoleData() !== []): ?>
            <div class="form-inline row-fluid m-bottom_5">
                <div class="span12">
                    <?=CHtml::activeLabel($this->form, 'RoleId', ['class' => 'control-label']);?>
                    <?=CHtml::activeDropDownList($this->form, 'RoleId', $this->form->getRoleData(), ['class' => 'span12']);?>
                </div>
            </div>
        <?php endif ?>

        <div class="form-user-register" style="padding: 0;">
            <small class="muted required-notice">
                <span class="required-asterisk">*</span> &mdash; <?=Yii::t('registration', 'все поля обязательны для заполнения');?><br/>
                <span class="required-asterisk">**</span> &mdash; <?=Yii::t('registration', 'заполняя анкету, я принимаю условия соглашения  на хранение и обработку персональных данных');?>
            </small>
        </div>

        <div class="form-inline m-top_20 text-center">
            <?=CHtml::submitButton(
                Yii::t('app', (isset($this->WidgetRegistrationDetailedSubmitButtonLabel) ? $this->WidgetRegistrationDetailedSubmitButtonLabel : 'Зарегистрироваться')), ['class' => 'btn btn-info']
            )?>
        </div>
    <?php endif ?>

    <?=CHtml::endForm()?>
</div>
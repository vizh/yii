<?php
/**
 * @var \event\widgets\DetailedRegistration $this
 * @var \event\models\UserData $userData
 */
use \application\components\attribute\BooleanDefinition;
use \application\models\attribute\Group;
?>
<div class="registration" id="event_widgets_Registration">
    <?if (isset($this->WidgetRegistrationBeforeInfo)):?>
        <?=$this->WidgetRegistrationBeforeInfo;?>
    <?endif;?>
    <h5 class="title text-center">
        <?=isset($this->WidgetRegistrationTitle)? $this->WidgetRegistrationTitle : Yii::t('app', 'Регистрация');?>
    </h5>
    <?=\CHtml::beginForm('', 'post', ['enctype' => 'multipart/form-data']);?>
    <?=\CHtml::errorSummary($this->form, '<div class="alert alert-error">', '</div>');?>

    <?php if (!$this->form->hasErrors('Invite')):?>
        <?php foreach ($this->form->getUsedAttributes() as $attribute):?>
            <div class="row-fluid">
                <div class="control-group">
                    <?=\CHtml::activeLabel($this->form, $attribute, ['class' => 'control-label']);?>
                    <div class="controls">
                        <?php if ($attribute == 'Birthday'):?>
                            <?=\CHtml::activeTextField($this->form, $attribute, ['disabled' => $this->form->isDisabled($attribute),'class' => 'span12', 'placeholder' => \Yii::t('app', 'Например: 01.01.1980')]);?>
                        <?php elseif ($attribute == 'ContactAddress'):?>
                            <?$this->widget('\contact\widgets\AddressControls', ['form' => $this->form->ContactAddress, 'address' => false, 'place' => false, 'inputClass' => 'span12', 'inputPlaceholder' => false, 'disabled' => $this->form->isDisabled($attribute)]);?>
                        <?php elseif ($attribute == 'Photo'):?>
                            <?if ($this->form->isUpdateMode()):?>
                                <?=CHtml::image($this->form->getActiveRecord()->getPhoto()->get50px(),'',['class'=>'img-polaroid']);?>
                            <?else:?>
                                <?=\CHtml::activeFileField($this->form, $attribute);?>
                            <?endif;?>
                        <?else:?>
                            <?=\CHtml::activeTextField($this->form, $attribute, ['disabled' => $this->form->isDisabled($attribute),'class' => 'span12']);?>
                        <?endif;?>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
        <hr/>


        <?php if ($this->form->getUserData() !== null):?>
            <?php $group = null;?>
            <?php foreach($this->form->getUserData()->getManager()->getDefinitions() as $definition):?>
                <?php
                    if (!$definition->public) {
                        continue;
                    }
                ?>
                <?php if (isset($this->WidgetRegistrationShowUserDataGroupLabel) && $this->WidgetRegistrationShowUserDataGroupLabel == 1):?>
                    <?php if ($group == null || $group->Id !== $definition->groupId):?>
                        <?if ($group !== null):?>
                            <hr/>
                        <?endif;?>
                        <?php $group = Group::model()->findByPk($definition->groupId);?>
                        <p><strong><?=$group->Title;?></strong></p>
                    <?php endif;?>
                <?php endif;?>
                <div class="row-fluid">
                    <div class="control-group">
                        <?php if (!($definition instanceof BooleanDefinition)):?>
                            <label class="control-label"><?=$definition->title;?></label>
                        <?php endif;?>
                        <div class="controls">
                            <?=$definition->activeEdit($this->form->getUserData()->getManager(), ['class' => ($definition instanceof BooleanDefinition) ? '' : 'span12']);?>
                        </div>
                    </div>
                </div>
            <?endforeach;?>
            <hr/>
        <?endif;?>

        <?if ($this->form->getRoleData() !== []):?>
            <div class="form-inline row-fluid m-bottom_5">
                <div class="span12">
                    <?=\CHtml::activeLabel($this->form, 'RoleId', ['class' => 'control-label']);?>
                    <?=\CHtml::activeDropDownList($this->form, 'RoleId', $this->form->getRoleData(), ['class' => 'span12']);?>
                </div>
            </div>
        <?endif;?>

        <div class="form-user-register" style="padding: 0;">
            <small class="muted required-notice">
                <span class="required-asterisk">*</span> &mdash; <?=\Yii::t('registration', 'все поля обязательны для заполнения');?>
            </small>
        </div>

        <div class="form-inline m-top_20 text-center">
            <?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрироваться'), ['class' => 'btn btn-info']);?>
        </div>
    <?endif;?>
    <?=\CHtml::endForm();?>
</div>
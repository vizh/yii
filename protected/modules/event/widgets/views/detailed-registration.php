<?php
/**
 * @var \event\widgets\DetailedRegistration $this
 * @var \event\models\UserData $userData
 */
use \application\components\attribute\BooleanDefinition;
?>
<div class="registration">
    <?if (isset($this->RegistrationBeforeInfo)):?>
        <?=$this->RegistrationBeforeInfo;?>
    <?endif;?>
    <h5 class="title"><?=Yii::t('app', 'Регистрация');?></h5>
    <?=\CHtml::beginForm('', 'post', ['enctype' => 'multipart/form-data']);?>
    <?=\CHtml::errorSummary($this->form, '<div class="alert alert-error">', '</div>');?>

    <?php if (!$this->form->hasErrors('Invite')):?>
        <?php foreach ($this->form->getUsedAttributes() as $attribute):?>
            <div class="row-fluid">
                <div class="control-group">
                    <?=\CHtml::activeLabel($this->form, $attribute, ['class' => 'control-label']);?>
                    <div class="controls">
                        <?php if ($attribute == 'Photo'):?>
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


        <?if ($this->form->getUserData() !== null):?>
            <?foreach($this->form->getUserData()->getManager()->getDefinitions() as $definition):?>
                <div class="row-fluid">
                    <div class="control-group">
                        <label class="control-label"><?=$definition->title;?></label>
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
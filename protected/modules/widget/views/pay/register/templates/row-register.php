<?php
/**
 * @var \user\models\forms\RegisterForm $registerForm
 * @var \event\models\Event $event
 */
?>



<script type="text/template" id="row-register-tpl">
    <tr>
        <td colspan="4" class="last-child">
            <?=CHtml::beginForm('', 'POST', array('class' => 'user-register'));?>
            <header><h4 class="title"><?=\Yii::t('app', 'Регистрация нового участника');?></h4></header>
            <?=CHtml::activeHiddenField($registerForm, 'EventId', ['value' => $event->Id]);?>
            <div class="alert alert-error" style="display: none;"></div>
            <div class="clearfix">
                <div class="pull-left">
                    <div class="control-group">
                        <label><?=\Yii::t('app', 'Фамилия');?></label>
                        <div class="required">
                            <?=CHtml::activeTextField($registerForm, 'LastName');?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label><?=\Yii::t('app', 'Имя');?></label>
                        <div class="required">
                            <?=CHtml::activeTextField($registerForm, 'FirstName');?>
                        </div>
                    </div>
                    <?if (Yii::app()->language != 'en'):?>
                        <div class="control-group">
                            <label><?=\Yii::t('app', 'Отчество');?></label>
                            <div class="controls">
                                <?=CHtml::activeTextField($registerForm, 'FatherName');?>
                            </div>
                        </div>
                    <?endif;?>
                    <div class="control-group">
                        <label>Email</label>
                        <div class="controls required">
                            <?=CHtml::activeTextField($registerForm, 'Email');?>
                        </div>
                    </div>
                </div>
                <div class="pull-right">
                    <div class="control-group">
                        <label><?=\Yii::t('app', 'Телефон');?></label>
                        <div class="required">
                            <?=CHtml::activeTextField($registerForm, 'Phone');?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label><?=\Yii::t('app', 'Компания');?></label>
                        <div class="required">
                            <?=CHtml::activeTextField($registerForm, 'Company');?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label><?=\Yii::t('app', 'Должность');?></label>
                        <?if (isset($event->PositionRequired) && $event->PositionRequired):?>
                            <div class="required">
                                <?=CHtml::activeTextField($registerForm, 'Position');?>
                            </div>
                        <?else:?>
                            <?=CHtml::activeTextField($registerForm, 'Position');?>
                        <?endif;?>
                    </div>
                </div>
            </div>


            <?$this->renderPartial('register/templates/row-userdata', ['event' => $event]);?>


            <small class="muted required-notice">
                <span class="required-asterisk">*</span> &mdash; <?=\Yii::t('app', 'поля обязательны для заполнения');?>
            </small>

            <div class="form-actions">
                <button class="btn btn-cancel"><?=\Yii::t('app', 'Отмена');?></button>
                <button class="btn btn-inverse btn-submit"><?=\Yii::t('app', 'Зарегистрировать');?></button>
            </div>
            <?CHtml::endForm();?>
        </td>
    </tr>
</script>
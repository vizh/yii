<?=\CHtml::form('', 'POST');?>
    <fieldset>
        <legend><?=Yii::t('app', 'Восстановление пароля');?></legend>
        <p><?=\Yii::t('app', 'Пожалуйста, укажите новый пароль для входа в RUNET-ID:');?></p>
        <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
        <div class="control-group">
            <?=\CHtml::activePasswordField($form, 'Password', array('placeholder' => $form->getAttributeLabel('Password'), 'class' => 'span4'));?>
        </div>
        <button type="submit" class="btn btn-large btn-block btn-info"><i class="icon-ok-sign icon-white"></i>&nbsp;<?=Yii::t('app', 'Установить пароль');?></button>
        <button type="submit" name="<?=\CHtml::activeName($form,'Skip');?>" class="btn btn-block" value="1"><?=Yii::t('app', 'Оставить без изменения');?></button>
    </fieldset>
<?=\CHtml::endForm();?>
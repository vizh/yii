<?php
/**
 * @var \pay\models\OrderItem[] $unpaidItems
 * @var string $email
 * @var string $error
 * @var MailruController $this
 */
?>

<section id="section" role="main">
  <div class="container m-top_40 m-bottom_50">
    <div class="row">
      <div class="offset2 span8">
        <h3><?=Yii::t('app', 'Оформление заказа');?></h3>

        <p>Введите, пожалуйста, Ваш e-mail в системе Деньги Mail.Ru для выставления счета на оплату. После успешного ввода адреса Вы будете переадресованы в систему Деньги Mail.Ru.</p>

        <?if ($error):?>
          <div class="alert alert-error">
            <?=$error;?>
          </div>
        <?endif;?>

        <?=CHtml::beginForm('', 'POST', array('class' => 'm-top_30'));?>

        <div class="control-group">
          <label for="emailmailru">Email</label>
          <div class="controls">
            <?=CHtml::textField('Email', $email, ['class' => 'span4', 'id' => 'emailmailru']);?>
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <div class="row">
              <div class="span2">
                <a class="btn" href="<?=$this->createUrl('/pay/cabinet/index');?>">
                  <i class="icon-circle-arrow-left"></i>
                  <?=\Yii::t('app', 'Назад');?>
                </a>
              </div>
              <div class="span3">
                <button type="submit" class="btn btn-info"><?=\Yii::t('app', 'Перейти к оплате')?></button>
              </div>
            </div>
          </div>
        </div>
        <?php echo CHtml::endForm();?>
      </div>
    </div>
  </div>
</section>

<?php
/**
 * @var $this \event\widgets\LinkRegistration
 */
?>

<form class="registration">

  <?if ($participant !== null && $participant->RoleId != 24):?>
    <p class="text-success" style="font-size: 16px; line-height: 20px; margin: 15px 0 30px;">
      <strong><?=Yii::app()->user->getCurrentUser()->getFullName();?></strong>,<br>
      Вы зарегистрированы на «<?=$this->event->Title;?>».<br>
      Ваш статус: <strong><?=$participant->Role->Title;?></strong><br>
      Ваш путевой лист: <a target="_blank" href="<?=$participant->getTicketUrl();?>">скачать</a>
      <?if (isset($this->RegistrationAfterInfo)):?>
        <br><br><span class="muted" style="font-size: 14px; line-height: 16px;"><?=$this->RegistrationAfterInfo;?></span>
      <?endif;?>
    </p>

    <h5 class="title"><?=Yii::t('app', 'Регистрация других участников');?></h5>
  <?else:?>
    <h5 class="title"><?=Yii::t('app', 'Регистрация');?></h5>
  <?endif;?>

  <p>
    Регистрация на&nbsp;данное мероприятие осуществляется на&nbsp;официальном сайте. Перейдя по&nbsp;ссылке &laquo;Регистрация&raquo; вам нужно будет авторизоваться используя ваш аккаунт в&nbsp;системе <nobr>RUNET-ID</nobr>.
  </p>
  <div class="clearfix">
    <a target="_blank" href="<?=$this->LinkRegistration;?>" class="btn btn-small btn-info pull-right">Зарегистрироваться</a>
  </div>
</form>
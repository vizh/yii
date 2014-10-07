<?php
/**
 * @var $this \application\widgets\admin\Sidebar
 */
?>

<div class="sidebar-nav">
  <form class="search form-inline hidden-phone">
    <input type="text" placeholder="Search...">
  </form>

  <a data-toggle="collapse" class="nav-header" href="#menu-users"><i class="icon-user icon-white"></i><span class="hidden-phone">Пользователи</span></a>
  <ul class="nav nav-list collapse" id="menu-users">
    <li><a href="<?=Yii::app()->createUrl('/user/admin/list/index');?>">Список пользователей</a></li>
    <li><a href="<?=Yii::app()->createUrl('/user/admin/merge/index');?>">Объединение</a></li>
    <li><a href="user.html">Видимость</a></li>
    <li><a href="<?=Yii::app()->createUrl('/user/admin/auth/index');?>">Быстрая авторизация</a></li>
    <li><a href="calendar.html">Контакты</a></li>
    <li><a href="">Статистика</a></li>
  </ul>

  <a data-toggle="collapse" class="nav-header" href="#menu-companies"><i class="icon-folder-close icon-white"></i><span class="hidden-phone"><?=\Yii::t('app', 'Компании');?></span></a>
  <ul class="nav nav-list collapse" id="menu-companies">
    <li><a href="<?=Yii::app()->createUrl('/company/admin/moderator/index');?>"><?=\Yii::t('app', 'Список модераторов');?></a></li>
    <li><a href="<?=Yii::app()->createUrl('/company/admin/merge/index');?>"><?=\Yii::t('app', 'Объединение');?></a></li>
  </ul>
  
  <a data-toggle="collapse" class="nav-header" href="#menu-events"><i class="icon-calendar icon-white"></i><span class="hidden-phone"><?=\Yii::t('app', 'Мероприятия');?> <?if($counts->Event != 0):?><span class="label label-info">+<?=$counts->Event?></span><?endif;?></span></a>
  <ul class="nav nav-list collapse" id="menu-events">
    <li><a href="<?=Yii::app()->createUrl('/event/admin/list/index');?>"><?=\Yii::t('app', 'Список мероприятий');?></a></li>
    <li><a href="<?=Yii::app()->createUrl('/event/admin/list/index', array('Approved' => \event\models\Approved::Yes));?>"><?=\Yii::t('app','Принятые');?></a></li>
    <li><a href="<?=Yii::app()->createUrl('/event/admin/list/index', array('Approved' => \event\models\Approved::None));?>"><?=\Yii::t('app','На одобрение');?> <?if($counts->Event != 0):?><span class="label label-info pull-right">+<?=$counts->Event?></span><?endif;?></a></li>
    <li><a href="<?=Yii::app()->createUrl('/event/admin/list/index', array('Approved' => \event\models\Approved::No));?>"><?=\Yii::t('app','Отклоненные');?></a></li>
    <li><a href="<?=Yii::app()->createUrl('/event/admin/list/index', array('Deleted' => true));?>"><?=\Yii::t('app','Удаленные');?></a></li>
    <li><a href="<?=Yii::app()->createUrl('/event/admin/default/creators');?>"><?=\Yii::t('app','Заявители');?></a></li>
  </ul>

  <a href="<?=Yii::app()->createUrl('/mail/admin/template/index');?>" class="nav-header collapsed" href="#menu-mail"><i class="icon-envelope icon-white"></i><span class="hidden-phone">Рассылки</span></a>

  <!--<a data-toggle="collapse" class="nav-header collapsed" href="#menu-companies"><i class="icon-briefcase icon-white"></i>Компании</i></a>
  <ul class="nav nav-list collapse" id="menu-companies">
    <li><a href="403.html">Список компаний</a></li>
    <li><a href="404.html">Объединение</a></li>
  </ul>-->
  
  <a href="<?=Yii::app()->createUrl('/job/admin/list/index');?>" class="nav-header collapsed" href="#menu-companies"><i class="icon-briefcase icon-white"></i><span class="hidden-phone">Вакансии</span></a>

  <a data-toggle="collapse" class="nav-header" href="#menu-commissions"><i class="icon-th icon-white"></i><span class="hidden-phone">Комиссии РАЭК</span></a>
  <ul class="nav nav-list collapse" id="menu-commissions">
    <li><a href="<?=Yii::app()->createUrl('/commission/admin/list/index');?>">Комиссии</a></li>
    <li><a href="<?=Yii::app()->createUrl('/commission/admin/export/index');?>">Экспорт</a></li>
  </ul>
  
  <a data-toggle="collapse" class="nav-header" href="#menu-catalog"><i class="icon-th-list icon-white"></i> <?=\Yii::t('app', 'Каталог');?></a>
  <ul class="nav nav-list collapse" id="menu-catalog">
    <li><a href="<?=Yii::app()->createUrl('/catalog/admin/company/index');?>"><?=\Yii::t('app', 'Компании');?></a></li>
  </ul>

  <a href="<?=Yii::app()->createUrl('/competence/admin/main/index');?>" class="nav-header collapsed" href="#menu-competence"><i class="icon-flag icon-white"></i><span class="hidden-phone">Компетенции</span></a>

  <a data-toggle="collapse" class="nav-header" href="#menu-partner"><i class="icon-certificate icon-white"></i><span class="hidden-phone">Управление партнерами</span></a>
  <ul class="nav nav-list collapse" id="menu-partner">
    <li><a href="<?=Yii::app()->createUrl('/partner/admin/account/index');?>">Партнерские Аккаунты</a></li>
    <li><a href="<?=Yii::app()->createUrl('/pay/admin/account/index');?>">Платежные Аккаунты</a></li>
    <li><a href="<?=Yii::app()->createUrl('/pay/admin/orderjuridicaltemplate/index');?>">Шаблоны юр. счетов и квитанций</a></li>
  </ul>
  
  <a data-toggle="collapse" class="nav-header" href="#menu-api"><i class="icon-tint icon-white"></i><span class="hidden-phone">API</span></a>
  <ul class="nav nav-list collapse" id="menu-api">
    <li><a href="<?=Yii::app()->createUrl('/api/admin/account/index');?>">Аккаунты</a></li>
  </ul>
  
  <a data-toggle="collapse" class="nav-header" href="#menu-order"><i class="icon-shopping-cart icon-white"></i><span class="hidden-phone">Платежная система</span></a>
  <ul class="nav nav-list collapse" id="menu-order">
    <li><a href="<?=Yii::app()->createUrl('/pay/admin/order/index');?>">Счета</a></li>
    <li><a href="<?=Yii::app()->createUrl('/pay/admin/order/print');?>">Печать</a></li>
  </ul>


  <a data-toggle="collapse" class="nav-header" href="#menu-booking" class="nav-header collapsed" href="#menu-pay"><i class="icon-globe icon-white"></i><span class="hidden-phone">Бронирование номеров</span></a>
  <ul class="nav nav-list collapse" id="menu-booking">
    <li><a href="<?=Yii::app()->createUrl('/pay/admin/booking/index');?>"><?=\Yii::t('app', 'Бронирования');?></a></li>
    <li><a href="<?=Yii::app()->createUrl('/pay/admin/booking/partners');?>"><?=\Yii::t('app', 'Партнеры');?></a></li>
    <li><a href="<?=Yii::app()->createUrl('/pay/admin/booking/statistics');?>"><?=\Yii::t('app', 'Статистика');?></a></li>
    <li><a href="<?=Yii::app()->createUrl('/pay/admin/booking/food');?>"><?=\Yii::t('app', 'Питание');?></a></li>
    <li><a href="<?=Yii::app()->createUrl('/pay/admin/booking/list');?>"><?=\Yii::t('app', 'Списки');?></a></li>
  </ul>

  <a data-toggle="collapse" class="nav-header" href="#menu-raec"><i class="icon-star icon-white"></i><span class="hidden-phone">РАЭК</span></a>
  <ul class="nav nav-list collapse" id="menu-raec">
    <li><a href="<?=Yii::app()->createUrl('/raec/admin/brief/index');?>">Анкеты</a></li>
  </ul>


  <!--<a class="nav-header" href="help.html"><i class="icon-question-sign"></i>Help</a>
  <a class="nav-header" href="faq.html"><i class="icon-comment"></i>Faq</a>-->
</div>
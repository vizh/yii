<?php
/**
 * @var $this \application\widgets\admin\Sidebar
 */
?>

<div class="sidebar-nav">
  <form class="search form-inline">
    <input type="text" placeholder="Search...">
  </form>

  <a data-toggle="collapse" class="nav-header" href="#menu-users"><i class="icon-user icon-white"></i>Пользователи</a>
  <ul class="nav nav-list collapse" id="menu-users">
    <li><a href="index.html">Список пользователей</a></li>
    <li><a href="users.html">Объединение</a></li>
    <li><a href="user.html">Видимость</a></li>
    <li><a href="media.html">Быстрая авторизация</a></li>
    <li><a href="calendar.html">Контакты</a></li>
    <li><a href="">Статистика</a></li>
  </ul>

  <a data-toggle="collapse" class="nav-header" href="#menu-events"><i class="icon-calendar icon-white"></i>Мероприятия<span class="label label-info">+3</span></a>
  <ul class="nav nav-list collapse" id="menu-events">
    <li><a href="<?=Yii::app()->createUrl('/event/admin/list/index');?>">Список мероприятий</a></li>
    <li><a href="sign-up.html">Скрытые</a></li>
    <li><a href="reset-password.html">На одобрение<span class="label label-info pull-right">+3</span></a></li>
    <li><a href="">Отклоненные</a></li>
  </ul>

  <a data-toggle="collapse" class="nav-header collapsed" href="#menu-companies"><i class="icon-briefcase icon-white"></i>Компании</i></a>
  <ul class="nav nav-list collapse" id="menu-companies">
    <li><a href="403.html">Список компаний</a></li>
    <li><a href="404.html">Объединение</a></li>
  </ul>

  <!--<a class="nav-header" href="help.html"><i class="icon-question-sign"></i>Help</a>
  <a class="nav-header" href="faq.html"><i class="icon-comment"></i>Faq</a>-->
</div>
<?php
/**
 * @var \user\models\User $user
 * @var \event\models\Event $event
 */

$partner = \Yii::app()->partner;
?>
    <div role="navigation" class="navbar navbar-inverse" id="main-navbar">
    <!-- Main menu toggle -->
        <button id="main-menu-toggle" type="button"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">СКРЫТЬ МЕНЮ</span></button>
        <div class="navbar-inner">
            <!-- Main navbar header -->
            <div class="navbar-header">
                <a class="navbar-brand" href="http://runet-id.com" target="_blank">
                    <img src="/images/partner/logo.png" />
                </a>
            </div>
            <div class="navbar-collapse main-navbar-collapse collapse in" id="main-navbar-collapse" style="height: auto;">
            <div>
                <div class="right clearfix">
                    <ul class="nav navbar-nav pull-right right-navbar-nav">
                        <li>
                            <span class="small-screen-text"><strong><?=$event->IdName?></strong> (<?=$event->Id?>)</span>
                        </li>
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle user-menu" href="#">
                                <img alt="" src="<?=$user->getPhoto()->get50px()?>">
                                <span><?=$user->getFullName()?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?if($partner->getAccount()->getIsExtended()):?>
                                    <li><?=\CHtml::link(\Yii::t('app', 'Сменить мероприятие'), ['auth/logout', 'extended' => 'reset'])?></li>
                                <?endif?>
                                <li><?=\CHtml::link(\Yii::t('app', 'Выход'), ['auth/logout'])?></li>
                            </ul>
                        </li>
                    </ul> <!-- / .navbar-nav -->
                </div> <!-- / .right -->
            </div>
        </div>
    </div>
</div>
<?php
/**
 * @var \partner\components\Controller $this
 */
$this->bodyClass = 'page-signin';
$this->showPageHeader = false;
$this->showSidebar = false;
$this->setPageTitle(\Yii::t('app', 'Авторизация в партнерском интерфейсе'));

/** @var MobileDetect $detector */
$detector = Yii::app()->mobileDetect;
?>
<div class="signin-container">
    <div class="signin-form">
        <div class="text-center m-bottom_20">
            <img src="/images/partner/logo.png" alt="RUNET-ID" title="RUNET-ID" />
        </div>
        <div class="signin-text">
            <span><?=\Yii::t('app', 'Партнерский интерфейс')?></span>
        </div> <!-- / .signin-text -->

        <p class="text-center"><?=\Yii::t('app', 'Для доступа к партнерcкому интерфейсу необходимо быть авторизованным в основной части сайта')?></p>
        <div class="form-actions text-center">
            <?=\CHtml::link(\Yii::t('app', 'Авторизоваться'), ($detector->isMobile() ? ['/oauth/main/auth', 'url' => $_SERVER['REQUEST_URI']] : '#'), ($detector->isMobile() ? ['class' => 'signin-btn bg-primary'] : ['id' => 'NavbarLogin', 'class' => 'signin-btn bg-primary']))?>
        </div>
    </div>
    <!-- Right side -->
</div>
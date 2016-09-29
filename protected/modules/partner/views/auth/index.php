<?php
/**
 * @var \partner\components\Controller $this
 */
$this->bodyClass = 'page-signin';
$this->showPageHeader = false;
$this->showSidebar = false;
$this->setPageTitle(\Yii::t('app', 'Авторизация в партнерском интерфейсе'));
?>
<div class="signin-container">
    <div class="signin-form">
        <form id="signin-form_id" action="" novalidate="novalidate" method="post">
            <div class="text-center m-bottom_20">
                <img src="/images/partner/logo.png" alt="RUNET-ID" title="RUNET-ID" />
            </div>
            <div class="signin-text">
                <span><?=\Yii::t('app', 'Партнерский интерфейс')?></span>
            </div> <!-- / .signin-text -->

            <?if($this->error):?>
                <div class="alert alert-danger">
                    <?=\Yii::t('app', 'Ошибка авторизации')?>
                </div>
            <?endif?>

            <div class="form-group w-icon">
                <input type="text" placeholder="Введите свой логин" class="form-control input-lg" id="username_id" name="login">
                <span class="fa fa-user signin-form-icon"></span>
            </div> <!-- / Username -->

            <div class="form-group w-icon">
                <input type="password" placeholder="Пароль" class="form-control input-lg" name="password">
                <span class="fa fa-lock signin-form-icon"></span>
            </div> <!-- / Password -->

            <div class="form-actions">
                <input type="submit" class="signin-btn bg-primary" value="Вход">
            </div> <!-- / .form-actions -->
        </form>
    </div>
    <!-- Right side -->
</div>

<?php
/**
 * @var \application\components\controllers\PublicMainController $this
 * @var \user\models\User $user
 */
$this->bodyId = 'user-account';
$this->setPageTitle(\Yii::t('app', 'Подтверждение профиля'));
?>

<h2 class="b-header_large light">
    <div class="line"></div>
    <div class="container">
        <div class="title">
            <span class="backing runet">Runet</span>
            <span class="backing text"><?=$this->getPageTitle()?></span>
        </div>
    </div>
</h2>
<div class="user-account-settings">
    <div class="clearfix">
        <div class="container">
            <div class="row">
                <div class="span9 offset3 m-bottom_40">
                    <p><strong><?=$user->getShortName()?>, <?=\Yii::t('app', 'cпасибо за подтверждение профиля, нам очень приятно видеть Вас в числе пользователей нашего сервиса.')?></strong></p>
                    <p><?=\Yii::t('app', 'Теперь Вы всегда сможете легко зарегистрироваться на любое мероприятие, которое является партнером нашего сервиса. А таких очень много и среди них крупнейшние: Российский Интернет Форум, Russian Internet Week, Performance Marketing, конкурсы «Премия Рунета» и «Золотой Сайт», а также множество других проектов.')?></p>
                    <p><?=\Yii::t('app', 'Информация об участии в мероприятиях будет сохраняться в Вашем профиле. История профессиональных активностей будет отличным дополнением к резюме ;)')?></p>
                    <p><?=\Yii::t('app', 'В случае возникновения вопросов, Вы всегда можете обратиться к нам по адресу <a href="mailto:support@runet-id.com">support@runet-id.com</a> или ответить на любое из наших писем – мы действительно их получаем, читаем и отвечаем!')?></p>
                    <p><?=\Yii::t('app', 'Будем на связи!')?></p>
                    <p class="text-center"><?=\CHtml::link(\Yii::t('app', 'Редактировать профиль'), ['edit/index'], ['class' => 'btn btn-large btn-info'])?></p>
                </div>
            </div>
        </div>
    </div>
</div>


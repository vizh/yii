<?
use user\models\User;
?>
<div class="row">
    <div class="span12">
        <p>Некоммерческое партнерство «Ассоциация электронных коммуникаций» (далее – «Ассоциация»), является организацией, основанной на членстве юридических лиц, осуществляющих профессиональную деятельность по поиску, производству, хранению и распространению информации в сети Интернет, по использованию интернет-технологий, а также деятельность в иных сферах электронных коммуникаций.</p>
        <p>Ассоциация создана в 2006 году  в соответствии с Гражданским кодексом Российской Федерации и Федеральным законом от 12 января 1996 г. № 7-ФЗ «О некоммерческих организациях».</p>
        <p>Полное наименование Ассоциации на русском языке:<br/>
        <strong>Некоммерческое партнерство «Ассоциация электронных коммуникаций».</strong></p>

        <p>Сокращенное наименование Ассоциации на русском языке:<br/>
        <strong>НП «РАЭК»</strong></p>

        <p>Сокращенное наименование Ассоциации на английском языке:<br/>
        <strong>«RAEC»</strong></p>

        <div class="row">
            <div class="span4">
                <p><strong>Директор Ассоциации <br/>(с 2010 года по н.в.):</strong></p>
                <?$user = User::model()->byRunetId(337)->find();?>
                <div class="company-account m-bottom_5">
                    <div class="b-employees units row">
                        <div class="employee unit span2">
                            <a class="imgcrop-140" href="<?=$user->getUrl();?>" target="_blank">
                                <img width="138" height="138" alt="<?=$user->getFullName();?>" src="<?=$user->getPhoto()->get200px();?>">
                            </a>
                            <p class="name"><a href="<?=$user->getUrl();?>" target="_blank"><?=$user->getFullName();?></a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span4">
                <p><strong>Председатель Совета Ассоциации <br/>(с 2013 года по н.в.):</strong></p>
                <?$user = User::model()->byRunetId(94455)->find();?>
                <div class="company-account m-bottom_5">
                    <div class="b-employees units row">
                        <div class="employee unit span2">
                            <a class="imgcrop-140" href="<?=$user->getUrl();?>" target="_blank">
                                <img width="138" height="138" alt="<?=$user->getFullName();?>" src="<?=$user->getPhoto()->get200px();?>">
                            </a>
                            <p class="name"><a href="<?=$user->getUrl();?>" target="_blank"><?=$user->getFullName();?></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p>Адрес места нахождения Ассоциации:<br/>
        <strong>123100, РФ, г.Москва, Пресненская наб., 12, Башня «Федерация Запад»</strong></p>

        <p>Официальный веб-сайт Ассоциации:<br/>
        <a href="http://www.raec.ru" target="_blank">www.raec.ru</a></p>
    </div>
</div>
<hr/>
<div class="row">
    <div class="span12 text-center">
        <?if (\Yii::app()->getUser()->getIsGuest()):?>
            <p class="text-error"><?=\Yii::t('app', 'Перед началом заполнения анкеты требуется');?> <a href="#" id="PromoLogin"><?=\Yii::t('app', 'авторизоваться или зарегистрироваться');?></a></p>
        <?endif;?>
        <?=\CHtml::beginForm();?>
            <?=\CHtml::submitButton(\Yii::t('app', 'Заполнить анкету'), ['class' => 'btn btn-success btn-large'.(\Yii::app()->getUser()->getIsGuest() ? ' disabled' : '')]);?>
            <?=$this->getNextActionInput();?>
        <?=\CHtml::endForm();?>
    </div>
</div>
<?
use user\models\User;
?>
<div class="row">
    <div class="span12">
        <div style="text-align: center;">
            <a href="http://raec.ru" target="_blank"><img src="http://getlogo.org/img/raec/4/100x/" alt="РАЭК" title="РАЭК" /></a>
        </div>
        <h3>База данных членов РАЭК (для участия в Общем собрании 20 октября 2014 года)</h3>

        <p><strong>Об Ассоциации</strong></p>
        <p>Некоммерческое партнерство "Ассоциация электронных коммуникаций" (НП "РАЭК") было создано в 2006 году.</p>
        <p>Миссия РАЭК – формирование цивилизованного рынка электронных коммуникаций, поддержка проектов в отраслевом образовании и науке, развитие нормативно-правового поля по защите интересов участников рынка.</p>
        <p>Официальный сайт Ассоциации: <a href="http://www.raec.ru" target="_blank">www.raec.ru</a>


        <p><strong>О членах Ассоциации</strong></p>
        <p></p>НП “РАЭК" является организацией, основанной на членстве юридических лиц, осуществляющих профессиональную деятельность по поиску, производству, хранению и распространению информации в сети Интернет, по использованию интернет-технологий, а также деятельность в иных сферах электронных коммуникаций.</p>
        <p>На сегодняшний день Ассоциация объединяет более 130 игроков рынка электронных коммуникаций, что позволяет РАЭК объективно представлять интересы отрасли, и эффективно решать ее задачи.</p>
        <p>Список членов Ассоциации с логотипами и краткими описаниями:<br/>
        <a href="http://raec.ru/about/members/" target="_blank">http://raec.ru/about/members/</a></p>
    </div>
</div>
<hr/>
<div class="row">
    <div class="span12 text-center">
        <?if(\Yii::app()->getUser()->getIsGuest()):?>
            <p class="text-error"><?=\Yii::t('app', 'Перед началом заполнения анкеты требуется')?> <a href="#" id="PromoLogin"><?=\Yii::t('app', 'авторизоваться или зарегистрироваться')?></a></p>
        <?endif?>
        <?=\CHtml::beginForm()?>
            <?=\CHtml::submitButton(\Yii::t('app', 'Заполнить анкету члена РАЭК'), ['class' => 'btn btn-success btn-large'.(\Yii::app()->getUser()->getIsGuest() ? ' disabled' : '')])?>
            <?=$this->getNextActionInput()?>
        <?=\CHtml::endForm()?>
    </div>
</div>
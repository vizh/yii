<?php
/**
 * @var $question \competence\models\tests\mailru2013\A1
 */
$fullData = $question->getFullData();

$manager = \Yii::app()->getAssetManager();
$path = $manager->publish(\Yii::getPathOfAlias('competence.assets') . '/images/mailru2013');

\Yii::app()->getClientScript()->registerScriptFile($manager->publish(\Yii::getPathOfAlias('competence.assets') . '/js/mailru2013/a1.js'), \CClientScript::POS_END);
?>

<p class="text-center text-error"><strong>Внимание!</strong> Выбранные в вопросе варианты, после продолжения опроса или возврата назад уже не смогут быть изменены.</p>

<h3>Перед Вами несколько портретов людей,<br> работающих в различных интернет-компаниях.<br> Отметьте, пожалуйста, кого из них Вы знаете?</h3>

<?$this->widget('competence\components\ErrorsWidget', ['question' => $question])?>

<ul class="unstyled interview-photo">
  <?foreach($question->getOptions() as $key => $value):?>
  <li data-key="<?=$key?>">
    <img src="<?=$path.'/'.$value?>" alt="">
    <?if($key != 49):?>
    <span class="notselect">???</span><span class="select">Знаю</span>
    <?else:?>
    <span class="unknow">Затрудняюсь ответить</span>
    <?endif?>

    <?=CHtml::activeHiddenField($question, 'value['.$key.']', ['disabled' => true])?>
  </li>
  <?endforeach?>
</ul>

  <div class="clearfix"></div>

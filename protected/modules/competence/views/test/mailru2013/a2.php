<?php
/**
 * @var $question \competence\models\tests\mailru2013\A2
 */

$base = new \competence\models\tests\mailru2013\A1($question->getTest());
$fullData = $question->getFullData();
$baseData = $fullData[get_class($base)];


$manager = \Yii::app()->getAssetManager();
$path = $manager->publish(\Yii::getPathOfAlias('competence.assets') . '/images/mailru2013');

//\Yii::app()->getClientScript()->registerScriptFile($manager->publish(\Yii::getPathOfAlias('competence.assets') . '/js/jquery-ui-1.9.2.custom.min.js'), \CClientScript::POS_END);

\Yii::app()->getClientScript()->registerScriptFile($manager->publish(\Yii::getPathOfAlias('competence.assets') . '/js/mailru2013/a2.js'), \CClientScript::POS_END);
?>

<p class="text-center text-error"><strong>Внимание!</strong> Выбранные в вопросе варианты, после продолжения опроса или возврата назад уже не смогут быть изменены.</p>

<h3>Вы отметили, что знаете, кто эти люди.  Впишите, пожалуйста, фамилию человека и компанию, в которой он работает</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<div class="row">
  <div class="span10">
    <div class="row">
      <?$i=0;
      foreach ($base->getOptions() as $key => $value):
        if (!isset($baseData['value'][$key]))
        {
          continue;
        }
        $i++;
       ?>

        <div class="span2">
          <div class="interview-photo-short"><img src="<?=$path.'/'.$value?>" alt=""></div>
        </div>
        <div class="span3 interview-photo-inputs">
          <?=CHtml::activeLabel($question, 'value['.$key.'][LastName]', array('label' => 'Фамилия'))?>
          <?=CHtml::activeTextField($question, 'value['.$key.'][LastName]')?>
          <label class="checkbox"><?=CHtml::activeCheckBox($question, 'value['.$key.'][LastNameEmpty]', array('value' => 1, 'uncheckValue' => null))?>  затрудняюсь ответить</label>

          <?=CHtml::activeLabel($question, 'value['.$key.'][Company]', array('label' => 'Компания'))?>
          <?=CHtml::activeTextField($question, 'value['.$key.'][Company]')?>
          <label class="checkbox"><?=CHtml::activeCheckBox($question, 'value['.$key.'][CompanyEmpty]', array('value' => 1, 'uncheckValue' => null))?>  затрудняюсь ответить</label>
        </div>
        <?if($i % 2 == 0):?>
        <div class="clearfix ib2"></div>
        <?endif?>
        <?endforeach?>
    </div>
  </div>
</div>

<div class="clearfix"></div>

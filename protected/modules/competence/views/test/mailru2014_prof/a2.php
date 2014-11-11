<?php
/**
 * @var $form \competence\models\test\mailru2013_2\A2
 */

$manager = \Yii::app()->getAssetManager();
$path = $manager->publish(\Yii::getPathOfAlias('competence.assets') . '/images/mailru2014_prof');

\Yii::app()->getClientScript()->registerScriptFile($manager->publish(\Yii::getPathOfAlias('competence.assets') . '/js/mailru2013/a2.js'), \CClientScript::POS_END);
?>

<div class="row">
  <div class="span10">
    <div class="row">
      <?$i=0;
      foreach ($form->getOptions() as $key => $value):
        $i++;
        ?>

        <div class="span2">
          <div class="interview-photo-short"><img src="<?=$path.'/'.$value;?>" alt=""></div>
        </div>
        <div class="span3 interview-photo-inputs">
          <?=CHtml::activeLabel($form, 'value['.$key.'][LastName]', array('label' => 'Фамилия'));?>
          <?=CHtml::activeTextField($form, 'value['.$key.'][LastName]');?>
          <label class="checkbox"><?=CHtml::activeCheckBox($form, 'value['.$key.'][LastNameEmpty]', array('value' => 1, 'uncheckValue' => null));?>  затрудняюсь ответить</label>

          <?=CHtml::activeLabel($form, 'value['.$key.'][Company]', array('label' => 'Компания'));?>
          <?=CHtml::activeTextField($form, 'value['.$key.'][Company]');?>
          <label class="checkbox"><?=CHtml::activeCheckBox($form, 'value['.$key.'][CompanyEmpty]', array('value' => 1, 'uncheckValue' => null));?>  затрудняюсь ответить</label>
        </div>
        <?if ($i % 2 == 0):?>
        <div class="clearfix ib2"></div>
      <?endif;?>
      <?endforeach;?>
    </div>
  </div>
</div>

<div class="clearfix"></div>


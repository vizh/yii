<?php
/**
 * @var $form \competence\models\test\mailru2013_2\A1
 */
$manager = \Yii::app()->getAssetManager();
$path = $manager->publish(\Yii::getPathOfAlias('competence.assets') . '/images/mailru2014_prof');

\Yii::app()->getClientScript()->registerScriptFile($manager->publish(\Yii::getPathOfAlias('competence.assets') . '/js/mailru2013/a1.js'), \CClientScript::POS_END);
?>

<ul class="unstyled interview-photo">
  <?foreach ($form->getOptions() as $key => $value):?>
    <li data-key="<?=$key;?>">
      <img src="<?=$path.'/'.$value;?>" alt="">
      <?if ($key != 49):?>
        <span class="notselect">???</span><span class="select">Знаю</span>
      <?else:?>
        <span class="unknow">Затрудняюсь ответить</span>
      <?endif;?>

      <?=CHtml::activeHiddenField($form, 'value['.$key.']', ['disabled' => true]);?>
    </li>
  <?endforeach;?>
</ul>

<div class="clearfix"></div>


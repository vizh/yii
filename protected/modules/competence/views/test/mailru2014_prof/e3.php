<?php
/**
 * @var $form \competence\models\test\mailru2013_2\E3
 */
$manager = \Yii::app()->getAssetManager();
//\Yii::app()->getClientScript()->registerScriptFile($manager->publish(\Yii::getPathOfAlias('competence.assets') . '/js/mailru2013/e3.js'), \CClientScript::POS_END);
?>
<ul class="unstyled">
  <?foreach ($form->getValues() as $value):?>
    <li>
      <h4><?=$value->title;?></h4>
      <ul class="unstyled">
        <?foreach ($form->options as $key_1 => $value_1):?>
          <?
          $attrs = [
            'value' => $key_1,
            'uncheckValue' => null,
            'data-group' => $form->getQuestion()->Code.'_'.$value->key,
            'data-unchecker' => 0,
            'checked' => !empty($form->value[$value->key]) && in_array($key_1, $form->value[$value->key])
          ];
          if ($key_1 == 6)
          {
            $attrs['data-target'] = '#'.$form->getQuestion()->Code.'_'.$value->key.'_'.$key_1;
          }
          ?>
          <li>
            <label class="checkbox">
              <?=CHtml::activeCheckBox($form, 'value['.$value->key.'][]', $attrs);?>
              <?=$value_1;?>
            </label>
            <?if ($key_1 == 6):?>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($form, 'other['.$value->key.']', ['class' => 'span4', 'data-group' => $form->getQuestion()->Code.'_'.$value->key, 'id' => $form->getQuestion()->Code.'_'.$value->key.'_'.$key_1]);?>
            <?endif;?>
          </li>
        <?endforeach;?>
      </ul>
    </li>
  <?endforeach;?>
</ul>

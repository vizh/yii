<?/**
 * @var \contact\models\forms\PhoneNewFormat $form
 */
?>

<div class="widget-phone-controls">
  <div class="controls">
    <div class="input-prepend">
      <?=\CHtml::activeTextField($form, 'OriginalPhone', ['class' => 'input-block-level', 'placeholder' => \Yii::t('app', 'Номер телефона')]);?>
    </div>
  </div>
</div>
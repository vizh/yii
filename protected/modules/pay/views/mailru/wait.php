<?php
/**
 * @var MailruController $this
 */
?>

<section id="section" role="main">
  <div class="container m-top_40 m-bottom_50">
    <div class="row">
      <div class="offset2 span8">
        <h3><?=Yii::t('app', 'Ожидание счета в системе Деньги@mail.ru');?></h3>

        <p>Идет выставление счета в системе Деньги@mail.ru. Подождите несколько минут и нажмите кнопку "Перейти к счету"</p>



        <?=CHtml::beginForm('', 'POST', array('class' => 'm-top_30'));?>


        <div class="control-group">
          <div class="controls">
            <div class="row">
              <div class="span3">
                <button type="submit" class="btn btn-info"><?=\Yii::t('app', 'Перейти к счету')?></button>
              </div>
            </div>
          </div>
        </div>

        <?php echo CHtml::endForm();?>


      </div>
    </div>
  </div>


</section>

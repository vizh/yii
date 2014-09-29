<?
/**
 * @var $done bool
 * @var $test \competence\models\Test
 */
?>

<div class="row">
  <div class="span8 offset2 m-top_30 text-center">
      <?if (!empty($test->AfterEndText)):?>
          <?=$test->AfterEndText;?>
      <?else:?>
          <p class="lead">БОЛЬШОЕ СПАСИБО ЗА УЧАСТИЕ В НАШЕМ ИССЛЕДОВАНИИ!</p>
      <?endif;?>


    <?if ($done):?>
      <p style="color: #ff9900;">Вы уже ответили на вопросы исследования ранее.</p>
    <?endif;?>
  </div>
</div>
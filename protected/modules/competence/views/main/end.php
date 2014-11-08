<?
/**
 * @var $done bool
 * @var $test \competence\models\Test
 */
?>

<div class="row">
  <div class="span8 offset2 m-top_30 text-center">
      <?if (!empty($test->AfterEndText)):?>
          <?
              $RunetId = \Yii::app()->user->getCurrentUser()->RunetId;
              if ($test->Id == 12) {
                  $regLink = "http://riw.moscow/my/?RUNETID=" . $RunetId . "&KEY=" . substr(md5($RunetId . 'vyeavbdanfivabfdeypwgruqe'), 0, 16);
                  echo str_replace("{link}", $regLink, $test->AfterEndText);
              } else {
                  echo $test->AfterEndText;
              }
          ?>
      <?else:?>
          <p class="lead">БОЛЬШОЕ СПАСИБО ЗА УЧАСТИЕ В НАШЕМ ИССЛЕДОВАНИИ!</p>
      <?endif;?>


    <?if ($done):?>
      <p style="color: #ff9900;">Вы уже ответили на вопросы исследования ранее.</p>
    <?endif;?>
  </div>
</div>
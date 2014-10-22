<?php
/**
 * @var $test \competence\models\Test
 */
?>
<div class="row">
  <div class="span8 offset2 m-top_30 text-center">
    <?if ($test->EndTime == null || $test->EndTime > date('Y-m-d H:i:s')):?>
      <?=$test->Info;?>
      <div class="text-center m-top_30">
        <form action="" method="post">
          <input type="hidden" name="start" value="1">
          <button type="submit" class="btn btn-success"><?=$test->StartButtonText;?></button>
        </form>
      </div>
    <?else:?>
      <?if ($test->AfterEndText != null):?>
        <?=$test->AfterEndText;?>
      <?else:?>
        <?=$test->Info;?>
      <?endif;?>
    <?endif;?>
  </div>
</div>

<p class="muted text-center"><small>Можно выбрать не более 5 вариантов</small></p>
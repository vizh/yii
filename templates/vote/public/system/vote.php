<?php
/**
 * @var $step VoteStep
 */
$step = $this->Step;
?>
<div class="vote">
  <h2><?=$step->Title;?></h2>

  <h3 style="margin-bottom: 20px;">Заполнено <?=$this->CountQuestions[0];?> из <?=$this->CountQuestions[1];?> <?=Yii::t('', 'вопроса|вопросов|вопросов|вопросов', $this->CountQuestions[1])?></h3>

  <?//if ($this->CanReset):?>
  <p style="margin-bottom: 30px;"><strong>Внимание!</strong><br><!--Вы ранее проходили опрос, он был восстановлен.-->Если вы хотите начать с начала, перейдите по
    <a href="?reset=1">ссылке</a></p>
  <?//endif;?>

  <form id="vote_form" method="post" action="">
    <input type="hidden" name="Step" value="<?=$step->Number;?>">
    <input id="VoteFormBack" type="hidden" name="Back" value="0">
    <?=$this->Questions;?>
  </form>
</div>


  <?if ($step->Number > 1):?>
<div style="width: 200px; float: left; margin-right: 50px;" class="response">
  <a onclick="$('#VoteFormBack').attr('value', 1); $('#vote_form')[0].submit(); return false;" href="">Назад</a>
</div>
  <?endif;?>
<div style="width: 200px; float: right;" class="response">
  <a onclick="$('#vote_form')[0].submit(); return false;" href="">Далее</a>
</div>



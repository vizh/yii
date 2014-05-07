<?php
/**
 * @var \competence\models\Question[] $questions
 * @var \competence\models\Test $test
 */
?>

<div class="container m-top_40">
  <h3 class="text-center competence-title"><?=$test->Title;?></h3>
</div>

<div class="container interview m-top_30 m-bottom_40">

  <div class="row m-top_30">
    <div class="span9 offset2">
      <?=CHtml::beginForm();?>

      <?=CHtml::hiddenField('CompetenceTest', $test->Id);?>

      <?foreach($questions as $question):?>
        <h3 style="margin-bottom: 10px; margin-top: 20px;">
          <?=$question->Title;?>
          <?if (!empty($question->SubTitle)):?>
            <br><span><?=$question->SubTitle;?></span>
          <?endif;?>
        </h3>
        <?
        $this->widget('competence\components\ErrorsWidget', array('form' => $question->getForm()));
        $this->renderPartial($question->getForm()->getViewPath(), ['form' => $question->getForm()]);
        ?>
      <?endforeach;?>


      <div class="row interview-controls">
        <div class="span8 text-center">
          <input type="submit" class="btn btn-success" value="<?=$test->StartButtonText;?>" name="next">
        </div>
      </div>
      <?=CHtml::endForm();?>
    </div>
  </div>

</div>
<?php
/**
 * @var $this MainController
 */
?>
<?php $this->beginContent('/layouts/public'); ?>
  <div class="row m-top_30">
    <div class="span9 offset2">
      <?=CHtml::beginForm();?>
      <input type="hidden" name="question" value="<?=$this->question->Id;?>">
      <?=CHtml::activeHiddenField($this->question->getForm(), '_t');?>

      <?=$this->question->BeforeTitleText != null ? $this->question->BeforeTitleText : '';?>

      <h3>
        <?=$this->question->getForm()->getTitle();?>
        <?if (!empty($this->question->SubTitle)):?>
          <br><span><?=$this->question->SubTitle;?></span>
        <?endif;?>
      </h3>

      <?php $this->widget('competence\components\ErrorsWidget', array('form' => $this->question->getForm()));?>

      <?=$this->question->AfterTitleText != null ? $this->question->AfterTitleText : '';?>

      <?=$content;?>

      <?=$this->question->AfterQuestionText != null ? $this->question->AfterQuestionText : '';?>


      <div class="row interview-controls">
        <div class="span8 text-center">
          <?if ($this->question->getForm()->getPrev() !== null):?>
            <input type="submit" class="btn" style="margin-right: 30px;" value="Вернуться" name="prev">
          <?endif;?>
          <input type="submit" class="btn btn-success" value="Продолжить" name="next">
        </div>
      </div>

      <?=CHtml::endForm();?>
    </div>
  </div>
<?php $this->endContent(); ?>
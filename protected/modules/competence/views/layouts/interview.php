<?php
/**
 * @var $this MainController
 */
?>
<?php $this->beginContent('/layouts/public'); ?>
<div class="row m-top_30">
  <div class="span9 offset2">
    <?=CHtml::beginForm();?>
    <input type="hidden" name="question" value="<?=get_class($this->question);?>">
    <?=CHtml::activeHiddenField($this->question, '_t');?>
    <?=$content; ?>
    <div class="row interview-controls">
      <div class="span8 text-center">
        <?if ($this->question->getPrev() !== null):?>
        <input type="submit" class="btn" style="margin-right: 30px;" value="Вернуться" name="prev">
        <?endif;?>
        <input type="submit" class="btn btn-success" value="Продолжить" name="next">
      </div>
    </div>

    <?=CHtml::endForm();?>
  </div>
</div>
<?php $this->endContent(); ?>
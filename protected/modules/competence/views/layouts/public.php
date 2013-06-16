<?php
/**
 * @var $this MainController
 */
?>
<?php $this->beginContent('//layouts/public'); ?>
  <div class="container m-top_40">
    <h3 class="text-center competence-title"><?=$this->test->Title;?></h3>
  </div>
<?if (!empty($this->question) && false):?>
  <div class="container">
    <?
    $percent = \competence\models\Question::GetPercent(get_class($this->question));
    ?>
    <?if ($percent !== null):?>
      <p style="text-align: center;">Опрос пройден на <strong><?=$percent;?>%</strong></p>
      <div class="row">
        <div class="span8 offset2">
          <div class="progress progress-success progress-striped">
            <div class="bar" style="width: <?=intval($percent);?>%"></div>
          </div>
        </div>
      </div>
    <?endif;?>
  </div>
<?endif;?>
  <div class="container interview m-top_30 m-bottom_40">
    <?=$content;?>
  </div>
<?php $this->endContent(); ?>
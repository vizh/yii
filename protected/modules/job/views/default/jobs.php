<?php
/**
 * @var $jobs \job\models\Job[]
 */

?>

<div class="container">
  <div class="row">
    <?foreach($jobs as $job):?>
      <div class="job span3">
        <div class="details">
          <span class="label label-warning"><?=\Yii::app()->dateFormatter->format('dd MMMM', $job->CreationTime)?></span>
          <span class="employer"><?=$job->Company->Name?></span>
          <span class="fade-rtl"></span>
        </div>
        <header>
          <h4 class="title">
            <a target="_blank" href="<?=$job->Url?>"><?=$job->Title?></a>
          </h4>
        </header>
        <article>
          <p><?=\application\components\utility\Texts::cropText($job->Text, \Yii::app()->params['JobPreviewLength'])?></p>
          <a target="_blank" href="<?=$job->Url?>"><?=\Yii::t('app', 'Ответить на вакансию')?></a>
        </article>
        <footer class="salary">
          <?=$this->renderPartial('job-salary', array('job' => $job))?>
        </footer>
        <div class="category">
          <a href="<?=$this->createUrl('/job/default/index', array('Filter[CategoryId]' => $job->CategoryId))?>"><?=$job->Category->Title?></a>
        </div>
      </div>
    <?endforeach?>
  </div>
</div>
<?if ($job->SalaryFrom == $job->SalaryTo):?>
  <span>&nbsp;</span>
  <strong><?=\Yii::app()->locale->numberFormatter->formatDecimal($job->SalaryFrom);?></strong>
<?elseif (empty($job->SalaryTo)):?>
  <span><?=\Yii::t('app', 'от');?></span>
  <strong><?=\Yii::app()->locale->numberFormatter->formatDecimal($job->SalaryFrom);?></strong>
<?elseif (empty($job->SalaryFrom)):?>
  <span><?=\Yii::t('app', 'до');?></span>
  <strong><?=\Yii::app()->locale->numberFormatter->formatDecimal($job->SalaryTo);?></strong>
<?else:?>
  <span>&nbsp;</span>
  <strong><?=\Yii::app()->locale->numberFormatter->formatDecimal($job->SalaryFrom);?>&nbsp;&ndash;&nbsp;<?=\Yii::app()->locale->numberFormatter->formatDecimal($job->SalaryTo);?></strong>
<?endif;?>
<span><?=\Yii::t('app', 'Р');?></span>

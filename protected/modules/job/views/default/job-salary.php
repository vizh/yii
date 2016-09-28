<?if(isset($allowInterval) && !empty($job->SalaryTo) && !empty($job->SalaryTo)):?>
  <span>&nbsp;</span>
  <strong><?=\Yii::app()->locale->numberFormatter->formatDecimal($job->SalaryFrom)?>&nbsp;&ndash;&nbsp;<?=\Yii::app()->locale->numberFormatter->formatDecimal($job->SalaryTo)?></strong>
<?elseif (!empty($job->SalaryTo)):?>
  <span><?=\Yii::t('app', 'до')?></span>
  <strong><?=\Yii::app()->locale->numberFormatter->formatDecimal($job->SalaryTo)?></strong>
  <span><?=\Yii::t('app', 'Р')?></span>
<?elseif (!empty($job->SalaryFrom)):?>
  <span><?=\Yii::t('app', 'от')?></span>
  <strong><?=\Yii::app()->locale->numberFormatter->formatDecimal($job->SalaryFrom)?></strong>
  <span><?=\Yii::t('app', 'Р')?></span>
<?else:?>
  <span>по результатам</span>
  <strong>собеседования</strong>
  <span>&nbsp;</span>
<?endif?>

<table class="table">
  <thead>
    <th><?=\Yii::t('app', 'Название теста')?></th>
    <th><?=\Yii::t('app', 'Дата окончания')?></th>
    <th></th>
  </thead>
  <?foreach($tests as $test):?>
  <?$resultsUrl = $this->createUrl('/partner/competence/results', ['testId' => $test->Id])?>
  <tr>
    <td>
      <a href="<?=$resultsUrl?>"><?=$test->Title?></a><br/><?=\Yii::t('app', 'Кол-во результатов')?>: <?=sizeof($test->ResultsAll)?>
    </td>
    <td><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $test->EndTime)?></td>
    <td><a href="<?=$resultsUrl?>" class="btn btn-info"><?=\Yii::t('app', 'Cписок результатов')?></a></td>
  </tr>
  <?endforeach?>
</table>

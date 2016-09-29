<h2 class="m-bottom_20"><?=\Yii::t('app', 'Результаты теста:<br/>{test}', ['{test}' => $test->Title])?></h2>
<?if(!empty($results)):?>
<table class="table">
  <thead>
    <th><?=\Yii::t('app', 'RUNET-ID, ФИО')?></th>
    <th><?=\Yii::t('app', 'Дата прохождения')?></th>
    <th></th>
  </thead>
  <tbody>
    <?foreach($results as $result):?>
    <tr>
      <td>
        <?if($result->UserId !== null):?>
          <a href="<?=$result->User->getUrl()?>" target="_blank"><strong><?=$result->User->RunetId?></strong>, <?=$result->User->getFullName()?></a>
        <?else:?>
          <?=\Yii::t('app', 'Пройден анонимно')?>
        <?endif?>
        <br/>
        <?if($result->Finished):?>
          <span class="label label-success"><?=\Yii::t('app', 'Пройден полностью')?></span>
        <?else:?>
          <span class="label label-warning"><?=\Yii::t('app', 'До конца не пройден')?></span>
        <?endif?>
      </td>
      <td><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm:ss', $result->UpdateTime)?></td>
      <td><a href="<?=$this->createUrl('/partner/competence/answers', ['testId' => $test->Id, 'resultId' => $result->Id, 'backPage' => $paginator->page])?>" class="btn btn-info"><?=\Yii::t('app', 'Посмотреть ответы')?></a></td>
    </tr>
    <?endforeach?>
  </tbody>
</table>
<?$this->widget('\application\widgets\Paginator', ['paginator' => $paginator])?>
<?else:?>
<div class="alert alert-error"><?=\Yii::t('app', 'К сожалению, для этого теста еще нет ни одного результата!')?></div>
<?endif?>

<div class="row m-bottom_20">
  <div class="span12"><a href="<?=$this->createUrl('/partner/competence/results/', ['testId' => $test->Id, 'page' => $backPage])?>" class="btn">&larr; <?=\Yii::t('app', 'Вернуться к списку ответов')?></a></div>
</div>

<div class="row m-bottom_10">
  <div class="span12"><p><?=\Yii::t('app', 'Ответы пользователя: <ins>{user}</ins> в тесте: <ins>{test}</ins>', ['{user}' => $result->UserId !== null ? $result->User->getFullName() : \Yii::t('app', 'Аноним'), '{test}' => $test->Title])?></p></div>
</div>

<?if(!empty($answers)):?>
<table class="table table-striped">
  <thead>
    <th><?=\Yii::t('app', 'Вопрос')?></th>
    <th><?=\Yii::t('app', 'Ответ')?></th>
  </thead>
  <tbody>
    <?foreach($answers as $answer):?>
    <tr>
      <td class="muted" style="width: 400px;"><?=$answer->Question->Title?></td>
      <td>
        <?if(!is_array($answer->Answer)):?>
          <?=$answer->Answer?>
        <?else:?>
          <ul style="margin-bottom: 0;">
          <?foreach($answer->Answer as $value):?>
            <li><?=$value?></li>
          <?endforeach?>
          </ul>
        <?endif?>
      </td>
    </tr>
    <?endforeach?>
  </tbody>
</table>
<?else:?>
<div class="alert alert-error"><?=\Yii::t('app', 'Пользователь не дал ответ ни на один вопрос!')?></div>
<?endif?>


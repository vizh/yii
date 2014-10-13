<?php
/**
 * @var \competence\models\Test[] $tests
 */
?>
<div class="well">
  <table class="table">
    <thead>
    <tr>
      <th><?=\Yii::t('app', 'ID');?></th>
      <th><?=\Yii::t('app', 'Код');?></th>
      <th>Заголовок теста</th>
      <th></th>
    </tr>
    </thead>
    <?foreach($tests as $test):?>
      <tr>
        <td><?=$test->Id;?></td>
        <td><?=$test->Code;?></td>
        <td><?=$test->Title;?></td>
        <td>
            <a href="<?=$this->createUrl('/competence/admin/main/edit', ['id' => $test->Id]);?>" class="btn"><i class="icon-edit"></i>&nbsp;<?=\Yii::t('app', 'Редактировать');?></a>
            <a href="<?=$this->createUrl('/competence/admin/export/index', ['id' => $test->Id]);?>" class="btn"><i class="icon-info-sign"></i>&nbsp;<?=\Yii::t('app', 'Статистика');?></a>
        </td>
      </tr>
    <?endforeach;?>
  </table>
</div>
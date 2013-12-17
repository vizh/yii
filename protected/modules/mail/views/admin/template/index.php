<div class="btn-toolbar">
  <a href="<?=$this->createUrl('/mail/admin/template/edit', []);?>" class="btn btn-success"><?=\Yii::t('app', 'Создать рассылку');?></a>
</div>
<div class="well">
  <table class="table">
    <thead>
      <th><?=\Yii::t('app', 'Название');?></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </thead>
    <tbody>
      <?foreach ($templates as $template):?>
        <?/* @var \mail\models\Template $template */?>
        <tr>
          <td><a href="<?=$this->createUrl('/mail/admin/template/edit', ['templateId' => $template->Id]);?>"><?=$template->Title;?></a></td>
          <td>
            <?if ($template->Active):?>
              <span class="label label-success"><?=\Yii::t('app', 'Запущена');?> <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm', $template->ActivateTime);?></span>
            <?else:?>
              <span class="label"><?=\Yii::t('app', 'В ожидании запуска');?></span>
            <?endif;?>
          </td>
          <td>
            <?if ($template->Success):?>
              <span class="label label-success"><?=\Yii::t('app', 'Выполнена');?> <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm', $template->SuccessTime);?></span>
            <?else:?>
              <span class="label"><?=\Yii::t('app', 'Не выполнена');?></span>
            <?endif;?>
          </td>
          <td><a href="<?=$this->createUrl('/mail/admin/template/edit', ['templateId' => $template->Id]);?>" class="btn"><?=\Yii::t('app', 'Редактировать');?></a></td>
        </tr>
      <?endforeach;?>
    <tbody>
  </table>
  <?$this->widget('\application\widgets\Paginator', ['paginator' => $paginator]);?>
</div>
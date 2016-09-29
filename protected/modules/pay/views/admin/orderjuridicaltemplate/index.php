<?php
/**
 *  @var \pay\models\OrderJuridicalTemplate[] $templates
 *  @var \application\components\utility\Paginator $paginator
 */
?>

<div class="btn-toolbar">
  <a href="<?=$this->createUrl('/pay/admin/orderjuridicaltemplate/edit')?>" class="btn btn-success"><?=\Yii::t('app', 'Создать новый шаблон')?></a>
</div>
<div class="well">
  <table class="table">
    <thead>
      <th><?=\Yii::t('app', 'Название')?></th>
      <th><?=\Yii::t('app', 'Дата создания')?></th>
      <th></th>
    </thead>
    <tbody>
    <?foreach($templates as $template):?>
      <tr>
        <td><a href="<?=$this->createUrl('/pay/admin/orderjuridicaltemplate/edit', ['templateId' => $template->Id])?>"><?=$template->Title?></a></td>
        <td>
          <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm', $template->CreationTime)?>
        </td>
        <td style="text-align: right;">
          <?if($template->ParentTemplateId == null):?>
            <a href="<?=$this->createUrl('/pay/admin/orderjuridicaltemplate/index', ['copy' => $template->Id])?>" class="btn"><?=\Yii::t('app','Создать копию')?></a>
          <?endif?>
          <a href="<?=$this->createUrl('/pay/admin/orderjuridicaltemplate/edit', ['templateId' => $template->Id])?>" class="btn btn-success"><?=\Yii::t('app', 'Редактировать')?></a>
        </td>
      </tr>
    <?endforeach?>
    </tbody>
  </table>
  <?$this->Widget('\application\widgets\Paginator', ['paginator' => $paginator])?>
</div>
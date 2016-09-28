<?php
/**
 * @var $company \company\models\Company
 */
?>

<div class="well m-top_30">
  <div class="row-fluid">
    <div class="span12">
      <h3>Компании объединены</h3>

      Ссылка на итоговую компанию: <a target="_blank" href="<?=$company->getUrl()?>"><?=$company->Name?></a>
    </div>
  </div>
</div>

<div class="btn-toolbar">
  <a class="btn" href="<?=Yii::app()->createUrl('/company/admin/merge/index')?>">Объединить еще</a>
</div>

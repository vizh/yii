<?php
/**
 * @var $company \company\models\Company
 * @var $companies \company\models\Company[]
 * @var $companyId string
 * @var $companyIdSecond string
 */
?>

<?=\CHtml::beginForm('', 'POST', array('class' => 'form-horizontal'))?>
  <div class="well m-top_30">
    <div class="row-fluid">
      <div class="span12">

        <input id="CompanyIdMain" type="hidden" class="span4" name="CompanyIdMain" value="<?=$companyId?>">
        <input id="CompanyIdSecond" type="hidden" class="span4"  name="CompanyIdSecond" value="<?=$companyIdSecond?>">

        <strong>Основная компания:</strong><br><?=$company->Name?><br><br>

        <strong>Компании-дубли:</strong><br>

        <?foreach($companies as $c):?>
            <?=$c->Name?><br>
        <?endforeach?>
      </div>
    </div>
  </div>

  <div class="btn-toolbar">
    <?=\CHtml::submitButton(\Yii::t('app', 'Продолжить'), array('class' => 'btn', 'name' => 'confirm'))?>
    <a class="btn" href="<?=Yii::app()->createUrl('/company/admin/merge/index')?>">Отмена</a>
  </div>
<?=\CHtml::endForm()?>
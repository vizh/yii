<?
/*
 * @var pay\models\Account[] $accounts
 * @var application\components\utility\Paginator $paginator
 */
?>

<div class="btn-toolbar clearfix">
  <?=\CHtml::form($this->createUrl('/pay/admin/account/index'), 'GET', array('class' => 'form-inline pull-left', 'style' => 'margin-bottom:0;'))?>
    <?=\CHtml::textField('Query', \Yii::app()->request->getParam('Query', ''), array('placeholder' => \Yii::t('app', 'ID или навзание мероприятия'), 'style' => 'margin-right:5px'))?>
    <?=\CHtml::submitButton(\Yii::t('app', 'Искать'), array('class' => 'btn'))?>
  <?=\CHtml::endForm()?>
  <a href="<?=$this->createUrl('/pay/admin/account/edit')?>" class="btn btn-success pull-right"><?=\Yii::t('app', 'Создать аккаунт')?></a>
</div>
<div class="well">
  <table class="table">
    <thead>
      <tr>
        <th><?=\Yii::t('app', 'Мероприятие')?></th>
        <th style="width: 26px;"></th>
      </tr>
    </thead>
    <tbody>
    <?foreach($accounts as $account):?>
    <tr>
      <td><strong><?=$account->Event->Id?></strong>, <?=$account->Event->Title?></td>
      <td>
        <div class="btn-group">
          <a href="<?=$this->createUrl('/pay/admin/account/edit', ['accountId' => $account->Id])?>" class="btn"><i class="icon-edit"></i> <?=\Yii::t('app', 'Редактировать')?></a>
        </div>
      </td>
    </tr>
    <?endforeach?>
    </tbody>
  </table>
</div>
<?$this->widget('application\widgets\Paginator', array(
  'paginator' => $paginator
))?>
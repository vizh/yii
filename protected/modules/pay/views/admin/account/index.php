<?
/*
 * @var pay\models\Account[] $accounts 
 * @var application\components\utility\Paginator $paginator
 */
?>

<div class="btn-toolbar clearfix">
  <?=\CHtml::form($this->createUrl('/pay/admin/account/index'), 'GET', array('class' => 'form-inline pull-left', 'style' => 'margin-bottom:0;'));?>
    <?=\CHtml::textField('Query', \Yii::app()->request->getParam('Query', ''), array('placeholder' => \Yii::t('app', 'ID или навзание мероприятия'), 'style' => 'margin-right:5px'));?>
    <?=\CHtml::submitButton(\Yii::t('app', 'Искать'), array('class' => 'btn'));?>
  <?=\CHtml::endForm();?>
  <a href="<?=$this->createUrl('/pay/admin/account/edit');?>" class="btn btn-success pull-right"><?=\Yii::t('app', 'Создать аккаунт');?></a>
</div>
<div class="well">
  <table class="table">
    <thead>
      <th><?=\Yii::t('app', 'Мероприятие');?></th>
    </thead>
    <tbody>
    <?foreach ($accounts as $account):?>
    <tr>
      <td><?=$account->Event->Title;?></td>
      <td>
        <a href="<?=$this->createUrl('/pay/admin/account/edit', ['accountId' => $account->Id]);?>" class="btn btn-mini"><i class="icon-edit"></i> <?=\Yii::t('app', 'Редактировать');?></a>
      </td>
    </tr>
    <?endforeach;?>
    </tbody>
  </table>
</div>
<?$this->widget('application\widgets\Paginator', array(
  'paginator' => $paginator
));?>
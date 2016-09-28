<?php
/**
 * @var $accounts \partner\models\Account[]
 * @var $paginator \application\widgets\Paginator
 */
?>
<div class="row-fluid">
  <div class="btn-toolbar">
    <?=\CHtml::form($this->createUrl('/partner/admin/account/index'), 'GET', array('class' => 'form-inline'))?>
    <?=\CHtml::textField('Query', \Yii::app()->request->getParam('Query', ''), array('placeholder' => \Yii::t('app', 'ID или навзание мероприятия'), 'style' => 'margin-right:5px'))?>
    <?=\CHtml::submitButton(\Yii::t('app', 'Искать'), array('class' => 'btn'))?>
    <a class="btn btn-success pull-right" href="<?=Yii::app()->createUrl('/partner/admin/account/edit')?>">Создать</a>
    <?=\CHtml::endForm()?>
  </div>
  <div class="well">
    <table class="table">
      <thead>
      <tr>
        <th>Мероприятие</th>
        <th>Роль</th>
        <th>Логин</th>
        <th style="width: 26px;"></th>
      </tr>
      </thead>
      <tbody>
      <?foreach($accounts as $account):?>
        <tr>
          <td>
            <?=$account->Event->Id?>, <?=$account->Event->IdName?>,<br>
            <?=$account->Event->Title?>
          </td>
          <td><?=$account->Role?></td>
          <td><?=$account->Login?></td>
          <td>
            <div class="btn-group">
              <a href="<?=$this->createUrl('/partner/admin/account/edit', array('id' => $account->Id))?>" class="btn"><i class="icon-edit"></i> <?=\Yii::t('app', 'Редактировать')?></a>
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
</div>
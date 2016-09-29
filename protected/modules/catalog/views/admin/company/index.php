<div class="row-fluid">
  <div class="btn-toolbar clearfix" style="margin-bottom: 0;">
      <div class="pull-left">
        <?=\CHtml::form($this->createUrl('/catalog/admin/company/index'), 'GET', array('class' => 'form-inline'))?>
          <?=\CHtml::textField('Query', \Yii::app()->request->getParam('Query', ''), array('style' => 'margin-right:5px'))?>
          <?=\CHtml::submitButton(\Yii::t('app', 'Искать'), array('class' => 'btn'))?>
        <?=\CHtml::endForm()?>
      </div>
      <div class="pull-right">
        <a href="<?=$this->createUrl('/catalog/admin/company/edit')?>" class="btn btn-success"><i class="icon-plus icon-white"></i> <?=\Yii::t('app','Добавить')?></a>
      </div>
    </div>
  </div>
  <div class="well">
    <table class="table">
      <thead>
        <th><?=\Yii::t('app', 'Название')?></th>
        <th><?=\Yii::t('app', 'Логотипы')?></th>
        <th></th>
      </thead>
      <tbody>
      <?foreach($companies as $company):?>
        <tr>
          <td><?=\CHtml::link($company->Title, $this->createUrl('/catalog/admin/company/edit', ['companyId' => $company->Id]))?></td>
          <td>
            <?foreach($company->getLogos() as $logo):?>
              <?=\CHtml::image($logo->get100px(), '', ['width' => 50])?>
            <?endforeach?>
          </td>
          <td style="width: 26px;">
            <?=\CHtml::link(\Yii::t('app','Редактировать'), $this->createUrl('/catalog/admin/company/edit', ['companyId' => $company->Id]), ['class' => 'btn'])?>
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
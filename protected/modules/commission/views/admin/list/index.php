<div class="btn-toolbar">
  <a href="<?=$this->createUrl('/commission/admin/edit/index')?>" class="btn"><i class="icon-plus"></i> <?=\Yii::t('app', 'Добавить комиссию')?></a>
</div>
<div class="well">
  <div class="row-fluid">
    <div class="span12">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Название</th>
            <th>Участников</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?foreach($commissions as $commission):?>
            <tr>
              <td><a href="<?=$this->createUrl('/commission/admin/edit/index', array('commissionId' => $commission->Id))?>"><?=$commission->Title?></a></td>
              <td><?=sizeof($commission->UsersActive)?> чел.</td>
              <td class="text-right">
                <a href="<?=$this->createUrl('/commission/admin/edit/index', array('commissionId' => $commission->Id))?>" class="btn"><i class="icon-edit"></i> <?=\Yii::t('app', 'Редактировать')?></a>
                <a href="<?=$this->createUrl('/commission/admin/user/index', array('commissionId' => $commission->Id))?>" class="btn"><i class="icon-user"></i> <?=\Yii::t('app', 'Участники')?></a>
              </td>
            </tr>
          <?endforeach?>
        </tbody>
      </table>
    </div>
  </div>
</div>
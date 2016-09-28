<div class="row-fluid">
  <div class="btn-toolbar">
    <a href="<?=$this->createUrl('/job/admin/edit/index')?>" class="btn"><?=\Yii::t('app', 'Добавить вакансию')?></a>
  </div>
  <div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>Заголовок</th>
          <th>Компания</th>
          <th>Публ.</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?foreach($jobs as $job):?>
        <tr>
          <td><a href="<?=$this->createUrl('/job/admin/edit/index', array('jobId' => $job->Id))?>"><?=$job->Title?></a></td>
          <td><strong><?=$job->Company->Name?></strong></td>
          <td>
            <?if($job->Visible):?>
              <span class="text-success">Да</span>
            <?else:?>
              <span class="text-error">Нет</span>
            <?endif?>
          </td>
          <td><a href="<?=$this->createUrl('/job/admin/edit/index', array('jobId' => $job->Id))?>" class="btn"><i class="icon-edit"></i></td>
        </tr>
        <?endforeach?>
      </tbody>
    </table>
  </div>
  <?$this->widget('application\widgets\Paginator', array(
    'paginator' => $paginator
  ))?>
</div>
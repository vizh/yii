<?php
/**
 * @var $this DefaultController
 * @var $events \event\models\Event[]
 */
?>
<div class="row-fluid">

  <div class="btn-toolbar">
    <button class="btn btn-primary"><i class="icon-plus icon-white"></i> New User</button>
    <button class="btn">Import</button>
    <button class="btn">Export</button>
    <div class="btn-group">
    </div>
  </div>
  <div class="well">

    <?if(!empty($events)):?>
      <table class="table">
        <thead>
        <tr>
          <th>Код</th>
          <th>Лого</th>
          <th>Название</th>
          <th>Даты проведения</th>
          <th style="width: 26px;"></th>
        </tr>
        </thead>
        <tbody>
        <?foreach($events as $event):?>
          <tr>
            <td><?=$event->IdName?></td>
            <td><img src="<?=$event->getLogo()->getSquare70()?>" alt=""></td>
            <td><?=$event->Title?></td>
            <td>
              <?$this->renderPartial('dates', array('event' => $event))?>
            </td>
            <td>
              <a href="user.html"><i class="icon-pencil"></i></a>
              <a data-toggle="modal" role="button" href="#myModal"><i class="icon-remove"></i></a>
            </td>
          </tr>
        <?endforeach?>
        </tbody>
      </table>
    <?endif?>
  </div>
  <div class="pagination">
    <ul>
      <li><a href="#">Prev</a></li>
      <li><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">4</a></li>
      <li><a href="#">Next</a></li>
    </ul>
  </div>

  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal small hide fade">
    <div class="modal-header">
      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
      <h3 id="myModalLabel">Delete Confirmation</h3>
    </div>
    <div class="modal-body">
      <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
    </div>
    <div class="modal-footer">
      <button aria-hidden="true" data-dismiss="modal" class="btn">Cancel</button>
      <button data-dismiss="modal" class="btn btn-danger">Delete</button>
    </div>
  </div>

</div>
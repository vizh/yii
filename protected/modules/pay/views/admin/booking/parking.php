<?/**
 * @var \pay\controllers\admin\booking\ParkingItem[] $parking
 * @var \pay\models\forms\admin\TmpRifParking $form
 */?>
<div class="btn-toolbar">
<style>
  .content {margin-left: 0;}
  .sidebar-nav {display: none;}
</style>
</div>
<div class="well">
  <?=\CHtml::beginForm();?>
    <div class="alert alert-error hide errorSummary"></div>
    <div class="row-fluid">
      <div class="span3">
        <?=\CHtml::activeTextField($form,'Number',['placeholder' => $form->getAttributeLabel('Number'), 'class' => 'input-block-level', 'style' => 'border: 1px solid #3A87AD;']);?>
      </div>
      <div class="span3">
        <?=\CHtml::activeTextField($form,'Brand',['placeholder' => $form->getAttributeLabel('Brand'), 'class' => 'input-block-level']);?>
      </div>
      <div class="span3">
        <?=\CHtml::activeTextField($form,'Model',['placeholder' => $form->getAttributeLabel('Model'), 'class' => 'input-block-level']);?>
      </div>
      <div class="span3">
        <?=\CHtml::activeDropDownList($form, 'Hotel', $form->getHotelData(), ['class' => 'input-block-level']);?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span3">
        <?=\CHtml::activeDropDownList($form, 'Status', $form->getStatusData(), ['class' => 'input-block-level']);?>
      </div>
      <div class="span3">
        <?=\CHtml::activeTextField($form, 'DateIn', ['class' => 'input-block-level', 'placeholder' => $form->getAttributeLabel('DateIn')]);?>
      </div>
      <div class="span3">
        <?=\CHtml::activeTextField($form, 'DateOut', ['class' => 'input-block-level', 'placeholder' => $form->getAttributeLabel('DateOut')]);?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <?=\CHtml::submitButton(\Yii::t('app', 'Добавить'), ['class' => 'btn btn-success']);?>
      </div>
    </div>
  <?=\CHtml::endForm();?>

  <div class="row-fluid m-top_40">
    <div class="span8">
      <input type="text" value="" placeholder="<?=\Yii::t('app', 'Поиск по номерам автомобилей');?>" class="input-block-level" id="query"/>
    </div>
  </div>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th><?=\Yii::t('app', 'Номер');?></th>
        <th><?=\Yii::t('app', 'Марка и модель');?></th>
        <th><?=\Yii::t('app', 'Статус');?></th>
        <th><?=\Yii::t('app', 'Отель');?></th>
        <th><?=\Yii::t('app', 'Даты');?></th>
      </tr>
    </thead>
    <tbody>
    <?foreach ($parking as $item):?>
      <tr>
        <td><strong style="font-size: 25px;"><?=$item->Number;?></strong></td>
        <td><?=$item->Brand;?> <?=$item->Model;?></td>
        <td>
          <?
          $class = '';
          switch ($item->Status)
          {
            case \pay\controllers\admin\booking\ParkingItem::STATUS_VIP: $class = 'text-warning';
              break;

            case \pay\controllers\admin\booking\ParkingItem::STATUS_REPORTER: $class = 'text-success';
              break;

            case \pay\controllers\admin\booking\ParkingItem::STATUS_ORGANIZER: $class = 'text-error';
              break;
          }
          ?>
          <span class="<?=$class;?>"><?=$item->getStatusTitle();?></span>
        </td>
        <td><?=$item->Hotel;?></td>
        <td>
          <?foreach ($item->Dates as $date):?>
            <span class="label"><?=$date;?></span>
          <?endforeach;?>
        </td>
      </tr>
    <?endforeach;?>
    </tbody>
  </table>
</div>
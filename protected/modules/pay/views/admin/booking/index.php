<?php
/**
 * @var BookingController $this
 * @var \pay\models\forms\admin\BookingSearch $form
 * @var CActiveForm $activeForm
 */
?>

<?if ($form->hasErrors()):?>
  <div class="alert alert-error">
    <?=\CHtml::errorSummary($form)?>
  </div>
<?endif?>

<? $activeForm = $this->beginWidget('CActiveForm', [
  'htmlOptions' => [
    'class' => 'form-horizontal'
  ]
]) ?>

  <div class="well m-top_30">
    <div class="well well-small">
      <h4 class="text-center">Размещение</h4>
      <div class="row-fluid">
        <div class="span12">
          <?foreach (['Hotel', 'Housing'] as $attribute):?>
            <div class="control-group">
              <?=$activeForm->labelEx($form, $attribute, ['class' => 'control-label'])?>
              <div class="controls">
                <? $this->widget('\application\widgets\GroupBtnSelect', [
                  'values' => $form->getAttributeValues($attribute),
                  'model' => $form,
                  'attribute' => $attribute
                ])?>
              </div>
            </div>
          <?endforeach?>
        </div>
      </div>

      <div class="row-fluid">
        <div class="span12">
          <div class="control-group">
            <?=$activeForm->labelEx($form, $attribute, ['class' => 'control-label'])?>
            <div class="controls">
              <?=$activeForm->listBox($form, 'Category', $form->getAttributeValues('Category'), ['class' => 'span8', 'multiple' => 'multiple'])?>
            </div>
          </div>
        </div>
      </div>

      <div class="row-fluid">
        <?foreach (['RoomCount', 'PlaceTotal'] as $attribute):?>
          <div class="span5">
              <div class="control-group">
                <?=$activeForm->labelEx($form, $attribute, ['class' => 'control-label'])?>
                <div class="controls">
                  <? $this->widget('\application\widgets\GroupBtnSelect', [
                    'values' => $form->getAttributeValues($attribute),
                    'model' => $form,
                    'attribute' => $attribute
                  ])?>
                </div>
              </div>
          </div>
        <?endforeach?>
      </div>
    </div>

    <div class="well well-small">
      <h4 class="text-center">Даты размещения</h4>
      <div class="row-fluid">
        <div class="span4">

          <div class="control-group">
            <?=$activeForm->labelEx($form, 'DateIn', ['class' => 'control-label'])?>
            <div class="controls">
              <?=$activeForm->dropDownList($form, 'DateIn', $form->getAttributeValues('DateIn'), ['class' => 'span12', 'prompt' => ''])?>
            </div>
          </div>
        </div>
        <div class="span4">
          <div class="control-group">
            <?=$activeForm->labelEx($form, 'DateOut', ['class' => 'control-label'])?>
            <div class="controls">
              <?=$activeForm->dropDownList($form, 'DateOut', $form->getAttributeValues('DateOut'), ['class' => 'span12', 'prompt' => ''])?>
            </div>
          </div>
        </div>
        <div class="span4">
          <label class="checkbox">
            <?=$activeForm->checkbox($form, 'NotFree')?> <?=$form->getAttributeLabel('NotFree')?>
          </label>
        </div>
      </div>
    </div>

    <div class="row-fluid">
      <div class="span12">
        <div class="btn-toolbar text-center">
          <?=\CHtml::submitButton('Поиск', ['class' => 'btn btn-large'])?>
        </div>
      </div>
    </div>
  </div>
<? $this->endWidget() ?>

<table id="rooms" class="table table-bordered">
  <thead>
    <tr>
      <th rowspan="2">#</th>
      <th rowspan="2">Пансионат</th>
      <th rowspan="2">Корпус</th>
      <th rowspan="2">№</th>
      <th rowspan="2">Число комнат</th>
      <th rowspan="2">Места</th>
      <th colspan="4">Бронирование</th>
      <th rowspan="2">Цена</th>
      <th rowspan="2">&nbsp;</th>
    </tr>
    <tr>
      <?foreach (\pay\models\forms\admin\BookingSearch::getDateRanges() as $startDate => $endDate):?>
        <th><?=(new \DateTime($startDate))->format('d').'-'.(new \DateTime($endDate))->format('d')?></th>
      <?endforeach?>
      <th>Доп.</th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($rooms as $room): ?>
      <?$dates = $room['Dates']?>
      <tr <?=$room['Visible'] == 0 ? 'class="hidden-room"' : ($room['Visible'] == -1 ? 'class="exclude-room"' : '');?>>
        <td style="font-size: 10px;"><a href="<?=$this->createUrl('/pay/admin/booking/product', ['productId' => $room['Id'], 'backUrl' => \Yii::app()->getRequest()->getUrl()]);?>"><?=$room['TechnicalNumber']?></a></td>
        <td><?=$room['Hotel']?></td>
        <td><?=$room['Housing']?></td>
        <td><span class="label label-info"><?=$room['Number']?></span></td>
        <td>
          <span class="label label-error"><?=$room['RoomCount']?></span><br/>Категория: <?=$room['Category']?>
        </td>
        <td>
          Всего: <span class="label label-important"><?=$room['PlaceTotal']?></span>;<br/>
          Основных: <?=$room['DescriptionBasic']?>;<br/>
          Доп.: <?=$room['DescriptionMore']?>;
        </td>
        <?foreach (\pay\models\forms\admin\BookingSearch::getDateRanges() as $startDate => $endDate):
            $key = $startDate.'-'.$endDate;
          ?>
          <td <?=isset($dates[$key]) && count($dates[$key]) > 1 ? 'style="background-color: #f2dede;"' : '';?>>
            <?if (isset($dates[$key])):?>
              <?foreach ($dates[$key] as $dateData):?>
                <?if ($dateData['RunetId'] != null):?>
                  <?=$dateData['RunetId'];?><br>
                <?endif;?>
                <?=$dateData['Name'];?><br>
                <?if ($dateData['Paid']):?>
                  <span style="font-weight: normal;" class="label label-success">Оплачен</span>
                <?elseif (!empty($dateData['Booked'])):?>
                  <span style="font-weight: normal;" class="label label-warning">до <?=Yii::app()->getDateFormatter()->format('dd.MM H:m', $dateData['Booked']);?></span>
                <?else:?>
                  <span style="font-weight: normal;" class="label label-warning">Не оплачен</span>
                <?endif;?><br>
              <?endforeach;?>
            <?endif;?>
          </td>
        <?endforeach?>
        <td>
          <?if ($dates['other']):?>
            <span style="font-weight: normal;" class="label label-important">Да</span>
          <?endif;?>
        </td>
        <td><span class="label label-success"><?=$room['Price']?>&nbsp;р.</span></td>
        <td><a href="<?=Yii::app()->createUrl('/pay/admin/booking/edit', ['productId' => $room['Id']]);?>" class="btn btn-info"><i class="icon-edit icon-white"></i></a></td>
      </tr>
    <? endforeach ?>
  </tbody>
</table>
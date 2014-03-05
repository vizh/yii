<?php
/*
 * @var BookingController $this
 * @var \CActiveForm $activeForm
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
          <?foreach (['Hotel', 'Housing', 'PlaceBasic', 'PlaceMore', 'PlaceTotal', 'RoomCount'] as $attribute):?>
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
        <?$attributes = array_keys($form->getAttributes([
          'Category',
          'DescriptionBasic',
          'DescriptionMore',
        ]))?>
        <?$div2 = ceil(count($attributes) / 2)?>
        <div class="span6">
          <? for ($i = 0; $i < $div2; ++$i): ?>
            <?$attribute = $attributes[$i]?>
            <div class="control-group">
              <?=$activeForm->labelEx($form, $attribute, ['class' => 'control-label'])?>
              <div class="controls">
                <?=$activeForm->dropDownList($form, $attribute, $form->getAttributeValues($attribute), ['class' => 'span12', 'prompt' => ''])?>
              </div>
            </div>
          <? endfor ?>
        </div>

        <div class="span6">
          <? for ($i = $div2; $i < count($attributes); ++$i): ?>
            <?$attribute = $attributes[$i]?>
            <div class="control-group">
              <?=$activeForm->labelEx($form, $attribute, ['class' => 'control-label'])?>
              <div class="controls">
                <?=$activeForm->dropDownList($form, $attribute, $form->getAttributeValues($attribute), ['class' => 'span12', 'prompt' => ''])?>
              </div>
            </div>
          <? endfor ?>
        </div>
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
      <th rowspan="2">Технический номер</th>
      <th rowspan="2">Отель</th>
      <th rowspan="2">Корпус</th>
      <th rowspan="2">Номер</th>
      <th rowspan="2">Категория</th>
      <th rowspan="2">Число комнат</th>
      <th rowspan="2">Евро-ремонт</th>
      <th colspan="3">Места</th>
      <th colspan="4">Бронирование</th>
      <th rowspan="2">Цена</th>
    </tr>
    <tr>
      <th>Всего</th>
      <th>Основных</th>
      <th>Дополнительных</th>
      <?foreach (\pay\models\forms\admin\BookingSearch::getDateRanges() as $startDate => $endDate):?>
        <th><?=$startDate.'-'.$endDate?></th>
      <?endforeach?>
      <th>Доп.</th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($rooms as $room): ?>
      <?$dates = $room['Dates']?>
      <tr>
        <td><?=$room['TechnicalNumber']?><br/><?=!$room['Visible'] ? '<span class="label">Скрытый номер</span>' : ''?></td>
        <td><?=$room['Hotel']?></td>
        <td><?=$room['Housing']?></td>
        <td><span class="label label-info"><?=$room['Number']?></span></td>
        <td><?=$room['Category']?></td>
        <td><span class="label label-important"><?=$room['RoomCount']?></span></td>
        <td><?=$room['EuroRenovation']?></td>
        <td><span class="label label-warning"><?=$room['PlaceTotal']?></span></td>
        <td><?=$room['PlaceBasic']?><br/><?=$room['DescriptionBasic']?></td>
        <td><?=$room['PlaceMore']?><br/><?=$room['DescriptionMore']?></td>
        <?foreach (\pay\models\forms\admin\BookingSearch::getDateRanges() as $startDate => $endDate):?>
          <td><?=isset($dates[$startDate.'-'.$endDate]) ? $dates[$startDate.'-'.$endDate]['UserId'].'<br/>'.$dates[$startDate.'-'.$endDate]['Name'] : ''?></td>
        <?endforeach?>
        <td></td>
        <td><span class="label label-success"><?=$room['Price']?>&nbsp;р.</span></td>
      </tr>
    <? endforeach ?>
  </tbody>
</table>
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
      <tr <?=!$room['Visible'] ? 'class="hidden-room"' : ''?>>
        <td style="font-size: 10px;"><?=$room['TechnicalNumber']?></td>
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
        <?foreach (\pay\models\forms\admin\BookingSearch::getDateRanges() as $startDate => $endDate):?>
          <td><?=isset($dates[$startDate.'-'.$endDate]) ? $dates[$startDate.'-'.$endDate]['UserId'].'<br/>'.$dates[$startDate.'-'.$endDate]['Name'] : ''?></td>
        <?endforeach?>
        <td></td>
        <td><span class="label label-success"><?=$room['Price']?>&nbsp;р.</span></td>
      </tr>
    <? endforeach ?>
  </tbody>
</table>
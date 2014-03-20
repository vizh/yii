<?php
/**
 * @var \pay\models\Product $product
 * @var \pay\models\RoomPartnerBooking[] $partnerBooking
 * @var \pay\models\forms\admin\PartnerBooking $formNewPartner
 * @var string[] $partnerNames
 * @var CFormModel[] $partnerErrorForms
 * @var \pay\models\OrderItem[] $orderItems
 * @var \pay\models\forms\admin\UserBooking $formNewUser
 * @var \pay\models\forms\admin\UserBooking[] $userErrorForms
 * @var \pay\components\managers\RoomProductManager $manager
 */
$manager = $product->getManager();
?>

<script type="text/javascript">
  var partnerNames = ["<?=implode('","', $partnerNames);?>"];
</script>

<?if ($formNewPartner->hasErrors()):?>
  <div class="alert alert-error">
    <?=\CHtml::errorSummary($formNewPartner)?>
  </div>
<?endif?>

<?if (!empty($partnerErrorForms)):?>
  <div class="alert alert-error">
    <?=\CHtml::errorSummary($partnerErrorForms)?>
  </div>
<?endif;?>

<?if (!empty($userErrorForms)):?>
  <div class="alert alert-error">
    <?=\CHtml::errorSummary($userErrorForms)?>
  </div>
<?endif;?>

  <div class="btn-toolbar">
    <a href="<?=Yii::app()->createUrl('/pay/admin/booking/index');?>" class="btn"><span class="icon-arrow-left"></span> Назад</a>
  </div>

  <div class="well">

    <h3><?=$manager->Hotel;?>, <?=$manager->Housing;?>, №<?=$manager->Number;?></h3>
    <p>
      Категория: <em><?=$manager->Category;?></em><br>
      Число комнат: <span class="label"><?=$manager->RoomCount;?></span><br>
      Число основных мест: <span class="label label-important"><?=$manager->PlaceBasic;?></span><br>
      Число доп. мест: <span class="label label-info"><?=$manager->PlaceMore;?></span><br>
      Основные места:  <em><?=$manager->DescriptionBasic;?></em>; дополнительные места: <em><?=$manager->DescriptionMore;?></em><br>
      Цена за сутки: <span class="label label-success"><?=$manager->Price;?> руб.</span><br>
      Цена за доп. место: <span class="label label-success"><?=$manager->AdditionalPrice;?> руб.</span><br>
    </p>


    <h4>Партнеры</h4>
    <table class="table">
      <thead>
      <tr>
        <th class="span5">Название</th>
        <th>Дата заезда</th>
        <th>Дата выезда</th>
        <th>Количество доп. мест</th>
        <th>&nbsp;</th>
      </tr>
      </thead>
      <tbody>
      <?=CHtml::beginForm();?>
      <?foreach ($partnerBooking as $booking):?>
        <tr>
          <td><a href="<?=Yii::app()->createUrl('/pay/admin/booking/partner', ['owner' => $booking->Owner])?>"><?=$booking->Owner;?></a></td>
          <?if (!$booking->Paid):?>
            <td><?=CHtml::textField('partnerData['.$booking->Id.'][DateIn]', $booking->DateIn, ['class' => 'span2 date-in']);?></td>
            <td><?=CHtml::textField('partnerData['.$booking->Id.'][DateOut]', $booking->DateOut, ['class' => 'span2 date-out']);?></td>
            <td><?=CHtml::textField('partnerData['.$booking->Id.'][AdditionalCount]', $booking->AdditionalCount, ['class' => 'span1']);?></td>
            <td><a class="btn btn-danger booking-delete" href="<?=Yii::app()->createUrl('/pay/admin/booking/delete', ['type' => 'partner', 'id' => $booking->Id]);?>"><i class="icon-remove icon-white"></i></a></td>
          <?else:?>
            <td><?=$booking->DateIn;?></td>
            <td><?=$booking->DateOut;?></td>
            <td><?=$booking->AdditionalCount;?></td>
            <td><span class="label label-success">Оплачен</span></td>
          <?endif;?>
        </tr>
      <?endforeach;?>

      <?if (!empty($partnerBooking)):?>
      <tr>
        <td colspan="5"><input type="submit" class="btn btn-success" value="Сохранить" name="savePartners"></td>
      </tr>
      <?endif;?>

      <?=CHtml::endForm();?>

      <?=CHtml::beginForm();?>
      <tr>
        <td><?=CHtml::textField('partnerNewData[Owner]', $formNewPartner->Owner, ['class' => 'span4 partnerName']);?></td>
        <td><?=CHtml::textField('partnerNewData[DateIn]', $formNewPartner->DateIn, ['class' => 'span2 date-in']);?></td>
        <td><?=CHtml::textField('partnerNewData[DateOut]', $formNewPartner->DateOut, ['class' => 'span2 date-out']);?></td>
        <td><?=CHtml::textField('partnerNewData[AdditionalCount]', $formNewPartner->AdditionalCount, ['class' => 'span1']);?></td>
        <td><button class="btn" type="submit" name="createPartner" value="1"><i class="icon-plus"></i></button></td>
      </tr>
      <?=CHtml::endForm();?>
      </tbody>
    </table>



    <h4>Участники</h4>


    <table class="table">
      <thead>
      <tr>
        <th class="span5">RUNET-ID, ФИО</th>
        <th>Дата заезда</th>
        <th>Дата выезда</th>
        <th>Бронь до</th>
        <th>&nbsp;</th>
      </tr>
      </thead>
      <tbody>


      <?=CHtml::beginForm();?>
      <?foreach ($orderItems as $item):?>
        <tr>
          <td><?=$item->Payer->RunetId;?>, <?=$item->Payer->getFullName();?></td>
          <?if (!$item->Paid):?>
            <td><?=CHtml::textField('userData['.$item->Id.'][DateIn]', $item->getItemAttribute('DateIn'), ['class' => 'span2 date-in']);?></td>
            <td><?=CHtml::textField('userData['.$item->Id.'][DateOut]', $item->getItemAttribute('DateOut'), ['class' => 'span2 date-out']);?></td>
            <td><?=CHtml::textField('userData['.$item->Id.'][Booked]', date('Y-m-d', strtotime($item->Booked)), ['class' => 'span2 date-booked']);?></td>
            <td><a class="btn btn-danger booking-delete" href="<?=Yii::app()->createUrl('/pay/admin/booking/delete', ['type' => 'user', 'id' => $item->Id]);?>"><i class="icon-remove icon-white"></i></a></td>
          <?else:?>
            <td><?=$item->getItemAttribute('DateIn');?></td>
            <td><?=$item->getItemAttribute('DateOut');?></td>
            <td><span class="label label-success">Оплачен</span></td>
            <td></td>
          <?endif;?>
        </tr>
      <?endforeach;?>

      <?if (!empty($orderItems)):?>
      <tr>
        <td colspan="5"><input type="submit" class="btn btn-success" value="Сохранить" name="saveUsers"></td>
      </tr>
      <?endif;?>

      <?=CHtml::endForm();?>

      <?=CHtml::beginForm();?>
      <tr>
        <td>
          <?$this->widget('\application\widgets\AutocompleteInput', [
            'field' => 'userNewData[RunetId]',
            'source' => '/user/ajax/search/',
            'addOn' => 'RUNET-ID',
            'class' => '\user\models\User',
            'adminMode' => true
          ]);?>
        </td>
        <td>
          <?=CHtml::textField('userNewData[DateIn]', $formNewUser->DateIn, ['class' => 'span2 date-in']);?>
        </td>
        <td>
          <?=CHtml::textField('userNewData[DateOut]', $formNewUser->DateOut, ['class' => 'span2 date-out']);?>
        </td>
        <td>
          <?=CHtml::textField('userNewData[Booked]', $formNewUser->Booked, ['class' => 'span2 date-booked']);?>
        </td>
        <td>
          <button class="btn" type="submit" name="createUser" value="1"><i class="icon-plus"></i></button>
        </td>
      </tr>
      <?=CHtml::endForm();?>



      </tbody>

    </table>



  </div>

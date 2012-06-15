<div class="span16">
  <h2>Введите номер счета</h2>

  <form class="form-stacked" action="" method="post">
    <input type="hidden" name="step" value="1">
    <fieldset>
      <div class="clearfix">
        <div class="input">
          <input type="text" size="30" name="orderId" id="orderId" class="span5">
        </div>
      </div>
    </fieldset>

    <fieldset>
      <div class="clearfix">
        <input type="submit"  value="Продолжить" class="btn primary">
      </div>
    </fieldset>
  </form>

  <table>
    <tr>
      <th>Номер счета</th>
      <th>ФИО</th>
      <th>Email</th>
      <th>Дата окончания брони</th>
    </tr>
    <?foreach ($this->List as $item):
    /** @var $payer User */
    $payer = $item['order']->Payer;
    ?>
    <tr>
      <td><?=$item['order']->OrderId;?></td>
      <td><?=$payer->LastName;?> <?=$payer->FirstName;?> <?=$payer->FatherName;?></td>
      <td><?=!empty($payer->Emails) ? $payer->Emails[0]->Email : $payer->Email;?></td>
      <td style="font-size: 115%;"><?=date('d.m.Y H:i', strtotime($item['min']));?></td>
    </tr>
    <?endforeach;?>
  </table>
</div>
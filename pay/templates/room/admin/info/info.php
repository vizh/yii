<div class="row">
  <div class="span16">
    <h1>Выборка информации по номерному фонду на РИФ+КИБ</h1>
  </div>

  <div class="span16">


    <?foreach ($this->Full as $full):
     $hotel = $full['Value'];
    ?>
    <h2><?=$hotel;?></h2>

    <table class="bordered-table room-statistics">
      <thead>
      <tr>
        <th>&nbsp;</th>
        <th colspan="3">Забронировано</th>
        <th colspan="3">Куплено</th>
        <th>Всего</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td>&nbsp;</td>
        <td>17-18 апреля</td>
        <td>18-19 апреля</td>
        <td>19-20 апреля</td>
        <td>17-18 апреля</td>
        <td>18-19 апреля</td>
        <td>19-20 апреля</td>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td>
          Количество номеров
        </td>
        <?foreach ($this->Dates as $date):?>
        <td><?=$this->Result[$hotel][$date]['Booked'];?></td>
        <?endforeach;?>
        <?foreach ($this->Dates as $date):?>
        <td><?=$this->Result[$hotel][$date]['Sale'];?></td>
        <?endforeach;?>
        <td><?=$full['cp'];?></td>
      </tr>
      <tr>
        <td>Сумма платежей</td>
        <?
        $totalBooked = 0;
        foreach ($this->Dates as $date):
          $totalBooked += $this->Result[$hotel][$date]['PriceBooked'];
        ?>
        <td><?=number_format($this->Result[$hotel][$date]['PriceBooked'], 0, ',', ' ');?>&nbsp;руб.</td>
        <?endforeach;?>
        <?
        $totalSale = 0;
        foreach ($this->Dates as $date):
          $totalSale += $this->Result[$hotel][$date]['PriceSale'];
          ?>
        <td><?=number_format($this->Result[$hotel][$date]['PriceSale'], 0, ',', ' ');?>&nbsp;руб.</td>
        <?endforeach;?>
        <td>
          <?=number_format($totalBooked, 0, ',', ' ');?> + <?=number_format($totalSale, 0, ',', ' ');?><br><br>
          <strong><?=number_format($totalBooked+$totalSale, 0, ',', ' ');?>&nbsp;руб.</strong>
        </td>
      </tr>



      </tbody>


    </table>
    <?endforeach;?>
  </div>


</div>
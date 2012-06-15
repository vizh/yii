<h3><?=$this->Title;?></h3>

<table class="bordered-table">
  <tr>
    <th>Скидка</th>
    <th>Сумма оплат физ. лиц</th>
    <th>Сумма оплат юр. лиц</th>
    <th>Всего</th>
  </tr>

  <?foreach ($this->ResultKeys as $key): if ($key === 'all') {continue;}?>
  <tr>
    <td><?=$key?> %</td>
    <td><h4><?=number_format($this->Result[$key]['physical']['total'], 0, ',', ' ');?></h4> (<?=$this->Result[$key]['physical']['count'];?> шт.)</td>
    <td><h4><?=number_format($this->Result[$key]['juridical']['total'], 0, ',', ' ');?></h4> (<?=$this->Result[$key]['juridical']['count'];?> шт.)</td>
    <td><h4><?=number_format($this->Result[$key]['physical']['total'] + $this->Result[$key]['juridical']['total'], 0, ',', ' ');?></h4> (<?=$this->Result[$key]['physical']['count'] + $this->Result[$key]['juridical']['count'];?> шт.)</td>
  </tr>
  <?endforeach;?>
  <tr>
    <td><h3>Всего</h3></td>
    <td><h4><?=number_format($this->Result['all']['physical']['total'], 0, ',', ' ');?></h4> (<?=$this->Result['all']['physical']['count'];?> шт.)</td>
    <td><h4><?=number_format($this->Result['all']['juridical']['total'], 0, ',', ' ');?></h4> (<?=$this->Result['all']['juridical']['count'];?> шт.)</td>
    <td><h4><?=number_format($this->Result['all']['physical']['total'] + $this->Result['all']['juridical']['total'], 0, ',', ' ');?></h4> (<?=$this->Result['all']['physical']['count'] + $this->Result['all']['juridical']['count'];?> шт.)</td>
  </tr>

</table>
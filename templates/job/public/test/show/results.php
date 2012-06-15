<div class="additional_info">
  <h3>Прошлые результаты</h3>
  <table>
    <?foreach ($this->Results as $result):?>
      <tr>
        <td><?=strftime('%d %B %Y', strtotime($result->EndTime));?></td>
        <td><?=$result->Result;?> <?=Texts::GetRightFormByCount($result->Result, 'балл', 'балла', 'баллов');?></td>
        <td><?=$result->Percents;?> %</td>
        <?if($this->HavePassArray):?>
        <td><?=$result->ResultDescription;?></td>
        <?endif;?>
      </tr>
    <?endforeach;?>
  </table>
</div>
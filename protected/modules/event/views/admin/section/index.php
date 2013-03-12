<table class="table table-bordered">
  <thead>
    <tr>
      <th></th>
      <?foreach ($event->Halls as $hall):?>
      <th><?=$hall->Title;?></th>
      <?endforeach; ?>
    </tr>
  </thead>
  
  <?php 
  $datetime = new \DateTime();
  $datetime->setTime(9, 0);
  ?>
  <tbody>
    <?for($t = (9*60*60); $t <= (21*60*60); $t += (15*60)):?>
    <tr>
      <td class="text-right"><?=gmdate('H:i', $t);?></td>
      <?foreach($event->Halls as $hall):?>
        <td id="<?=$this->getCellId($hall, gmdate('H-i', $t));?>"></td>
      <?endforeach;?>
    </tr>
    <?endfor;?>
  </tbody>
</table>

<script type="text/javascript">
  $(function () {
  <?foreach ($event->Sections as $section):?>
    <?php 
      $halls = $section->LinkHalls;
      $startTime = date('H-i', strtotime($section->StartTime));
      $endTime = date('H-i', strtotime($section->EndTime));
    ?>
    SectionGrid.addSection('<?=$section->Title;?>', '', '<?=$this->getCellId($halls[0]->Hall, $startTime);?>', '<?=$this->getCellId($halls[sizeof($halls)-1]->Hall, $endTime);?>');
  <?endforeach;?>
  });
</script>
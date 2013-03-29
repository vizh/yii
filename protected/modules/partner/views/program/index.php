<div class="row">
  <div class="span10">
    <ul class="nav nav-pills">
      <?php
      $dt = new \DateTime();
      $dt->setTimestamp($event->getTimeStampStartDate());
      ?>
      <?while($dt->getTimestamp() <= $event->getTimeStampEndDate()):?>
        <li <?if ($date == $dt->format('Y-m-d')):?>class="active"<?endif;?>>
          <a href="<?=$this->createUrl('/partner/program/index', array('date' => $dt->format('Y-m-d')));?>"><?=\Yii::app()->dateFormatter->format('dd MMMM yyyy', $dt->getTimestamp());?></a>
        </li>
        <?$dt->modify('+1 day');?>
      <?endwhile;?>
    </ul>
  </div>
  <div class="span2">
    <a href="<?=$this->createUrl('/partner/program/section');?>" class="btn btn-info pull-right"><?=\Yii::t('app', 'Новая секция');?></a>
  </div>
</div>

<?if (!empty($event->Halls)):?>
<div class="row" id="program-grid">
  <div class="span12">
    <table class="table table-striped">
      <thead>
        <tr>
          <th></th>
          <?php $row = '';?>
          <?foreach ($event->Halls as $hall):?>
            <th><?=$hall->Title;?></th>
            <?php $row .= '<td data-hall-id="'.$hall->Id.'"></td>';?>
          <?endforeach;?>
        </tr>
      </thead>
      <tbody>
        <?for($t = 28800; $t <= (21*60*60); $t+=(15*60)):?>
          <tr>
            <td data-time="<?=gmdate('H:i', $t);?>"><?=gmdate('H:i', $t);?></td>
            <?=$row;?>
          </tr>
        <?endfor;?>
      </tbody>
    </table>
  </div>
  
  <?foreach($sections as $section):?>
  <?php
    $timeStart = \Yii::app()->dateFormatter->format('HH:mm', $section->StartTime);
    $timeEnd = \Yii::app()->dateFormatter->format('HH:mm', $section->EndTime);
    $hallStart = $section->LinkHalls[0]->Hall->Id;
    $hallEnd = $section->LinkHalls[sizeof($section->LinkHalls)-1]->Hall->Id;
  ?>
  <div data-hall-start="<?=$hallStart;?>" data-hall-end="<?=$hallEnd;?>" data-time-start="<?=$timeStart;?>" data-time-end="<?=$timeEnd;?>" class="section alert alert-info">
    <a href="<?=$this->createUrl('/partner/program/section', array('sectionId' => $section->Id));?>"><?=$section->Title;?></a>
  </div>
  <?endforeach;?>
  <?else:?>
    <div class="alert alert-error">
      <?=\Yii::t('app', 'Для появления программной сетки, начните добавлять секции.');?>
    </div>
  <?endif;?>
</div>

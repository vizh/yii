<?php
/**
 * @var $roles \event\models\Role[]
 * @var $statistics array
 * @var $event \event\models\Event
 * @var $this MainController
 * @var $timeSteps array
 */
?>

<div class="row">
  <div class="span12">
    <h2 class="indent-bottom1">Участники</h2>

    <div id="chart-registrations-all"></div>
    <div id="chart-payments"></div>

    <table class="table">
      <thead>
      <tr>
        <th>Роль</th>
        <?foreach ($timeSteps as $key => $time):?>
          <th><?=$key;?></th>
        <?endforeach;?>
      </tr>
      </thead>
      <tbody>

      <?foreach ($roles as $role):?>
        <tr>
          <td><?=$role->Title;?></td>
          <?foreach ($timeSteps as $key => $time):?>
            <td><?=isset($statistics[$key][$role->Id]) ? $statistics[$key][$role->Id] : 0;?></td>
          <?endforeach;?>
        </tr>
      <?endforeach;?>

      <tr>
        <td><strong>Всего:</strong></td>
        <?foreach ($timeSteps as $key => $time):?>
          <td><?=$statistics[$key]['Total'];?></td>
        <?endforeach;?>
      </tr>
      </tbody>
    </table>

    <?if (sizeof($event->Parts) > 0):?>
      <?$this->renderPartial('index/parts', [
        'statistics' => $statistics,
        'event' => $event,
        'timeSteps' => $timeSteps
      ]);?>
    <?endif;?>
  </div>
</div>

<script>
  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(drawChartPayments);
  google.setOnLoadCallback(drawChartRegistrationsAll);

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function drawChartPayments() {
    var data = google.visualization.arrayToDataTable([
      ['Участники', 'Проф. участники', 'СМИ', 'Другое', { role: 'style' } ],
      ['Оплатили', 10, 24, 20, 32],
      ['Не оплатили', 16, 22, 23, 30],
      ['Другое', 1, 22, 2, 30]
    ]);

    var options = {
      height: 400,
      legend: { position: 'top', maxLines: 3 },
      chartArea: {left: 30, top: 40, width: '100%', height: '80%'},
      bar: { groupWidth: '75%' },
      isStacked: true
    };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.ColumnChart(document.getElementById('chart-payments'));
    chart.draw(data, options);
  }

  function drawChartRegistrationsAll() {
    var data = google.visualization.arrayToDataTable([
      <?
        $curData = current($statRegistrationsByRoles);
        $rolesKeys = !empty($curData) ? $curData : [];
      ?>
      ['Общее число регистраций', '<?=implode("','", array_keys($rolesKeys))?>'],
      <? foreach ($statRegistrationsByRoles as $date => $v): ?>
        <?="['$date', ".implode(',', $v)."],"?>
      <? endforeach ?>
      <? if (empty($statRegistrationsByRoles)): ?>
        []
      <? endif ?>
    ]);

    var options = {
      height: 400,
      chartArea: {left: 50, top: 50, width: '100%', height: '80%'},
      title: 'Общее число регистраций за весь период',
      legend: { position: 'top' },
      isStacked: true
    };

    var chart = new google.visualization.SteppedAreaChart(document.getElementById('chart-registrations-all'));
    chart.draw(data, options);
  }
</script>

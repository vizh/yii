<?php
/**
 * @var \event\models\Role[] $roles
 * @var \event\models\Event $event
 * @var MainController $this
 * @var \event\components\Statistics $statistics
 * @var array $timeSteps
 * @var array $textStatistics
 */


$this->setPageTitle('Партнерский интерфейс');
$this->initActiveBottomMenu('index');
$statRegistrationsByRoles = $statistics->getRegistrationsAll();
$statRegistrationDeltaByRoles = $statistics->getRegistrationsDelta();
?>
<script type="text/javascript">
  partnerStatistics = new CParnerStatistics();
  partnerStatistics.Dates = <?=json_encode($statistics->getDates(), JSON_UNESCAPED_UNICODE);?>;
  partnerStatistics.RegistrationsAll = <?=json_encode($statistics->getRegistrationsAll(), JSON_UNESCAPED_UNICODE)?>;
  partnerStatistics.RegistrationsDelta = <?=json_encode($statistics->getRegistrationsDelta(), JSON_UNESCAPED_UNICODE)?>;
  partnerStatistics.Payments = <?=json_encode($statistics->getPayments(), JSON_UNESCAPED_UNICODE)?>;
  partnerStatistics.Count = <?=json_encode($statistics->getCount(), JSON_UNESCAPED_UNICODE)?>;
  partnerStatistics.Roles = <?=json_encode($statistics->getRolesTitle(), JSON_UNESCAPED_UNICODE);?>;

  google.setOnLoadCallback(function() {
    $(function() {
      partnerStatistics.init();
    });
  });
</script>

<div class="row">
  <div class="span12">
    <h3 class="indent-bottom1">Текстовые данные</h3>

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
            <td><?=isset($textStatistics[$key][$role->Id]) ? $textStatistics[$key][$role->Id] : 0;?></td>
          <?endforeach;?>
        </tr>
      <?endforeach;?>

      <tr>
        <td><strong>Всего:</strong></td>
        <?foreach ($timeSteps as $key => $time):?>
          <td><?=$textStatistics[$key]['Total'];?></td>
        <?endforeach;?>
      </tr>
      </tbody>
    </table>

    <?if (sizeof($event->Parts) > 0):?>
      <?$this->renderPartial('index/parts', [
        'statistics' => $textStatistics,
        'event' => $event,
        'timeSteps' => $timeSteps
      ]);?>
    <?endif;?>
  </div>
</div>

<div class="row">
  <div class="span12">

    <h3>Диапазон выборки</h3>
    <div id="datesSlider" class="indent-bottom1"></div>
    <div id="datesRange" class="indent-bottom2"><strong>Выборка за:</strong> <span></span></div>

    <h3 class="m-top_30">Общее количество регистраций</h3>
    <div id="chart-registrations-all"></div>

    <h3 class="m-top_30">Количество регистраций по дням</h3>
    <div id="chart-registrations-delta"></div>

    <h3 class="m-top_30">Распределение по платежам</h3>
    <div id="chart-payments"></div>

    <h3 class="m-top_30">Количество участников</h3>
    <div id="chart-count"></div>

  </div>
</div>
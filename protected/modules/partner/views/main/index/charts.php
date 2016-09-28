<?php
/**
 *  @var Statistics $statistics
 */

use \event\components\Statistics;
?>
<script type="text/javascript">
    partnerStatistics = new CParnerStatistics();
    partnerStatistics.Dates = <?=json_encode($statistics->getDates(), JSON_UNESCAPED_UNICODE)?>;
    partnerStatistics.RegistrationsAll = <?=json_encode($statistics->getRegistrationsAll(), JSON_UNESCAPED_UNICODE)?>;
    partnerStatistics.RegistrationsDelta = <?=json_encode($statistics->getRegistrationsDelta(), JSON_UNESCAPED_UNICODE)?>;
    partnerStatistics.Payments = <?=json_encode($statistics->getPayments(), JSON_UNESCAPED_UNICODE)?>;
    partnerStatistics.Count = <?=json_encode($statistics->getCount(), JSON_UNESCAPED_UNICODE)?>;
    partnerStatistics.Roles = <?=json_encode($statistics->getRolesTitle(), JSON_UNESCAPED_UNICODE)?>;

    google.setOnLoadCallback(function() {
        $(function() {
            partnerStatistics.init();
        });
    });
</script>
<div class="panel panel-warning">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-bar-chart"></i> <?=\Yii::t('app', 'Графические данные')?></span>
    </div> <!-- / .panel-heading -->
    <div class="alert alert-warning alert-dark alert-page">
        <div id="datesSlider"></div>
        <div id="datesRange" class="m-top_10"><strong><?=\Yii::t('app', 'Выборка за')?>:</strong> <span></span></div>
    </div>
    <div class="panel-body">
        <div class="panel-group panel-group-warning">
            <div class="panel">
                <div class="panel-heading">
                    <a href="#chart-registrations-all-panel" class="accordion-toggle" data-toggle="collapse">
                        <?=\Yii::t('app', 'Общее количество регистраций')?>
                    </a>
                </div>
                <div id="chart-registrations-all-panel" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div id="chart-registrations-all"></div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-heading">
                    <a href="#chart-registrations-delta-panel" class="accordion-toggle" data-toggle="collapse">
                        <?=\Yii::t('app', 'Количество регистраций по дням')?>
                    </a>
                </div>
                <div id="chart-registrations-delta-panel" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div id="chart-registrations-delta"></div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-heading">
                    <a href="#chart-payments-panel" class="accordion-toggle" data-toggle="collapse">
                        <?=\Yii::t('app', 'Распределение по платежам')?>
                    </a>
                </div>
                <div id="chart-payments-panel" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div id="chart-payments"></div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-heading">
                    <a href="#chart-count-panel" class="accordion-toggle" data-toggle="collapse">
                        <?=\Yii::t('app', 'Количество участников')?>
                    </a>
                </div>
                <div id="chart-count-panel" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div id="chart-count"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
/**
 * @var Coupon $coupon
 * @var \stdClass $stat
 * @var \partner\components\Controller $this
 */
use pay\models\Coupon;
$this->setPageTitle(\Yii::t('app', 'Статистика промо-кода'));
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-pie-chart"></i> <?=\Yii::t('app', 'Статистика промо-кода');?>: <strong><?=$coupon->Code;?></strong></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="stat-panel">
                    <div class="stat-cell bg-danger valign-middle">
                        <i class="fa fa-calculator bg-icon"></i>
                        <span class="text-xlg"><strong><?=count($coupon->Activations);?></strong></span><br>
                        <span class="text-bg"><?=\Yii::t('app', 'Активаций');?></span><br>
                        <span class="text-sm">
                            <?=\Yii::t('app', 'Доступно активаций');?>: <?=$coupon->Multiple ? $coupon->MultipleCount : 1;?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="stat-panel">
                    <div class="stat-cell bg-success valign-middle">
                        <i class="fa fa-rub bg-icon"></i>
                        <span class="text-xlg"><strong><?=$stat->count;?></strong></span><br>
                        <span class="text-bg"><?=\Yii::t('app', 'Количество оплат');?></span><br>
                        <span class="text-sm">
                            <?=\Yii::t('app', 'Сумма оплат');?>: <?=$stat->total;?> <?=\Yii::t('app', 'руб');?>.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
/**
 * @var $this Program
 * @var $grid array
 */

use \event\widgets\registration\Program;
?>
<div
    id="<?=$this->getNameId()?>"
    class="tab"
    data-user="<?if($this->getUser() !== null):?><?=$this->getUser()->RunetId?><?endif?>"
    <?if(isset($this->WidgetRegistrationProgramOneOnLineMode) && $this->WidgetRegistrationProgramOneOnLineMode == 1):?>data-oneonline-mode="1"<?endif?>
>
    <div class="pin-wrapper">
        <div class="total clearfix bg-muted">
            <div class="clearfix bg-muted">
                <div class="pull-left">
                    <span id="total-caption">
                        <?=\Yii::t('app', 'Выбрано секций')?>: <b class="number" id="total-section">0</b><?if(isset($this->WidgetRegistrationProgramShowTotalPrice) && $this->WidgetRegistrationProgramShowPrice == 1):?>, <?=\Yii::t('app', 'итого')?>: <b class="number" id="total-price">0</b> руб.<?endif?>
                    </span>
                </div>
                <div class="pull-right">
                    <?=\CHtml::link('', ['/pay/cabinet/index', 'eventIdName' => $this->getEvent()->IdName], ['class' => 'btn btn-success'])?>
                </div>
            </div>
        </div>
    </div>
    <?if(isset($this->WidgetRegistrationProgramBeforeText)):?>
        <?=$this->WidgetRegistrationProgramBeforeText?>
    <?endif?>
    <?$this->render('program/grid', ['grid' => $grid])?>
</div>
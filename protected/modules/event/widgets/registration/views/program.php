<?php
/**
 * @var $this Program
 * @var $grid array
 */

use \event\widgets\registration\Program;
?>
<div
    id="<?=$this->getNameId();?>"
    class="tab"
    data-user="<?php if ($this->getUser() !== null):?><?=$this->getUser()->RunetId;?><?php endif;?>"
    <?php if (isset($this->WidgetRegistrationProgramOneOnLineMode) && $this->WidgetRegistrationProgramOneOnLineMode == 1):?>data-oneonline-mode="1"<?php endif;?>
>
    <div class="pin-wrapper">
        <div class="total clearfix bg-muted">
            <div class="clearfix bg-muted">
                <div class="pull-left">
                    <span id="total-caption">
                        <?=\Yii::t('app', 'Выбрано секций');?>: <b class="number" id="total-section">0</b><?php if ($this->getEvent()->IdName != 'next2015'): //TODO: Костыль для next2015):?>, <?=\Yii::t('app', 'итого');?>: <b class="number" id="total-price">0</b> руб.<?php endif;?>
                    </span>
                </div>
                <div class="pull-right">
                    <?=\CHtml::link('', ['/pay/cabinet/index', 'eventIdName' => $this->getEvent()->IdName], ['class' => 'btn btn-info pull-right']);?>
                </div>
            </div>
        </div>
    </div>
    <?$this->render('program/grid', ['grid' => $grid]);?>
</div>
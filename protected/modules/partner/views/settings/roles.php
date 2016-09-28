<?php
/**
 * @var \partner\components\Controller $this
 */
$this->setPageTitle(\Yii::t('app', 'Статусы мероприятия'));
\Yii::app()->getClientScript()->registerPackage('runetid.jquery.colpick');
?>
<div class="panel panel-info" id="event-roles">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-list"></i> <?=\Yii::t('app', 'Статусы мероприятия')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"><?=\Yii::t('app', 'Статусы')?></th>
                        <th colspan="2"><?=\Yii::t('app','Цвет')?></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="table-footer">
                <?=\CHtml::beginForm('', 'POST', ['class' => 'form-inline'])?>
                    <?=\CHtml::textField('Role', '', ['placeholder' => \Yii::t('app', 'Добавить новый статус'), 'class' => 'form-control'])?>
                    <button type="button" class="btn btn-primary" disabled="disabled"><?=\Yii::t('app', 'Добавить')?></button>
                <?=\CHtml::endForm()?>
            </div>
        </div>
    </div>
</div>
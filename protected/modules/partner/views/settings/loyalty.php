<?
/**
 * @var \pay\models\forms\LoyaltyProgramDiscount $form
 * @var LoyaltyProgramDiscount[] $discounts
 * @var \partner\components\Controller $this
 * @var $activeForm CActiveForm
 */

use \pay\models\LoyaltyProgramDiscount;
use application\helpers\Flash;

$this->setPageTitle(\Yii::t('app', 'Программа лояльности'));
?>

<?=Flash::html()?>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-tachometer"></i> <?=\Yii::t('app', 'Программа лояльности')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?if(!empty($discounts)):?>
            <div class="table-info">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?=\Yii::t('app', 'Скидка')?></th>
                            <th><?=\Yii::t('app', 'Дата начала')?></th>
                            <th><?=\Yii::t('app', 'Дата окончания')?></th>
                            <th><?=\Yii::t('app', 'Товар')?></th>
                            <th><?=\Yii::t('app', 'Статус')?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?foreach($discounts as $discount):?>
                        <tr>
                            <td><?=$discount->Discount?>%</td>
                            <td><?=!empty($discount->StartTime) ? \Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $discount->StartTime) : \Yii::t('app', 'Не указано')?></td>
                            <td><?=!empty($discount->EndTime) ? \Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $discount->EndTime) : \Yii::t('app', 'Не указано')?></td>
                            <td><?=!empty($discount->Product) ? $discount->Product->Title : \Yii::t('app','Все товары')?></td>
                            <td>
                                <?if($discount->getStatus() == LoyaltyProgramDiscount::StatusActive):?>
                                    <label class="label label-success"><?=\Yii::t('app', 'Активна')?></label>
                                <?php elseif ($discount->getStatus() == LoyaltyProgramDiscount::StatusEnd):?>
                                    <label class="label label-warning"><?=\Yii::t('app', 'Прошла')?></label>
                                <?php elseif ($discount->getStatus() == LoyaltyProgramDiscount::StatusSoon):?>
                                    <label class="label"><?=\Yii::t('app', 'Ожидание')?></label>
                                <?endif?>
                            </td>
                            <td>
                                <?if($discount->getStatus() == LoyaltyProgramDiscount::StatusActive):?>
                                    <?=\CHtml::link('<span class="fa fa-pause"></span>',['loyalty', 'id' => $discount->Id, 'action' => 'delete'], ['title' => \Yii::t('app', 'Остановить')])?>
                                <?php elseif ($discount->getStatus() == LoyaltyProgramDiscount::StatusSoon):?>
                                    <?=\CHtml::link('<span class="fa fa-times"></span>',['loyalty', 'id' => $discount->Id, 'action' => 'delete'], ['title' => \Yii::t('app', 'Удалить')])?>
                                <?endif?>
                            </td>
                        </tr>
                    <?endforeach?>
                    </tbody>
                </table>
            </div>
        <?else:?>
            <div class="alert alert-danger m-bottom_0">
                <?=\Yii::t('app', 'Скидки по программе лояльности отсутствуют.')?>
            </div>
        <?endif?>
    </div>
</div>

<?$activeForm = $this->beginWidget('CActiveForm')?>
<div class="panel panel-warning">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-plus"></i> <?=\Yii::t('app', 'Создание новой скидки')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
        <div class="row">
            <div class="col-sm-3">
                <?=$activeForm->label($form, 'Discount')?>
                <?=$activeForm->textField($form, 'Discount', ['class' => 'form-control'])?>
            </div>
            <div class="col-sm-3">
                <?=$activeForm->label($form, 'StartDate')?>
                <?=$activeForm->textField($form, 'StartDate', ['class' => 'form-control'])?>
            </div>
            <div class="col-sm-3">
                <?=$activeForm->label($form, 'EndDate')?>
                <?=$activeForm->textField($form, 'EndDate', ['class' => 'form-control'])?>
            </div>
            <div class="col-sm-3">
                <?=$activeForm->label($form, 'ProductId')?>
                <?=$activeForm->dropDownList($form, 'ProductId', $form->getProductData(), ['class' => 'form-control'])?>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Создать'), ['class' => 'btn btn-primary'])?>
    </div>
</div>
<?$this->endWidget()?>

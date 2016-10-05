<?php
/**
 * @var \partner\models\forms\coupon\Give $form
 * @var \partner\components\Controller $this
 * @var CActiveForm $activeForm
 */

use application\helpers\Flash;

$this->setPageTitle(\Yii::t('app', 'Выдача промо-кодов'));
?>

<?$activeForm = $this->beginWidget('CActiveForm')?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title"><i class="fa fa-ticket"></i> <?=\Yii::t('app', 'Выдача промо-кодов')?></span>
        </div> <!-- / .panel-heading -->
        <div class="panel-body">
            <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
            <?=Flash::html()?>
            <div class="table-info">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th><?=\Yii::t('app','Купон')?></th>
                        <th><?=\Yii::t('app','Скидка')?></th>
                        <th><?=\Yii::t('app','Статус')?></th>
                    </thead>
                    <tbody>
                    <?foreach($form->getCoupons() as $coupon):?>
                        <tr>
                            <td><span class="lead"><?=$coupon->Code?></span></td>
                            <td><?=$coupon->getManager()->getDiscountString()?></td>
                            <td>
                                <?if(empty($coupon->Recipient)):?>
                                    <span class="label label-success"><?=\Yii::t('app','Свободен')?></span>
                                <?else:?>
                                    <span class="label label-warning"><?=\Yii::t('app','Выдан')?></span>
                                    <p class="small"><?=$coupon->Recipient?></p>
                                <?endif?>
                            </td>
                        </tr>
                    <?endforeach?>
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <?=$activeForm->label($form, 'Recipient')?>
                <?=$activeForm->textField($form, 'Recipient', ['class' => 'form-control'])?>
            </div>
        </div>
        <div class="panel-footer">
            <?=\CHtml::submitButton(\Yii::t('app', 'Выдать'), ['class' => 'btn btn-primary'])?>
        </div>
    </div>
<?$this->endWidget()?>
<?
/**
 * @var \widget\components\Controller $this
 * @var \widget\models\forms\ProductCount $form
 * @var \application\widgets\ActiveForm $activeForm
 */
use \user\models\forms\RegisterForm;


$registration = new RegisterForm();

/** @var \CClientScript $clientScript */
$clientScript = \Yii::app()->getClientScript();
$clientScript->registerScript('init', '
    new CRegistrationUsers({products : ' . $form->getProductsJson() . '});
', \CClientScript::POS_HEAD);
?>
<div ng-controller="RegisterUsersController">
    <table class="table thead-actual">
        <thead>
            <tr>
                <th><?=\Yii::t('app', 'Тип билета');?></th>
                <th class="col-width t-right"><?=\Yii::t('app', 'Цена');?></th>
                <th class="col-width t-center"><?=\Yii::t('app', 'Кол-во');?></th>
                <th class="col-width t-right last-child"><?=\Yii::t('app', 'Сумма');?></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <table class="table" ng-repeat="product in products">
        <thead>
            <tr>
                <th>
                    <h4 class="title">{{product.Title}} <i class="icon-chevron-up"></i></h4>
                </th>
                <th class="col-width t-right"><span class="number">{{product.Price}}</span> руб.</th>
                <th class="col-width t-center"><span class="number quantity">{{product.participants.length}}</span></th>
                <th class="col-width t-right last-child"><b class="number mediate-price">{{product.total}}</b> руб.</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="participant in product.participants">
                <td colspan="4">
                    <div ng-if="participant.RunetId !== undefined">
                        <div class="alert alert-danger" ng-if="participant.error !== undefined">{{participant.error}}</div>
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="input-group">
                                    <input type="text" readonly="readonly" value="{{participant.FullName}}, RUNET-ID {{participant.RunetId}}" class="form-control"/>
                                    <span class="input-group-addon">
                                        <span class="fa fa-times" ng-click="removeParticipant(product, participant, $index)"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-1 text-center">
                                <strong ng-if="participant.discount !== undefined && participant.discount > 0" class="text-success">
                                    - {{participant.discount}} <?=\Yii::t('app', 'руб.');?>
                                </strong>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <input type="text" ng-model="participant.coupon" class="form-control" placeholder="<?=\Yii::t('app', 'Промо-код');?>" ng-init="participant.coupon=''"/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" ng-click="activateCoupon(product, participant)">
                                            <span class="fa fa-check-circle"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div ng-if="participant.RunetId == undefined">
                        <div class="form-group">
                            <div class="alert alert-danger" ng-if="participant.error !== undefined">{{participant.error}}</div>
                            <input type="text" placeholder="Введите ФИО или RUNET-ID" userautocomplete data-product="{{product}}" data-index="{{$index}}" class="form-control"/>
                        </div>
                        <div class="">
                            <?$activeForm = $this->beginWidget('\application\widgets\ActiveForm', ['htmlOptions' => ['registration' => 'registration']]);?>
                                <h4 class="text-center"></h4>
                                <div class="alert alert-danget hide">
                                    <ul></ul>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'LastName');?>
                                            <?=$activeForm->textField($registration, 'LastName', ['class' => 'form-control']);?>
                                        </div>
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'FirstName');?>
                                            <?=$activeForm->textField($registration, 'FirstName', ['class' => 'form-control']);?>
                                        </div>
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'FatherName');?>
                                            <?=$activeForm->textField($registration, 'FatherName', ['class' => 'form-control']);?>
                                        </div>
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'Email');?>
                                            <?=$activeForm->textField($registration, 'Email', ['class' => 'form-control']);?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'Phone');?>
                                            <?=$activeForm->textField($registration, 'Phone', ['class' => 'form-control']);?>
                                        </div>
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'Company');?>
                                            <?=$activeForm->textField($registration, 'Company', ['class' => 'form-control']);?>
                                        </div>
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'Position');?>
                                            <?=$activeForm->textField($registration, 'Position', ['class' => 'form-control']);?>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <?=\CHtml::submitButton(\Yii::t('app', 'Загеристрировать'), ['class' => 'btn btn-primary', 'ngClick' => 'submit']);?>
                                </div>
                            <?$this->endWidget();?>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    {{total}} руб.
</div>

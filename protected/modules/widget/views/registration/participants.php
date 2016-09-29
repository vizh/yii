<?
/**
 * @var \widget\components\Controller $this
 * @var \widget\models\forms\ProductCount $form
 * @var \application\widgets\ActiveForm $activeForm
 * @var \pay\components\collection\Finder $finder
 */
use \user\models\forms\RegisterForm;


$registration = new RegisterForm();

/** @var \CClientScript $clientScript */
$clientScript = \Yii::app()->getClientScript();
$clientScript->registerScript('init', '
    new CRegistrationUsers({\'eventIdName\':"' . $this->getEvent()->IdName . '", \'products\':' . $form->getProductsJson() . '});
', \CClientScript::POS_HEAD);
$clientScript->registerPackage('runetid.jquery.inputmask-multi');
?>

<div id="preloader"></div>
<div ng-controller="RegisterUsersController">
    <table class="table thead-actual">
        <thead>
            <tr>
                <th><?=\Yii::t('app', 'Тип билета')?></th>
                <th class="col-width text-right"><?=\Yii::t('app', 'Цена')?></th>
                <th class="col-width text-center"><?=\Yii::t('app', 'Кол-во')?></th>
                <th class="col-width text-right"><?=\Yii::t('app', 'Сумма')?></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <table class="table product" ng-repeat="product in products">
        <thead>
            <tr>
                <th>
                    <h4 class="title">{{product.Title}} <i class="icon-chevron-up"></i></h4>
                </th>
                <th class="col-width text-right">
                    <span class="number">{{product.Price != 0 ? product.Price + " руб." : "<?=\Yii::t('app', 'Бесплатно')?>"}}</span>
                </th>
                <th class="col-width text-center"><span class="number quantity">{{product.count}}</span></th>
                <th class="col-width text-right"><b class="number mediate-price">{{product.Price != 0 ? product.total  + " руб." : "<?=\Yii::t('app', 'Бесплатно')?>"}}</b></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="participant in product.participants">
                <td colspan="4">
                    <div ng-if="participant.RunetId !== undefined">
                        <div ng-if="!participant.userdata">
                            <div class="alert alert-danger" ng-if="participant.error !== undefined">{{participant.error}}</div>
                            <div class="row">
                                <div class="{{getParticipantClass(participant)}}">
                                    <div class="input-group">
                                        <input type="text" readonly="readonly" value="{{participant.FullName}}, RUNET-ID {{participant.RunetId}}" class="form-control"/>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" ng-click="removeOrderItem(product, participant, $index)">
                                                <span class="fa fa fa-times"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-2 col-lg-1 text-center discount" ng-if="participant.discount !== undefined && participant.discount > 0" >
                                    <strong class="text-success">
                                        - {{participant.discount}} <?=\Yii::t('app', 'руб.')?>
                                    </strong>
                                </div>
                                <div class="col-xs-3">
                                    <div class="input-group">
                                        <input type="text" ng-model="participant.coupon" class="form-control" placeholder="<?=\Yii::t('app', 'Промо-код')?>" ng-init="participant.coupon=''"/>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" ng-click="activateCoupon(product, participant)">
                                                <span class="fa fa-check-circle"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?=$this->renderPartial('participants/user-data')?>
                    </div>

                    <div ng-if="participant.RunetId == undefined">
                        <div ng-if="participant.registration == undefined || !participant.registration">
                            <div class="alert alert-danger" ng-if="participant.error !== undefined">{{participant.error}}</div>
                            <div class="control-group" style="width: 100%;">
                                <input type="text" placeholder="Введите ФИО или RUNET-ID" userautocomplete data-product="{{product}}" data-index="{{$index}}" class="form-control"/>
                                <span class="input-group-btn hide">
                                    <button class="btn btn-info" type="button" ng-click="showRegistrationForm(participant)"><?=\Yii::t('app', 'Новый пользователь')?></button>
                                </span>
                            </div>
                        </div>

                        <div registration ng-if="participant.registration" data-product="{{product}}" data-index="{{$index}}">
                            <?$activeForm = $this->beginWidget('\application\widgets\ActiveForm')?>
                                <h4 class="text-center"><?=\Yii::t('app', 'Регистрация нового пользователя')?></h4>
                                <div class="row">
                                    <div class="col-xs-10 col-xs-offset-1">
                                        <div class="alert alert-danger hide">
                                            <ul></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-5 col-xs-offset-1">
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'LastName')?>
                                            <?=$activeForm->textField($registration, 'LastName', ['class' => 'form-control'])?>
                                        </div>
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'FirstName')?>
                                            <?=$activeForm->textField($registration, 'FirstName', ['class' => 'form-control'])?>
                                        </div>
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'FatherName')?>
                                            <?=$activeForm->textField($registration, 'FatherName', ['class' => 'form-control'])?>
                                        </div>
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'Email')?>
                                            <?=$activeForm->textField($registration, 'Email', ['class' => 'form-control'])?>
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'Phone')?>
                                            <?=$activeForm->textField($registration, 'Phone', ['class' => 'form-control'])?>
                                        </div>
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'Company')?>
                                            <?=$activeForm->textField($registration, 'Company', ['class' => 'form-control'])?>
                                        </div>
                                        <div class="form-group">
                                            <?=$activeForm->label($registration, 'Position')?>
                                            <?=$activeForm->textField($registration, 'Position', ['class' => 'form-control'])?>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрировать'), ['class' => 'btn btn-primary', 'ngClick' => 'submit'])?>
                                    <?=\CHtml::button(\Yii::t('app', 'Отмена'), ['class' => 'btn btn-warning', 'ng-click' => 'hideRegistrationForm(participant)'])?>
                                </div>
                            <?$this->endWidget()?>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="product table" ng-if="!free">
        <tbody>
            <tr>
                <td colspan="4" class="total text-right">
                    <?=Yii::t('app', 'ИТОГО')?>: <b id="total-price" class="number">{{total}}</b> <?=Yii::t('app', 'руб.')?>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="text-center" ng-if="showPayBtn">
        <?=\CHtml::link(\Yii::t('app', 'Перейти к оплате'), ['pay'], ['class' => 'btn btn-primary btn-lg'])?>
    </div>
    <div class="text-center" ng-if="showRegisterBtn">
        <?=\CHtml::link(\Yii::t('app', 'Зарегистрировать'), ['complete'], ['class' => 'btn btn-primary btn-lg'])?>
    </div>

    <?=$this->renderPartial('participants/orders', ['finder' => $finder])?>
    <?=$this->renderPartial('participants/paid-items', ['finder' => $finder])?>
</div>

<?php
use partner\components\Controller;
use partner\models\forms\user\Participant;

/**
 * @var Controller $this
 * @var Participant $form
 */

$this->setPageTitle('Добавление/редактирование участника мероприятия');
$clientScript = \Yii::app()->getClientScript();
$clientScript->registerPackage('angular');
$clientScript->registerScript('init', '
    new CUserEdit(' . $form->getParticipantJson() . ');
', \CClientScript::POS_HEAD);
?>
<div ng-controller="UserEditController">
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title"><i class="fa fa-user"></i> <?=\Yii::t('app', 'Персональные данные');?></span>
            <div class="panel-heading-controls">
                <?=\CHtml::link('<span class="fa fa-external-link"></span> ' . \Yii::t('app', 'Профиль'), $form->getActiveRecord()->getUrl(), ['target' => '_blank', 'class' => 'btn btn-xs btn-info btn-outline']);?>
            </div>
        </div> <!-- / .panel-heading -->
        <div class="panel-body">

        </div>
    </div>

    <div class="panel panel-warning">
        <div class="panel-heading">
            <span class="panel-title">&nbsp;</span>
            <ul class="nav nav-tabs nav-tabs-xs">
                <li class="active">
                    <a href="#user-participant" data-toggle="tab"><?=\Yii::t('app', 'Роль на мероприятии');?></a>
                </li>
                <li ng-if="products.length > 0">
                    <a href="#user-products" data-toggle="tab"><?=\Yii::t('app', 'Опции');?></a>
                </li>
            </ul> <!-- / .nav -->
        </div> <!-- / .panel-heading -->
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane active" id="user-participant">
                    <div class="form-group {{participant.class ? 'has-' + participant.class : '' }}" ng-repeat="participant in participants">
                        <label class="control-label" ng-if="participant.Title != undefined">{{participant.Title}}</label>
                        <select class="form-control" ng-model="participant.role" ng-options='role.Id as role.Title for role in <?=$form->getRoleDataJson();?>'>
                            <option value="">Роль не задана</option>
                        </select>
                        <p class="help-block" ng-if="participant.message">{{participant.message}}</p>
                    </div>
                </div>
                <div class="tab-pane" id="user-products" ng-if="products.length > 0">
                    <div class="{{product.class ? 'has-' + product.class : '' }}" ng-repeat="product in products">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" ng-model="product.Paid" ng-change="changeProduct(product)" /> {{product.Title}}
                            </label>
                        </div>
                        <p class="help-block" ng-if="product.message">{{product.message}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-danger">
        <div class="panel-heading">
            <span class="panel-title"><i class="fa fa-list-alt"></i> <?=\Yii::t('app', 'Атрибуты пользователей');?></span>
        </div> <!-- / .panel-heading -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th ng-repeat="item in data[0]">{{item.title}}</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="row in data">
                    <td ng-repeat="item in row">
                       <span ng-bind-html="item.value" ng-if="!item.editMode"></span>
                       <div ng-bind-html="item.edit" ng-if="item.editMode"></div>
                    </td>
                    <td>
                        <div class="btn-group btn-group-xs">
                            <a href="#" class="btn" ng-click="function () {alert(123);}"><?=\Yii::t('app', 'Редактировать');?></a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<?$this->beginWidget('\application\widgets\bootstrap\Modal', [
    'header' => 'Укажите комментарий',
    'footer' => \CHtml::button(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary'])
]);?>
    <textarea class="form-control"></textarea>
<?$this->endWidget();?>

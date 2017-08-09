<?php
/**
 * @var Controller $this
 * @var Participant $form
 * @var Visit[] $visits
 * @var user\models\forms\edit\Photo $photoForm
 */

use partner\components\Controller;
use partner\models\forms\user\Participant;
use ruvents\models\Visit;

$this->setPageTitle('Редактирование участника мероприятия');
$clientScript = Yii::app()->getClientScript();
$clientScript->registerPackage('angular');
$clientScript->registerScript('init', 'new CUserEdit('.$form->getParticipantJson().')', CClientScript::POS_END);

?>

<!--suppress CssUnusedSymbol -->
<style>
    .table-attributes th {
        height: 49px;
        width: 250px;
        padding-top: 14px;
    }

    .table-attributes td label {
        margin-top: 7px;
        color: brown;
    }

    <?/* Встречается в \application\components\AbstractDefinition::getPrintValue */?>
    .table-attributes-label {
        font-weight: 600;
        color: brown;
    }

    .table-attributes-value {
        margin-top: 7px;
    }
</style>

<div ng-controller="UserEditController" ng-cloak>
    <?=$this->renderPartial('edit/info', [
        'user' => $form->getActiveRecord(),
        'event' => $this->getEvent(),
        'photoForm' => $photoForm
    ])?>

    <div class="panel panel-warning" ng-if="data">
        <div class="panel-heading">
            <span class="panel-title">
                <i class="fa fa-list-alt"></i>
                <?=Yii::t('app', 'Атрибуты пользователей')?>
                <button
                    class="btn pull-right" style="position:relative;top:-6px;left:16px"
                    ng-class="{'btn btn-success' : row.edit, 'btn' : !row.edit}"
                    ng-click="updateDataValues(data[0])" type="button">{{!data[0].edit ? '<?=Yii::t('app', 'Редактировать')?>' : '<?=Yii::t('app', 'Сохранить')?>'}}
                </button>
            </span>
        </div>

        <div ng-repeat="(y, group) in data[0].groups">
            <h3 style="padding-left:20px">{{ group.title }}</h3>
            <table class="table table-bordered table-striped table-attributes">
                <tbody>
                        <tr ng-repeat="(i, attribute) in data[0].attributes" ng-if="attribute.group == group.id">
                            <th style="width:250px;height:49px;padding-top:14px;padding-left:20px">{{data[0].titles[i]}}</th>
                        <td ng-class="{'editable-data' : attribute.edit}">
                            <div class="table-attributes-value" ng-bind-html="attribute.value" ng-show="!data[0].edit"></div>
                            <div ng-bind-html="attribute.edit" ng-show="data[0].edit"></div>
                        </td>
                    </tr>
                        <tr ng-if="data[0].message">
                        <td colspan="2">
                            <div class="{{data[0].class ? 'text-' + data[0].class : '' }}" ng-if="row.class">
                            <small>{{data[0].message}}</small>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="padding-left: 20px; padding-bottom: 10px;">
            <button
                    class="btn"
                    ng-class="{'btn btn-success' : row.edit, 'btn' : !row.edit}"
                    ng-click="updateDataValues(data[0])" type="button">{{!data[0].edit ? '<?=Yii::t('app', 'Редактировать')?>' : '<?=Yii::t('app', 'Сохранить')?>'}}
            </button>
        </div>
    </div>

    <?if($visits):?>
        <div class="panel panel-warning" ng-if="data">
            <div class="panel-heading">
                <span class="panel-title">
                    <i class="fa fa-list-alt"></i>
                    <?=Yii::t('app', 'Отметки интерактивных стендов')?>
                </span>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><?=Yii::t('app', 'Время')?></th>
                        <th><?=Yii::t('app', 'Метка')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?foreach($visits as $visit):?>
                        <tr>
                            <td><?=$visit->Id?></td>
                            <td><?=$visit->CreationTime?></td>
                            <td><?=$visit->MarkId?></td>
                        </tr>
                    <?endforeach?>
                </tbody>
            </table>
        </div>
    <?endif?>

    <div class="panel panel-danger">
        <div class="panel-heading">
            <span class="panel-title">&nbsp;</span>
            <ul class="nav nav-tabs nav-tabs-xs nav-tabs-left">
                <li class="active">
                    <a href="#user-participant" data-toggle="tab"><?=Yii::t('app', 'Роль на мероприятии')?></a>
                </li>
                <li ng-if="products.length > 0">
                    <a href="#user-products" data-toggle="tab"><?=Yii::t('app', 'Опции')?></a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane active" id="user-participant">
                    <div class="form-group {{participant.class ? 'has-' + participant.class : '' }}" ng-repeat="participant in participants">
                        <label class="control-label" ng-if="participant.Title != undefined">{{participant.Title}}</label>
                        <select class="form-control" ng-model="participant.role" ng-options='role.Id as role.Title for role in <?=$form->getRoleDataJson()?>'>
                            <option value="">Роль не задана</option>
                        </select>
                        <p class="help-block" ng-if="participant.message">{{participant.message}}</p>
                    </div>
                </div>
                <div class="tab-pane" id="user-products" ng-if="products.length > 0">
                    <div class="{{product.class ? 'has-' + product.class : '' }}" ng-repeat="product in products">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" ng-model="product.Paid" ng-change="changeProduct(product)"/>
                                {{product.Title}}
                            </label>
                        </div>
                        <p class="help-block" ng-if="product.message">{{product.message}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?$this->beginWidget('application\widgets\bootstrap\Modal', [
    'id' => 'participant-message',
    'header' => 'Укажите комментарий',
    'footer' => \CHtml::button(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary'])
])?>
    <textarea class="form-control"></textarea>
<?$this->endWidget()?>

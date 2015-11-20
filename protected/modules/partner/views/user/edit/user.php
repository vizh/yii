<?php
/**
 * @var $user \user\models\User
 * @var $event \event\models\Event
 * @var $participants \event\models\Participant[]
 * @var $this \partner\components\Controller
 * @var \partner\models\forms\user\Edit $form
 */

$clientScript = \Yii::app()->getClientScript();
$clientScript->registerPackage('angular');

$clientScript->registerScript($this->getUniqueId(), '
    new CPartnerUserEdit({participants : ' . $form->getParticipantsJson() . '});
', \CClientScript::POS_HEAD);

$this->setPageTitle(\Yii::t('app', 'Добавление/редактирование участника мероприятия') . ': ' . $user->GetFullName());

$data = $event->getUserData($user);
?>
<input type="hidden" name="id" value="<?=$user->RunetId;?>" />
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-user"></i> <?=\Yii::t('app', 'Персональные данные');?></span>
        <div class="panel-heading-controls">
            <?=\CHtml::link('<span class="fa fa-external-link"></span> ' . \Yii::t('app', 'Профиль'), $user->getUrl(), ['target' => '_blank', 'class' => 'btn btn-xs btn-info btn-outline']);?>
        </div>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-2 col-lg-1 hidden-xs">
                <?=\CHtml::image($user->getPhoto()->get200px(),'',['class' => 'img-responsive']);?>
            </div>
            <div class="col-sm-10 col-lg-11 col-xs-12">
                <h3 class="clear-indents">
                    <?=$user->getFullName();?>
                    <?php $user->setLocale('en');?>
                    (<?=$user->getFullName();?>)
                    <sup><?=$user->RunetId;?></sup>
                </h3>
                <?php $employment = $user->getEmploymentPrimary();?>
                <?php if ($employment !== null):?>
                    <h5 class="clear-indents m-top_10">
                        <?=$employment->Company->Name;?>
                        <?php $employment->Company->setLocale('en');?>
                        (<?=$employment->Company->Name;?>)
                    </h5>
                <?php endif;?>
                <?=\CHtml::link(\Yii::t('app', 'Редактировать'), ['translate', 'id' => $user->RunetId], ['class' => 'btn btn-sm m-top_10']);?>
                <p class="m-top_20">
                    <span class="fa fa-envelope-o"></span> <?=\CHtml::mailto($user->Email);?>
                    <?php if ($user->getPhone() !== null):?>
                        <br/><span class="fa fa-phone"></span> <?=$user->getPhone();?>
                    <?php endif;?>
                    <?php if (!empty($user->Birthday)):?>
                        <br/><span class="fa fa-birthday-cake"></span> <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $user->Birthday);?>
                    <?php endif;?>
                </p>
                <?$this->renderPartial('edit/data', ['user' => $user, 'event' => $event]);?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-warning" ng-controller="PartnerUserEdit">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-caret-square-o-down"></i> <?=\Yii::t('app', 'Роль на мероприятии');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="form-group" ng-repeat="participant in participants">
            <label class="control-label" ng-if="participant.Part != null">{{participant.Part}}</label>
        </div>





        <?php if (sizeof($event->Parts) === 0):?>
            <div class="form-group">
                <?php $roleId = isset($participants[0]) ? $participants[0]->RoleId : null;?>
                <select data-part-id="" name="roleId" class="form-control">
                    <option value="0" <?=$roleId === null ? 'selected="selected"' : '';?>>Не участвует</option>
                    <?php foreach ($event->getRoles() as $role):?>
                        <option value="<?=$role->Id;?>" <?=$roleId == $role->Id ? 'selected="selected"' : '';?>><?=$role->Title;?></option>
                    <?endforeach;?>
                </select>
            </div>
        <?php else:?>
            <?php foreach ($event->Parts as $part):?>
                <?php $roleId = isset($participants[$part->Id]) ? $participants[$part->Id]->RoleId : null;?>
                <div class="form-group">
                    <label class="control-label"><?=$part->Title;?></label>
                    <select data-part-id="<?=$part->Id;?>" name="roleId" class="form-control">
                        <option value="0" <?=$roleId === null ? 'selected="selected"' : '';?>>Не участвует</option>
                        <?php foreach ($event->getRoles() as $role):?>
                            <option value="<?=$role->Id;?>" <?=$roleId == $role->Id ? 'selected="selected"' : '';?>><?=$role->Title;?></option>
                        <?endforeach;?>
                    </select>
                </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>
</div>
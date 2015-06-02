<?php
/**
 * @var $user \user\models\User
 * @var $event \event\models\Event
 * @var $participants \event\models\Participant[]
 */
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-user"></i> <?=\Yii::t('app', 'Персональные данные');?></span>
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
                    <h5>
                        <?=$employment->Company->Name;?>
                        <?php $employment->Company->setLocale('en');?>
                        (<?=$employment->Company->Name;?>)
                    </h5>
                <?php endif;?>
                <?=\CHtml::link(\Yii::t('app', 'Редактировать'), ['translate', 'id' => $user->RunetId], ['class' => 'btn btn-sm']);?>
                <p class="m-top_20">
                    <span class="fa fa-envelope-o"></span> <?=\CHtml::mailto($user->Email);?>
                    <?php if ($user->getPhone() !== null):?>
                        <br/><span class="fa fa-phone"></span> <?=$user->getPhone();?>
                    <?php endif;?>
                    <?php if (!empty($user->Birthday)):?>
                        <br/><span class="fa fa-birthday-cake"></span> <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $user->Birthday);?>
                    <?php endif;?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-warning">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-caret-square-o-down"></i> <?=\Yii::t('app', 'Роль на мероприятии');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?php if (sizeof($event->Parts) === 0):?>
            <?php $roleId = isset($participants[0]) ? $participants[0]->RoleId : null;?>
            <div class="row">
                <div class="col-md-5">
                    <select data-part-id="" name="roleId" class="form-control">
                        <option value="0" <?=$roleId === null ? 'selected="selected"' : '';?>>Не участвует</option>
                        <?php foreach ($event->getRoles() as $role):?>
                            <option value="<?=$role->Id;?>" <?=$roleId == $role->Id ? 'selected="selected"' : '';?>><?=$role->Title;?></option>
                        <?endforeach;?>
                    </select>
                </div>
            </div>
        <?php else:?>
            <?php foreach ($event->Parts as $part):?>
                <?php $roleId = isset($participants[$part->Id]) ? $participants[$part->Id]->RoleId : null;?>
                <div class="row">
                    <div class="col-md-5">
                        <label class="control-label"><?=$part->Title;?></label>
                        <select data-part-id="<?=$part->Id;?>" name="roleId" class="form-control">
                            <option value="0" <?=$roleId === null ? 'selected="selected"' : '';?>>Не участвует</option>
                            <?php foreach ($event->getRoles() as $role):?>
                                <option value="<?=$role->Id;?>" <?=$roleId == $role->Id ? 'selected="selected"' : '';?>><?=$role->Title;?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>
</div>

<div class="row">
    <div class="span12 m-bottom_30">
        <h2>Редактирование участника</h2>
    </div>

    <div class="span12">
        <?if (!empty($this->action->error)):?>
            <div class="alert alert-error">
                <button data-dismiss="alert" class="close">?</button>
                <strong>Ошибка!</strong> <?=$this->action->error;?>
            </div>
        <?endif;?>
    </div>

    <div class="span12 indent-bottom2">
        <input type="hidden" name="runetId" value="<?=$user->RunetId;?>">
        <h3><?=\Yii::t('app', 'Персональные данные');?></h3>
        <div class="row">
            <div class="span1">
                <img src="<?=$user->getPhoto()->get58px();?>" title="" class="pull-left" />
            </div>
            <div class="span10">
                <strong>
                    <?php
                    echo $user->getFullName();
                    $user->setLocale('en');
                    echo ' ('.$user->getFullName().')';
                    ?>
                </strong>
                <?$employment = $user->getEmploymentPrimary();?><sup><?=$user->RunetId;?></sup>
                <?if ($employment !== null):?>
                    <br/>
                    <span class="small">
                        <?=$employment->Company->Name;?>
                        <?php $employment->Company->setLocale('en');?>
                        (<?=$employment->Company->Name;?>)
                    </span>
                <?endif;?>
                <?php if (!empty($user->Birthday)):?>
                    <br/>
                    <span class="small">Дата рождения: <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $user->Birthday);?></span>
                <?endif;?>
                <div class="m-top_10"><a href="<?=$this->createUrl('/partner/user/translate', array('runetId' => $user->RunetId));?>" class="btn btn-mini"><?=\Yii::t('app', 'Редактировать');?></a></div>
            </div>
        </div>

        <?$data = $event->getUserData($user);?>
        <?if (!empty($data)):?>
            <table class="table m-top_30 table-bordered table-striped user-data">
                <thead>
                    <tr>
                        <?foreach($data[0]->getManager()->getDefinitions() as $definition):?>
                            <th><?=$definition->title;?></th>
                        <?endforeach;?>
                        <th style="width: 1px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?foreach($data as $row):?>
                        <tr data-id="<?=$row->Id;?>">
                            <?foreach ($row->getManager()->getDefinitions() as $definition):?>
                            <td>
                                <div class="input hide">
                                    <?=$definition->activeEdit($row->getManager(), ['class' => 'input-block-level', 'data-name' => $definition->name]);?>
                                </div>
                                <div class="value" data-name="<?=$definition->name;?>">
                                    <?=$definition->getPrintValue($row->getManager());?>
                                </div>
                            </td>
                            <?endforeach;?>
                            <td>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-mini edit"><?=\Yii::t('app', 'Редактировать');?></a>
                                    <a href="#" class="btn btn-mini btn-danger delete"><?=\Yii::t('app', 'Удалить');?></a>
                                </div>
                                <a href="#" class="btn btn-mini btn-success save hide"><?=\Yii::t('app', 'Сохранить');?></a>
                            </td>
                        </tr>
                    <?endforeach;?>
                </tbody>
            </table>
        <?endif;?>
    </div>


    <div class="span12 indent-top2">
        <h3><?=\Yii::t('app', 'Роль на мероприятии');?></h3>
        <?if (sizeof($event->Parts) === 0):?>
            <?$roleId = isset($participants[0]) ? $participants[0]->RoleId : null;?>
            <div class="row">
                <div class="span4">
                    <label for="roleId" class="large">Роль на мероприятии</label>
                </div>
                <div class="span8">
                    <select data-part-id="" id="roleId" name="roleId">
                        <option value="0" <?=$roleId === null ? 'selected="selected"' : '';?>>Не участвует</option>
                        <?php foreach ($event->getRoles() as $role):?>
                            <option value="<?=$role->Id;?>" <?=$roleId == $role->Id ? 'selected="selected"' : '';?>><?=$role->Title;?></option>
                        <?endforeach;?>
                    </select>
                </div>
            </div>
        <?else:?>
            <?foreach ($event->Parts as $part):?>
                <?$roleId = isset($participants[$part->Id]) ? $participants[$part->Id]->RoleId : null;?>
                <div class="row">
                    <div class="span4">
                        <label for="roleId<?=$part->Id;?>" class="large"><?=$part->Title;?></label>
                    </div>
                    <div class="span8">
                        <select data-part-id="<?=$part->Id;?>" id="roleId<?=$part->Id;?>" name="roleId">
                            <option value="0" <?=$roleId === null ? 'selected="selected"' : '';?>>Не участвует</option>
                            <?php foreach ($event->getRoles() as $role):?>
                                <option value="<?=$role->Id;?>" <?=$roleId == $role->Id ? 'selected="selected"' : '';?>><?=$role->Title;?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                </div>
            <?endforeach;?>
        <?endif;?>
    </div>
</div>

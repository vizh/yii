<?$roleDDlist = '<select name="RoleId" class="input-medium">';
foreach ($roles as $role):
    $roleDDlist .= '<option value="'.$role->Id.'" '.($role->Id == 1 ? 'selected="seleceted"' : '').'>'.$role->Title.'</option>';
endforeach;
$roleDDlist .= '</select>';
?>


<div class="row">
    <div class="span12">
        <?if ($showGenerateForm):?>
            <?=\CHtml::form('','POST',array('id' => 'invite-generator'));?>
            <div class="alert m-bottom_40">
                <h4 class="m-bottom_10"><?=\Yii::t('app', 'Генерация пришглашений');?></h4>
                <div class="row">
                    <div class="span2"><?=$roleDDlist;?></div>
                    <div class="span8">
                        <div class="input-prepend">
                            <button class="btn" type="submit"><?=\Yii::t('app', 'Сгенерировать!');?></button>
                            <input class="input" type="text" readonly="readonly" />
                        </div>
                    </div>
                </div>
            </div>
            <?=\CHtml::hiddenField('Action', 'generate');?>
            <?=\CHtml::endForm();?>
        <?endif;?>

        <h3><?=\Yii::t('app', 'Поданные заявки');?></h3>
        <?=\CHtml::form(\Yii::app()->createUrl('/partner/user/invite/'), 'get');?>
        <div class="row">
            <div class="span4">
                <?=\CHtml::activeLabel($filter, 'Sender');?>
                <?=\CHtml::activeTextField($filter, 'Sender');?>
            </div>
            <div class="span4">
                <?=\CHtml::activeLabel($filter, 'Owner');?>
                <?=\CHtml::activeTextField($filter, 'Owner');?>
            </div>
            <div class="span4">
                <?=\CHtml::activeLabel($filter, 'Approved');?>
                <?=\CHtml::activeDropDownList($filter, 'Approved', ['' => \Yii::t('app', 'Все')] + \event\models\Approved::getLabels());?>
            </div>
        </div>
        <div class="row m-top_20">
            <div class="span3">
                <button type="submit" class="btn btn-large"><i class=icon-search></i> <?=\Yii::t('app', 'Искать');?></button>
            </div>
        </div>
        <?=\CHtml::endForm();?>


        <?if (!empty($inviteRequests)):?>
            <table class="table table-striped">
                <thead>
                <th><?=\Yii::t('app', 'Отправитель');?></th>
                <th><?=\Yii::t('app', 'Получатель');?></th>
                <th><?=\Yii::t('app', 'Дата подачи');?></th>
                <th><?=\Yii::t('app', 'Статус');?></th>
                </thead>
                <tbody>
                <?foreach($inviteRequests as $request):?>
                    <tr>
                        <td>
                            <?=$request->Sender->RunetId;?>, <strong><?=\CHtml::link($request->Sender->getFullName(), $request->Sender->getUrl(), array('target' => '_blank'));?></strong>
                            <?if (($employment = $request->Sender->getEmploymentPrimary()) !== null):?>
                                <br/><?=$employment;?>
                            <?endif;?>
                        </td>
                        <td>
                            <?=$request->Owner->RunetId;?>, <strong><?=\CHtml::link($request->Owner->getFullName(), $request->Owner->getUrl(), array('target' => '_blank'));?></strong>
                            <?if (($employment = $request->Owner->getEmploymentPrimary()) !== null):?>
                                <br/><?=$employment;?>
                            <?endif;?>

                            <?$data = $event->getUserData($request->Owner);?>
                            <?if (!empty($data)):?>
                                <br/><a href="#definitions_<?=$request->Owner->RunetId;?>" class="btn btn-mini m-top_5" role="button"  data-toggle="modal"><?=\Yii::t('app', 'Дополнительные параметры');?></a>
                                <div class="modal hide" id="definitions_<?=$request->Owner->RunetId;?>">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h3><?=\Yii::t('app', 'Дополнительные параметры');?></h3>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <?foreach($data[0]->getManager()->getDefinitions() as $definition):?>
                                                    <th><?=$definition->title;?></th>
                                                <?endforeach;?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?foreach($data as $row):?>
                                                <tr>
                                                    <?foreach ($row->getManager()->getDefinitions() as $definition):?>
                                                        <td><?=$definition->getPrintValue($row->getManager());?></td>
                                                    <?endforeach;?>
                                                </tr>
                                            <?endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?endif;?>
                        </td>
                        <td><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm', $request->CreationTime);?></td>
                        <td>
                            <?if ($request->Approved == \event\models\Approved::Yes):?>
                                <span class="label label-success"><?=\event\models\Approved::getLabels()[\event\models\Approved::Yes];?></span>
                            <?else:?>
                                <?if ($request->Approved == \event\models\Approved::No):?>
                                    <div class="m-bottom_5">
                                        <span class="label label-important"><?=\event\models\Approved::getLabels()[\event\models\Approved::No];?></span>
                                    </div>
                                <?endif;?>
                                <?=\CHtml::form('', 'POST', array('class' => 'form-horizontal'));?>
                                <?=$roleDDlist;?>
                                <div class="btn-group m-top_5">
                                    <button class="btn btn-success" type="submit" name="Action" value="approved" title="<?=\Yii::t('app', 'Подтвердить');?>"><i class="icon-ok-circle icon-white"></i></button>
                                    <button class="btn btn-danger" type="submit" name="Action" value="disapproved" title="<?=\Yii::t('app', 'Отклонить');?>"><i class="icon-ban-circle icon-white"></i></button>
                                </div>
                                <?=\CHtml::hiddenField('InviteId', $request->Id);?>
                                <?=\CHtml::endForm();?>
                            <?endif;?>
                        </td>
                    </tr>
                <?endforeach;?>
                </tbody>
            </table>

            <?$this->widget('\application\widgets\Paginator', array('paginator' => $paginator));?>
        <?else:?>
            <div class="alert alert-error"><?=\Yii::t('app', 'Не найдено ни одной заявки на участие!');?></div>
        <?endif;?>
    </div>
</div>



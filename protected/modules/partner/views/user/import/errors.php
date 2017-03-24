<?php
/**
 * @var $users \partner\models\ImportUser[]
 * @var $this \ruvents\components\Controller
 */

$this->setPageTitle(\Yii::t('app', 'Импорт участников мероприятия'));

$definitions = [];
/*
if ($users[0]->getUserData() !== null) {
    $definitions = $users[0]->getUserData()->getManager()->getDefinitions();
}
*/
?>
<?=CHtml::beginForm()?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title"><i class="fa fa-exclamation"></i> <?=\Yii::t('app', 'Исправление ошибок')?></span>
        </div> <!-- / .panel-heading -->
        <div class="panel-body">
            <div class="table-info">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="col-sm-6"><?=\Yii::t('app', 'Ошибка')?></th>
                            <th><?=\Yii::t('app', 'Фамилия')?></th>
                            <th><?=\Yii::t('app', 'Имя')?></th>
                            <th><?=\Yii::t('app', 'Email')?></th>
                            <?foreach($definitions as $definition):?>
                                <th><?=$definition->title?></th>
                            <?endforeach?>
                        </tr>
                    </thead>
                    <tbody>
                        <?foreach($users as $user):?>
                            <tr>
                                <td><?=$user->ErrorMessage?></td>
                                <td><?=CHtml::textField('users['.$user->Id.'][LastName]', $user->LastName, ['class' => 'form-control'])?></td>
                                <td><?=CHtml::textField('users['.$user->Id.'][FirstName]', $user->FirstName, ['class' => 'form-control'])?></td>
                                <td><?=CHtml::textField('users['.$user->Id.'][Email]', $user->Email, ['class' => 'form-control'])?></td>
                                <?php foreach($definitions as $definition):?>
                                    <td><?=$definition->activeEdit($user->getUserData()->getManager(), ['class' => 'form-control', 'name' => 'users[' . $user->Id . '][UserData][' . $definition->name . ']'])?></td>
                                <?endforeach?>
                            </tr>
                        <?endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-footer">
            <?=\CHtml::submitButton(\Yii::t('app', 'Продолжить'), ['class' => 'btn btn-primary'])?>
        </div>
    </div>
<?=CHtml::endForm()?>
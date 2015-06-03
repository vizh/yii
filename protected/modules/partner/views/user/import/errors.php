<?php
/**
 * @var $users \partner\models\ImportUser[]
 * @var $this \ruvents\components\Controller
 */

$this->setPageTitle(\Yii::t('app', 'Импорт участников мероприятия'));
?>
<?=CHtml::beginForm();?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title"><i class="fa fa-exclamation"></i> <?=\Yii::t('app', 'Исправление ошибок');?></span>
        </div> <!-- / .panel-heading -->
        <div class="panel-body">
            <div class="table-info">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="col-sm-6"><?=\Yii::t('app', 'Ошибка');?></th>
                            <th><?=\Yii::t('app', 'Фамилия');?></th>
                            <th><?=\Yii::t('app', 'Имя');?></th>
                            <th><?=\Yii::t('app', 'Email');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user):?>
                            <tr>
                                <td><?=$user->ErrorMessage;?></td>
                                <td><?=CHtml::textField('users['.$user->Id.'][LastName]', $user->LastName, ['class' => 'form-control']);?></td>
                                <td><?=CHtml::textField('users['.$user->Id.'][FirstName]', $user->FirstName, ['class' => 'form-control']);?></td>
                                <td><?=CHtml::textField('users['.$user->Id.'][Email]', $user->Email, ['class' => 'form-control']);?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-footer">
            <?=\CHtml::submitButton(\Yii::t('app', 'Продолжить'), ['class' => 'btn btn-primary']);?>
        </div>
    </div>
<?=CHtml::endForm();?>
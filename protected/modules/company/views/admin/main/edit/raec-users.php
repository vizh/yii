<?php
use user\models\User;

/**
 * @var \application\components\controllers\AdminMainController $this
 * @var \company\models\forms\admin\Edit $form
 * @var \application\widgets\ActiveForm $activeForm
 */

$titles = $form->RaecUsers[0]->attributeLabels();
?>

<table class="table">
    <thead>
    <tr>
        <th><?=$titles['UserId']?></th>
        <th><?=$titles['StatusId']?></th>
        <th class="text-center"><?=$titles['AllowVote']?></th>
        <th><?=$titles['JoinTime']?></th>
        <th><?=$titles['ExitTime']?></th>
        <th style="width: 1px;"><?=$titles['Delete']?></th>
    </tr>
    </thead>
    <tbody>
    <?foreach($form->RaecUsers as $i => $user):?>
        <?=$activeForm->errorSummary($user, '<tr><td colspan="6"><div class="alert alert-error errorSummary m-bottom_0">', '</div></td></tr>')?>
        <tr>
            <td>
                <?if($user->isUpdateMode()):?>
                    <?=\CHtml::link($user->getActiveRecord()->User, $user->getActiveRecord()->User->getUrl(), ['class' => 'btn btn-link', 'target' => '_blank'])?>
                    <?=$activeForm->hiddenField($form, 'RaecUsers[' . $i . '][UserId]')?>
                <?else:?>
                    <?$this->widget('\application\widgets\AutocompleteInput', [
                        'model' => $form,
                        'attribute' => 'RaecUsers[' . $i . '][UserId]',
                        'source' => '/user/ajax/search',
                        'options'=> [
                            'select' => 'js:function (event, ui) {
                                var target = $(this).data("target");
                                $(this).val(ui.item.label);
                                $(target).val(ui.item.Id);
                                return false;
                            }'
                        ],
                        'adminMode' => true,
                        'htmlOptions' => ['class' => 'input-block-level'],
                        'label' => function ($value) {
                            return User::findOne($value);
                        }
                    ])?>
                <?endif?>
            </td>
            <td>
                <?=$activeForm->dropDownList($form, 'RaecUsers[' . $i . '][StatusId]', $user->getStatusData(), ['class' => 'input-block-level'])?>
            </td>
            <td class="text-center">
                <?=$activeForm->checkBox($form, 'RaecUsers[' . $i . '][AllowVote]')?>
            </td>
            <td>
                <?=$activeForm->textField($form, 'RaecUsers[' . $i . '][JoinTime]', ['class' => 'input-block-level'])?>
            </td>
            <td>
                <?=$activeForm->textField($form, 'RaecUsers[' . $i . '][ExitTime]', ['class' => 'input-block-level'])?>
            </td>
            <td class="text-center">
                <?if($user->isUpdateMode()):?>
                    <?=$activeForm->checkBox($form, 'RaecUsers[' . $i . '][Delete]')?>
                    <?=$activeForm->hiddenField($form, 'RaecUsers[' . $i . '][Id]')?>
                <?endif?>
            </td>
        </tr>
    <?endforeach?>
    </tbody>
</table>

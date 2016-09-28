<?php
use user\models\User;

/**
 * @var \application\components\controllers\AdminMainController $this
 * @var \company\models\forms\admin\Edit $form
 * @var \application\widgets\ActiveForm $activeForm
 */

$titles = $form->Moderators[0]->attributeLabels();
?>

<table class="table">
    <thead>
    <tr>
        <th><?=$titles['UserId']?></th>
        <th style="width: 1px;"><?=$titles['Delete']?></th>
    </tr>
    </thead>
    <tbody>
    <?foreach($form->Moderators as $i => $moderator):?>
        <?=$activeForm->errorSummary($moderator, '<tr><td colspan="6"><div class="alert alert-error errorSummary m-bottom_0">', '</div></td></tr>')?>
        <tr>
            <td>
                <?if($moderator->isUpdateMode()):?>
                    <?=\CHtml::link($moderator->getActiveRecord()->User, $moderator->getActiveRecord()->User->getUrl(), ['class' => 'btn btn-link', 'target' => '_blank'])?>
                    <?=$activeForm->hiddenField($form, 'Moderators[' . $i . '][UserId]')?>
                <?php else:?>
                    <?$this->widget('\application\widgets\AutocompleteInput', [
                        'model' => $form,
                        'attribute' => 'Moderators[' . $i . '][UserId]',
                        'source' => '/user/ajax/search',
                        'adminMode' => true,
                        'htmlOptions' => [
                            'class' => 'input-block-level'
                        ],
                        'options'=> [
                            'select' => 'js:function (event, ui) {
                                var target = $(this).data("target");
                                $(this).val(ui.item.label);
                                $(target).val(ui.item.Id);
                                return false;
                            }'
                        ],
                        'label' => function ($value) {
                            return User::findOne($value);
                        }
                    ])?>
                <?endif?>
            </td>
            <td class="text-center">
                <?if($moderator->isUpdateMode()):?>
                    <?=$activeForm->checkBox($form, 'Moderators[' . $i . '][Delete]')?>
                    <?=$activeForm->hiddenField($form, 'Moderators[' . $i . '][Id]')?>
                <?endif?>
            </td>
        </tr>
    <?endforeach?>
    </tbody>
</table>
<?php
use application\components\controllers\AdminMainController;
use user\models\User;
use application\widgets\ActiveForm;
use user\models\forms\admin\Merge;

/**
 * @var User $user
 * @var AdminMainController $this
 * @var ActiveForm $activeForm
 * @var Merge $form
 */
?>
<table class="table table-bordered m-top_30">
    <?foreach($user->Employments as $employment):?>
        <tr>
            <td>
                <?if(empty($employment->EndYear)):?>
                    <label class="radio">
                        <?=$activeForm->radioButton($form, 'PrimaryEmployment', ['uncheckValue' => null, 'value' => $employment->Id])?> Основное
                    </label>
                <?endif?>
            </td>
            <td>
                <label class="checkbox">
                    <?=$activeForm->checkBox($form, 'Employments[' . $employment->Id . ']')?> Добавить
                </label>
            </td>
            <td>
                <strong><?=$employment->Company->Name?></strong><br>
                <?=$employment->Position?>
            </td>
        </tr>
    <?endforeach?>
</table>


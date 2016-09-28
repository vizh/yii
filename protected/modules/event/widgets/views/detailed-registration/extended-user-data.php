<?php
/**
 * @var event\widgets\DetailedRegistration $this
 */

use application\components\attribute\BooleanDefinition;
use application\models\attribute\Group;

if (is_null($this->form->getUserData())) {
    return;
}

$group = null;
?>

<?php foreach($this->form->getUserData()->getManager()->getDefinitions() as $definition):?>
    <?php
    if ((!isset($this->WidgetRegistrationShowHiddenUserDataFields) || $this->WidgetRegistrationShowHiddenUserDataFields == 0) && !$definition->public) {
        continue;
    }
   ?>

    <?if(isset($this->WidgetRegistrationShowUserDataGroupLabel) && $this->WidgetRegistrationShowUserDataGroupLabel == 1):?>
        <?if($group == null || $group->Id !== $definition->groupId):?>
            <?$group = Group::model()->findByPk($definition->groupId)?>

            <?if($group !== null):?>
                <hr>
            <?endif?>
            <p><strong><?=CHtml::encode($group->Title)?></strong></p>
        <?endif?>
    <?endif?>

    <div class="row-fluid">
        <div class="control-group" id="control-group_<?=$definition->name?>">
            <?if(!($definition instanceof BooleanDefinition)):?>
                <label class="control-label">
                    <?=CHtml::encode($definition->title)?>
                    <?if($definition->required):?>
                        <span class="required-asterisk">*</span>
                    <?endif?>
                </label>
            <?endif?>
            <div class="controls">
                <?=$definition->activeEdit($this->form->getUserData()->getManager(), [
                    'class' => ($definition instanceof BooleanDefinition) ? '' : 'span12'
                ])?>
            </div>
        </div>
    </div>
<?endforeach?>

<hr>

<?php
/**
 * @var event\widgets\DetailedRegistration $this
 */

if (is_null($this->form->getUserData())) {
    return;
}
?>

<?php foreach($this->form->getUserData()->getManager()->getDefinitions() as $definition):?>
        <?if($definition->groupId == 54 /* ipheb16 Appeal */ || $definition->groupId == 61 /* fi-russia16 */):?>
            <div class="row-fluid">
                <div class="control-group" id="control-group_<?=$definition->name?>">
                    <label class="control-label">
                        <?=CHtml::encode($definition->title)?>
                        <?if($definition->required):?>
                            <span class="required-asterisk">*</span>
                        <?endif?>
                    </label>

                    <div class="controls">
                        <?=$definition->activeEdit($this->form->getUserData()->getManager(), [
                            'class' => 'span12'
                        ])?>
                    </div>
                </div>
            </div>
        <?endif?>
<?endforeach?>

<?php
/**
 * @var \user\models\User $user
 * @var \partner\widgets\UserAutocompleteInput $this
 */
?>
<div class="form-group">
    <?if($this->form !== null):?>
        <?=\CHtml::activeLabel($this->form, $this->attribute)?>
    <?endif?>
    <div class="input-group">
        <?=\CHtml::textField('', !empty($user) ? $user->GetFullName() : '', $this->htmlOptions)?>
        <span class="input-group-addon">
            <?if(!empty($this->value)):?>
                RUNET&ndash;ID: <?=$this->value?>
            <?php else:?>
                &mdash;
            <?endif?>
        </span>
        <?=\CHtml::hiddenField($this->field, $this->value)?>
    </div>
    <?if(!empty($this->help)):?>
        <p class="help-block"><?=$this->help?></p>
    <?endif?>
</div>

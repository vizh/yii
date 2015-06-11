<?php
/**
 * @var \application\widgets\AutocompleteInput $this
 */
?>
<div class="input-group">
    <?=CHtml::textField(null, $this->getData(), $this->htmlOptions);?>
    <?if ($this->addOn !== null):?>
        <span class="input-group-addon">
            <?=!empty($this->value) ? $this->addOn . ' ' . $this->value : '&mdash;';?>
        </span>
    <?endif;?>
    <input type="hidden" name="<?=$this->field;?>" value="<?=$this->value?>" />
</div>

<?php
/**
 * @var event\widgets\DetailedRegistration $this
 */

$roleData = $this->form->getRoleData();
if (empty($roleData)) {
    return;
}
?>

<div class="form-inline row-fluid m-bottom_5">
    <div class="span12">
        <?=CHtml::activeLabel($this->form, 'RoleId', ['class' => 'control-label'])?>
        <?=CHtml::activeDropDownList($this->form, 'RoleId', $roleData, ['class' => 'span12'])?>
    </div>
</div>

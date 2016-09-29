<?php
/**
 * @var CActiveForm $activeForm
 */
?>
<div class="form-group">
    <?=$activeForm->label($form, 'Name')?>
    <?=$activeForm->textField($form, 'Name', ['class' => 'form-control'])?>
</div>
<div class="form-group">
    <?=$activeForm->label($form, 'Address')?>
    <?=$activeForm->textField($form, 'Address', ['class' => 'form-control'])?>
</div>
<div class="form-group">
    <?=$activeForm->label($form, 'INN')?>
    <?=$activeForm->textField($form, 'INN', ['class' => 'form-control'])?>
</div>
<div class="form-group">
    <?=$activeForm->label($form, 'KPP')?>
    <?=$activeForm->textField($form, 'KPP', ['class' => 'form-control'])?>
</div>
<div class="form-group">
    <?=$activeForm->label($form, 'Phone')?>
    <?=$activeForm->textField($form, 'Phone', ['class' => 'form-control'])?>
</div>
<div class="form-group">
    <?=$activeForm->label($form, 'PostAddress')?>
    <?=$activeForm->textField($form, 'PostAddress', ['class' => 'form-control'])?>
</div>
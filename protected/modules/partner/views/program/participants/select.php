<?php
/**
 * @var \partner\models\forms\program\Participant $form
 * @var CActiveForm $activeForm
 */

$userTabId    = $form->getId() . '_user';
$companyTabId = $form->getId() . '_company';
$customTabId  = $form->getId() . '_custom';

$active = 'user';
if (!empty($form->CompanyId)) {
    $active = 'company';
} elseif (!empty($form->CustomText)) {
    $active = 'custom';
}
?>

<ul class="nav nav-tabs nav-tabs-xs">
    <li <?php if ($active === 'user'):?>class="active"<?php endif;?>>
        <a data-toggle="tab" href="#<?=$userTabId;?>">Пользователь</a>
    </li>
    <li <?php if ($active === 'company'):?>class="active"<?php endif;?>>
        <a data-toggle="tab" href="#<?=$companyTabId;?>">Компания</a>
    </li>
    <li <?php if ($active === 'custom'):?>class="active"<?php endif;?>>
        <a data-toggle="tab" href="#<?=$customTabId;?>">Произвольный текст</a>
    </li>
</ul>
<div class="tab-content tab-content-bordered">
    <div id="<?=$userTabId;?>" class="tab-pane <?php if ($active === 'user'):?>active<?php endif;?>">
        <?$this->widget('\partner\widgets\UserAutocompleteInput', [
            'form' =>  $form,
            'attribute' => 'RunetId'
        ]);?>
    </div>
    <div id="<?=$companyTabId;?>" class="tab-pane <?php if ($active === 'company'):?>active<?php endif;?>">
        <?$this->widget('\application\widgets\AutocompleteInput', [
            'form' =>  $form,
            'field' => 'CompanyId',
            'source' => '/company/ajax/search/',
            'addOn' => 'ID компании',
            'class' => '\company\models\Company',
            'htmlOptions' => ['class' => 'form-control']
        ]);?>
    </div>
    <div id="<?=$customTabId;?>" class="tab-pane <?php if ($active === 'custom'):?>active<?php endif;?>">
        <?=CHtml::activeTextArea($form, 'CustomText', ['rows' => '1', 'class' => 'form-control']);?>
    </div>
</div>
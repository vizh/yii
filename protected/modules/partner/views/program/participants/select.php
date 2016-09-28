<?php
use company\models\Company;
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
    <li <?if($active === 'user'):?>class="active"<?endif?>>
        <a data-toggle="tab" href="#<?=$userTabId?>">Пользователь</a>
    </li>
    <li <?if($active === 'company'):?>class="active"<?endif?>>
        <a data-toggle="tab" href="#<?=$companyTabId?>">Компания</a>
    </li>
    <li <?if($active === 'custom'):?>class="active"<?endif?>>
        <a data-toggle="tab" href="#<?=$customTabId?>">Произвольный текст</a>
    </li>
</ul>
<div class="tab-content tab-content-bordered">
    <div id="<?=$userTabId?>" class="tab-pane <?if($active === 'user'):?>active<?endif?>">
        <?$this->widget('\partner\widgets\UserAutocompleteInput', [
            'form' =>  $form,
            'attribute' => 'RunetId'
        ])?>
    </div>
    <div id="<?=$companyTabId?>" class="tab-pane <?if($active === 'company'):?>active<?endif?>">
        <?$this->widget('\application\widgets\AutocompleteInput', [
            'model' =>  $form,
            'attribute' => 'CompanyId',
            'source' => '/company/ajax/search/',
            'label' => function ($value) {
                return Company::findOne($value)->FullName;
            },
            'htmlOptions' => ['class' => 'form-control']
        ])?>
    </div>
    <div id="<?=$customTabId?>" class="tab-pane <?if($active === 'custom'):?>active<?endif?>">
        <?=CHtml::activeTextArea($form, 'CustomText', ['rows' => '1', 'class' => 'form-control'])?>
    </div>
</div>
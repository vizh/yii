<?/**
 * @var Resume $modelForm
 * @var CActiveForm $form
 */
use raec\models\forms\brief\Resume;
?>
<?$form = $this->beginWidget('CActiveForm');?>
<?=$form->errorSummary($modelForm, '<div class="alert alert-error">', '</div>');?>
<div class="row m-bottom_40">
    <div class="span12">
        <?=$form->label($modelForm, 'Year');?>
        <?=$form->textField($modelForm, 'Year', ['class' => 'input-small']);?>
    </div>
</div>

<div class="frame">
    <h4><?=$modelForm->getAttributeLabel('ProfessionalInterest');?></h4>
    <div class="row-fluid">
        <?foreach ($modelForm->getProfessionalInterestData() as $id => $title):?>
            <div class="pull-left" style="width: 50%;">
                <label class="checkbox">
                    <?=$form->checkBox($modelForm, 'ProfessionalInterest[]', ['value' => $id, 'uncheckValue' => null, 'checked' => in_array($id, $modelForm->ProfessionalInterest)]);?> <?=$title;?>
                </label>
            </div>
        <?endforeach;?>
    </div>
</div>

<div class="row">
    <div class="span12">
        <?=$form->label($modelForm, 'Progress');?>
        <?=$form->textArea($modelForm, 'Progress', ['class' => 'input-block-level']);?>
    </div>
</div>

<div class="row">
    <div class="span12">
        <?=$form->label($modelForm, 'Employees');?>
        <?=$form->textArea($modelForm, 'Employees', ['class' => 'input-block-level']);?>
    </div>
</div>

<div class="row">
    <div class="span12">
        <?=$form->label($modelForm, 'Customers');?>
        <?=$form->textArea($modelForm, 'Customers', ['class' => 'input-block-level']);?>
    </div>
</div>

<div class="row">
    <div class="span12">
        <?=$form->label($modelForm, 'Additional');?>
        <?=$form->textArea($modelForm, 'Additional', ['class' => 'input-block-level']);?>
    </div>
</div>
<hr/>
<div class="row">
    <div class="span12 text-center">
        <?=\CHtml::submitButton(\Yii::t('app', 'Следующий шаг'), ['class' => 'btn btn-success btn-large']);?>
    </div>
</div>
<?=$this->getNextActionInput();?>
<?$this->endWidget();?>

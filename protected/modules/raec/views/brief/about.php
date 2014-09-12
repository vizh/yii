<?
/**
 * @var About $modelForm
 * @var CActiveForm $form
 */

use raec\models\forms\brief\About;
?>

<?if (!empty($modelForm->CompanySynonyms)):?>
    <script type="text/javascript">
        var companySynonyms = [];
        <?foreach ($modelForm->CompanySynonyms as $synonym):?>
            var synonym = {
                'Id' : '<?=$synonym['Id'];?>',
                'Label' : '<?=$synonym['Label'];?>'
            }
            companySynonyms.push(synonym);
        <?endforeach;?>
    </script>
<?endif;?>

<?$form = $this->createWidget('CActiveForm');?>
<?=$form->errorSummary($modelForm, '<div class="alert alert-error">', '</div>');?>
<div class="row m-bottom_50">
    <div class="span12">
        <?=$form->label($modelForm, 'CompanyLabel');?>
        <?=$form->textField($modelForm, 'CompanyLabel', ['class' => 'input-block-level']);?>
        <?=$form->hiddenField($modelForm, 'CompanyId');?>
    </div>
    <div class="span12 company-synonyms">
        <?=$form->label($modelForm, 'CompanySynonyms');?>
        <a href="#" class="btn btn-small add"><?=\Yii::t('app', 'добавить');?></a>
    </div>
</div>

<div class="frame">
    <h4><?=\Yii::t('app', 'Информация о руководителе');?></h4>
    <div class="row-fluid">
        <div class="span4">
            <?=$form->label($modelForm, 'CEOLastName');?>
            <?=$form->textField($modelForm, 'CEOLastName', ['class' => 'input-block-level']);?>
        </div>
        <div class="span4">
            <?=$form->label($modelForm, 'CEOFirstName');?>
            <?=$form->textField($modelForm, 'CEOFirstName', ['class' => 'input-block-level']);?>
        </div>
        <div class="span4">
            <?=$form->label($modelForm, 'CEOFatherName');?>
            <?=$form->textField($modelForm, 'CEOFatherName', ['class' => 'input-block-level']);?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <?=$form->label($modelForm, 'CEOPosition');?>
            <?=$form->textField($modelForm, 'CEOPosition', ['class' => 'input-block-level']);?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <?=$form->label($modelForm, 'CEOPositionBase');?>
            <?=$form->textField($modelForm, 'CEOPositionBase', ['class' => 'input-block-level']);?>
        </div>
    </div>
</div>

<div class="frame">
    <h4><?=\Yii::t('app', 'Информация о бухгалтере');?></h4>
    <div class="row-fluid">
        <div class="span4">
            <?=$form->label($modelForm, 'BookerLastName');?>
            <?=$form->textField($modelForm, 'BookerLastName', ['class' => 'input-block-level']);?>
        </div>
        <div class="span4">
            <?=$form->label($modelForm, 'BookerFirstName');?>
            <?=$form->textField($modelForm, 'BookerFirstName', ['class' => 'input-block-level']);?>
        </div>
        <div class="span4">
            <?=$form->label($modelForm, 'BookerFatherName');?>
            <?=$form->textField($modelForm, 'BookerFatherName', ['class' => 'input-block-level']);?>
        </div>
    </div>
</div>

<div class="frame m-bottom_20">
    <h4><?=\Yii::t('app', 'Реквизиты организации');?></h4>
    <div class="row-fluid">
        <div class="span2">
            <?=$form->label($modelForm, 'JuridicalOPF');?>
            <?=$form->dropDownList($modelForm, 'JuridicalOPF', $modelForm->getJuridicalOPFData(), ['class' => 'input-block-level']);?>
        </div>
        <div class="span10">
            <?=$form->label($modelForm, 'JuridicalShortName');?>
            <?=$form->textField($modelForm, 'JuridicalShortName', ['class' => 'input-block-level']);?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <?=$form->label($modelForm, 'JuridicalFullName');?>
            <?=$form->textField($modelForm, 'JuridicalFullName', ['class' => 'input-block-level']);?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <?=$form->label($modelForm, 'JuridicalAddress');?>
            <?=$form->textArea($modelForm, 'JuridicalAddress', ['class' => 'input-block-level']);?>
        </div>
        <div class="span6">
            <div class="clearfix">
                <?=$form->label($modelForm, 'JuridicalAddressActual', ['class' => 'pull-left']);?>
                <label class="checkbox pull-right">
                    <?=$form->checkBox($modelForm, 'JuridicalAddressEqual');?> <?=$modelForm->getAttributeLabel('JuridicalAddressEqual');?>
                </label>
            </div>
            <?=$form->textArea($modelForm, 'JuridicalAddressActual', ['class' => 'input-block-level']);?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span4">
            <?=$form->label($modelForm, 'JurudicalINN');?>
            <?=$form->textField($modelForm, 'JurudicalINN', ['class' => 'input-block-level']);?>
        </div>
        <div class="span4">
            <?=$form->label($modelForm, 'JurudicalOGRN');?>
            <?=$form->textField($modelForm, 'JurudicalOGRN', ['class' => 'input-block-level']);?>
        </div>
        <div class="span4">
            <?=$form->label($modelForm, 'JurudicalOGRNDate');?>
            <?=$form->textField($modelForm, 'JurudicalOGRNDate', ['class' => 'input-block-level']);?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span4">
            <?=$form->label($modelForm, 'JurudicalBIK');?>
            <?=$form->textField($modelForm, 'JurudicalBIK', ['class' => 'input-block-level']);?>
        </div>
        <div class="span4">
            <?=$form->label($modelForm, 'JuridicalKPP');?>
            <?=$form->textField($modelForm, 'JuridicalKPP', ['class' => 'input-block-level']);?>
        </div>
        <div class="span4">
            <?=$form->label($modelForm, 'JuridicalBankName');?>
            <?=$form->textField($modelForm, 'JuridicalBankName', ['class' => 'input-block-level']);?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <?=$form->label($modelForm, 'JurudicalAccount');?>
            <?=$form->textField($modelForm, 'JurudicalAccount', ['class' => 'input-block-level']);?>
        </div>
        <div class="span6">
            <?=$form->label($modelForm, 'JurudicalCorrAccount');?>
            <?=$form->textField($modelForm, 'JurudicalCorrAccount', ['class' => 'input-block-level']);?>
        </div>
    </div>
</div>

<div class="row">
    <div class="span12 text-center">
        <?=\CHtml::submitButton(\Yii::t('app', 'Далее'), ['class' => 'btn btn-success']);?>
    </div>
</div>

<script type="text/template" id="company-synonym-tpl">
    <div class="row-fluid">
        <div class="span6">
            <input type="text" class="input-block-level" name="<?=\CHtml::activeName($modelForm, 'CompanySynonyms');?>[<%=i%>][Label]" value="<%=Label%>" />
            <input type="hidden" name="<?=\CHtml::activeName($modelForm, 'CompanySynonyms');?>[<%=i%>][Id]" value="<%=Id%>" />
        </div>
        <div class="span2">
            <a href="" class="btn btn-danger"><?=\Yii::t('app', 'Удалить');?></a>
        </div>
    </div>
</script>
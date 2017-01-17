<?
/**
 * @var string $backUrl
 * @var \user\models\forms\admin\User $form
 * @var \application\components\controllers\AdminMainController $this
 * @var CActiveForm $activeForm
 */

$clientScript = \Yii::app()->getClientScript();
$clientScript->registerPackage('runetid.backbone');
$clientScript->registerPackage('runetid.jquery.inputmask-multi');
$this->setPageTitle(\Yii::t('app', 'Редатирование данных пользователя'));

use application\helpers\Flash;
use application\components\utility\Texts;
?>
<script type="text/javascript">
    var phones = [];
    <?foreach($form->Phones as $phone):?>
    var phone = {
        'Id' : '<?=$phone->Id?>',
        'Phone' : '<?=$phone->OriginalPhone?>',
        'Type' : '<?=$phone->Type?>',
        'Delete' : '<?=$phone->Delete?>'
    };
    <?if($phone->hasErrors()):?>
    phone.Errors = <?=json_encode($phone->getErrors())?>;
    <?endif?>
    phones.push(phone);
    <?endforeach?>

    var employments = [];
    <?foreach($form->Employments as $employment):?>
    var employment = {
        'Id'         : '<?=$employment->Id?>',
        'Company'    : '<?=\CHtml::encode($employment->Company)?>',
        'Position'   : '<?=\CHtml::encode($employment->Position)?>',
        'StartMonth' : '<?=$employment->StartMonth?>',
        'StartYear'  : '<?=$employment->StartYear?>',
        'EndMonth'   : '<?=$employment->EndMonth?>',
        'EndYear'    : '<?=$employment->EndYear?>',
        'Primary'    : '<?=$employment->Primary?>',
        'Delete'     : '<?=$employment->Delete?>'
    };
    <?if($employment->hasErrors()):?>
    employment.Errors = <?=json_encode($employment->getErrors())?>;
    <?endif?>
    employments.push(employment);
    <?endforeach?>
</script>

<?$activeForm = $this->beginWidget('CActiveForm', ['htmlOptions' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']])?>
<div class="btn-toolbar">
    <?if(!empty($backUrl)):?>
        <?=\CHtml::link(\Yii::t('app', '&larr; Вернуться'), $backUrl, ['class' => 'btn'])?>
    <?endif?>
    <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить изменения'), ['class' => 'btn btn-success pull-right'])?>
</div>
<div class="well">
    <?=Flash::html()?>
    <?=$activeForm->errorSummary($form, '<div class="alert alert-error">', '</div>')?>
    <?if($form->isUpdateMode()):?>
        <div class="control-group">
            <label class="control-label">Дата регистрации</label>
            <div class="controls m-top_5">
                <strong><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm', $form->getActiveRecord()->CreationTime)?></strong>
            </div>
        </div>

        <div class="control-group">
            <?=$activeForm->label($form, 'RunetId', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'RunetId', ['class' => 'input-xlarge'])?>
                <p class="help-inline">Внимание! При изменении RUNET-ID фото пользователя будет удалено.</p>
            </div>
        </div>
    <?endif?>

    <div class="control-group">
        <?=$activeForm->label($form, 'FirstName', ['class' => 'control-label'])?>
        <div class="controls">
            <?foreach($form->getLocaleList() as $locale):?>
                <div class="input-append">
                    <?=$activeForm->textField($form, 'FirstName['  . $locale . ']')?>
                    <span class="add-on"><?=$locale?></span>
                </div>
            <?endforeach?>
        </div>
    </div>

    <div class="control-group">
        <?=$activeForm->label($form, 'LastName', ['class' => 'control-label'])?>
        <div class="controls">
            <?foreach($form->getLocaleList() as $locale):?>
                <div class="input-append">
                    <?=$activeForm->textField($form, 'LastName['  . $locale . ']')?>
                    <span class="add-on"><?=$locale?></span>
                </div>
            <?endforeach?>
        </div>
    </div>

    <div class="control-group">
        <?=$activeForm->label($form, 'FatherName', ['class' => 'control-label'])?>
        <div class="controls">
            <?foreach($form->getLocaleList() as $locale):?>
                <div class="input-append">
                    <?=$activeForm->textField($form, 'FatherName['  . $locale . ']')?>
                    <span class="add-on"><?=$locale?></span>
                </div>
            <?endforeach?>
        </div>
    </div>

    <div class="control-group">
        <?=$activeForm->label($form, 'Email', ['class' => 'control-label'])?>
        <div class="controls">
            <?=$activeForm->textField($form, 'Email', ['class' => 'input-xlarge'])?>
            <?if(!$form->isUpdateMode()):?>
                <p class="help-inline">Если поле заполнено пользователю будет отправлено письмо с оповещением о регистрации. Если оставить пустым будет сгенерирован случайный email</p>
            <?endif?>
        </div>
    </div>

    <div class="control-group employments">
        <?=$activeForm->label($form, 'Employments', ['class' => 'control-label'])?>
        <div class="controls">
            <div class="m-top_5 add">
                <a href="#" class="pseudo-link iconed-link"><i class="icon-plus-sign"></i> <span>Добавить место работы</span></a>
            </div>
        </div>
    </div>

    <div class="control-group">
        <?=$activeForm->label($form, 'PrimaryPhone', ['class' => 'control-label'])?>
        <div class="controls">
            <?=$activeForm->textField($form, 'PrimaryPhone', ['class' => 'input-xlarge'])?>
            <?if(!empty($form->getActiveRecord()->PrimaryPhone)):?>
                <?if($form->getActiveRecord()->PrimaryPhoneVerify):?>
                    <span class="label label-success">Подтвержден</span>
                <?else:?>
                    <span class="label label-danger">Не подтвержден</span>
                <?endif?>
            <?endif?>
        </div>
    </div>

    <div class="control-group phones">
        <?=$activeForm->label($form, 'Phones', ['class' => 'control-label'])?>
        <div class="controls">
            <div class="m-top_5 add">
                <a href="#" class="pseudo-link iconed-link"><i class="icon-plus-sign"></i> <span><?=\Yii::t('app', 'Добавить номер телефона')?></span></a>
            </div>
        </div>
    </div>

    <div class="control-group">
        <?=$activeForm->label($form, 'Address', ['class' => 'control-label'])?>
        <?$this->widget('\contact\widgets\AddressControls', ['form' => $form->Address, 'address' => false, 'place' => false])?>
    </div>

    <div class="control-group">
        <?=$activeForm->label($form, 'Visible', ['class' => 'control-label'])?>
        <div class="controls">
            <?=$activeForm->checkBox($form, 'Visible')?>
        </div>
    </div>

    <div class="control-group">
        <?=$activeForm->label($form, 'Subscribe', ['class' => 'control-label'])?>
        <div class="controls">
            <?=$activeForm->checkBox($form, 'Subscribe')?>
        </div>
    </div>

    <div class="control-group password">
        <?=$activeForm->label($form, 'NewPassword', ['class' => 'control-label'])?>
        <div class="controls">
            <?=$activeForm->textField($form, 'NewPassword')?>
            <?if(!$form->isUpdateMode()):?>
                <p class="help-inline">
                    Если оставить поле пустым будет сгенерирован случайный пароль.
                </p>
            <?endif?>
            <?if(empty($form->NewPassword)):?>
                <p><small><?=\CHtml::link('Вставить случайный', '#', ['data-password' => Texts::GeneratePassword(\Yii::app()->params['UserPasswordMinLenght'])])?></small></p>
            <?endif?>
        </div>
    </div>

    <?if($form->isUpdateMode()):?>
        <div class="control-group">
            <?=$activeForm->label($form, 'Photo', ['class' => 'control-label'])?>
            <div class="controls">
                <label class="checkbox">
                    <?=$activeForm->checkBox($form, 'DeletePhoto')?> <?=$form->getAttributeLabel('DeletePhoto')?>
                </label>
                <div class="help-block"><img src="<?=$user->getPhoto()->get50px()?>" /></div>
                <?=$activeForm->fileField($form, 'Photo')?>
            </div>
        </div>
    <?endif?>
</div>
<?$this->endWidget()?>


<script type="text/template" id="phone-item-tpl">
    <div class="m-bottom_5 phone">
        <input type="text" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][OriginalPhone]')?>" class="input-xlarge" />
        <select name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Type]')?>" class="input-medium">
            <?foreach($form->getPhoneTypeData() as $type => $title):?>
                <option value="<?=$type?>"><?=$title?></option>
            <?endforeach?>
        </select>
        <a href="#" class="pseudo-link delete-phone-link" data-action="remove"><?=\Yii::t('app', 'Удалить')?></a>
        <input type="hidden" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Delete]')?>"/>
    </div>
</script>

<script type="text/template" id="phone-item-withdata-tpl">
    <div class="m-bottom_5 <%if(Delete == 1){%>hide<%}%> phone">
        <%if(typeof Errors != "undefined"){%>
            <div class="alert alert-error errorSummary"></div>
        <%}%>
        <input type="text" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][OriginalPhone]')?>" class="input-xlarge" value="<%=Phone%>" />
        <select name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Type]')?>" class="input-medium">
            <?foreach($form->getPhoneTypeData() as $type => $title):?>
                <option value="<?=$type?>" <%if(Type == '<?=$type?>'){%>selected="selected"<%}%>><?=$title?></option>
            <?endforeach?>
        </select>
        <a href="#" class="pseudo-link delete-phone-link" data-action="remove"><?=\Yii::t('app', 'Удалить')?></a>
        <%if(Id != ''){%>
            <input type="hidden" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Id]')?>" value="<%=Id%>"/>
        <%}%>
        <input type="hidden" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Delete]')?>" <%if(Delete == 1){%>value="1"<%}%>/>
    </div>
</script>

<script type="text/template" id="career-item-tpl">
    <div class="m-bottom_10 m-top_5 well">
        <div class="form-row">
            <?=\CHtml::activeLabel($form, 'Company')?>
            <div class="form-inline">
                <input type="text" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Company]')?>" value="" class="span5"/>
                <label class="radio">
                    <input type="radio" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Primary]')?>" value="1"> <?=$form->getAttributeLabel('Primary')?>
                </label>
            </div>
        </div>
        <div class="form-row">
            <?=\CHtml::activeLabel($form, 'Position', ['class' => 'm-top_5'])?>
            <input type="text" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Position]')?>" value="" class="span5"/>
        </div>
        <div class="form-row form-row-date">
            <label><?=\CHtml::activeLabel($form, 'Date', ['class' => 'm-top_5'])?></label>
            <div class="form-inline">
                <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][StartMonth]')?>">
                    <?=$form->getEmploymentsMonthOptions()?>
                </select>
                <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][StartYear]')?>">
                    <?=$form->getEmploymentsYearOptions()?>
                </select>
                <span class="mdash">&mdash;</span>
                <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][EndMonth]')?>">
                    <?=$form->getEmploymentsMonthOptions()?>
                </select>
                <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][EndYear]')?>">
                    <?=$form->getEmploymentsYearOptions()?>
                </select>
                <label class="checkbox">
                    <input type="checkbox" /> <?=\Yii::t('app', 'По настоящее время')?>
                </label>
            </div>
        </div>
        <div class="form-row form-row-remove m-top_5">
            <a href="#" class="pseudo-link iconed-link" data-action="remove"><i class="icon-minus-sign"></i> <span><?=\Yii::t('app', 'Удалить')?></span></a>
        </div>
        <input type="hidden" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Delete]')?>" value="" />
    </div>
</script>

<script type="text/template" id="career-item-withdata-tpl">
    <div class="m-bottom_10 m-top_5 <%if(Delete == 1){%>hide<%}%> <%if(Primary == true){%>primary<%}%> well">
        <%if(typeof Errors != "undefined"){%>
            <div class="alert alert-error errorSummary"></div>
        <%}%>
        <div class="form-row">
            <?=\CHtml::activeLabel($form, 'Company')?>
            <div class="form-inline">
                <input type="text" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Company]')?>" value="<%=Company%>" class="span5"/>
                <label class="radio">
                    <input type="radio" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Primary]')?>" <%if(Primary == true){%>checked<%}%> value="1"> <?=$form->getAttributeLabel('Primary')?>
                </label>
            </div>
        </div>
        <div class="form-row">
            <?=\CHtml::activeLabel($form, 'Position', ['class' => 'm-top_5'])?>
            <input type="text" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Position]')?>" value="<%=Position%>" class="span5"/>
        </div>
        <div class="form-row form-row-date">
            <label class="m-top_5"><?=\CHtml::activeLabel($form, 'Date')?></label>
            <div class="form-inline">
                <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][StartMonth]')?>" data-selected="<%=StartMonth%>">
                    <?=$form->getEmploymentsMonthOptions()?>
                </select>
                <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][StartYear]')?>" data-selected="<%=StartYear%>">
                    <?=$form->getEmploymentsYearOptions()?>
                </select>
                <span class="mdash">&mdash;</span>
                <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][EndMonth]')?>" data-selected="<%=EndMonth%>">
                    <?=$form->getEmploymentsMonthOptions()?>
                </select>
                <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][EndYear]')?>" data-selected="<%=EndYear%>">
                    <?=$form->getEmploymentsYearOptions()?>
                </select>
                <label class="checkbox">
                    <input type="checkbox" <%if(EndMonth == '' && EndYear == ''){%>checked<%}%>/> <?=\Yii::t('app', 'По настоящее время')?>
                </label>
            </div>
        </div>
        <div class="form-row form-row-remove m-top_5">
            <a href="#" class="pseudo-link iconed-link" data-action="remove"><i class="icon-minus-sign"></i> <span><?=\Yii::t('app', 'Удалить')?></span></a>
        </div>
        <%if(Id != ''){%>
            <input type="hidden" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Id]')?>" value="<%=Id%>" />
        <%}%>
        <input type="hidden" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Delete]')?>" value="" />
    </div>
</script>
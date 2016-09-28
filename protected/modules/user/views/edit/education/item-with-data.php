<?php
/**
 * @var Educations $form
 */

use education\models\Degree;
use user\models\forms\edit\Educations;

$degrees = array_merge(['' => 'Выберите степень'], Degree::getAll())
?>

<script type="text/template" id="education-item-withdata-tpl">
    <div class="user-career-item <%if(Delete == 1){%>hide<%}%>">
        <%if(typeof Errors != "undefined"){%>
        <div class="alert alert-error errorSummary"></div>
        <%}%>
        <div class="form-row">
            <?=\CHtml::activeLabel($form, 'CityName')?>
            <input type="text" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][CityName]')?>" value="<%=CityName%>" class="span5" data-default-source='<?=$form->getCityDefaultSource()?>'/>
            <input type="hidden" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][CityId]')?>" value="<%=CityId%>"/>
        </div>
        <div class="form-row">
            <?=\CHtml::activeLabel($form, 'UniversityName')?>
            <input type="text" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][UniversityName]')?>" value="<%=UniversityName%>" class="span5"/>
            <input type="hidden" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][UniversityId]')?>" value="<%=UniversityId%>" class="span5"/>
        </div>
        <div class="form-row">
            <?=\CHtml::activeLabel($form, 'FacultyName')?>
            <input type="text" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][FacultyName]')?>" value="<%=FacultyName%>" class="span5"/>
            <input type="hidden" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][FacultyId]')?>" value="<%=FacultyId%>" class="span5"/>
        </div>
        <div class="form-row">
            <?=\CHtml::activeLabel($form, 'Specialty')?>
            <input type="text" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][Specialty]')?>" value="<%=Specialty%>" class="span5"/>
        </div>
        <div class="form-row form-row-date">
            <label><?=\CHtml::activeLabel($form, 'EndYear')?></label>
            <div class="form-inline">
                <?=CHtml::dropDownList(CHtml::activeName($form, 'educations[<%=i%>][EndYear]'), null, $form->getEndYearsRange(), [
                    'encode' => false,
                    'data-selected' => '<%=EndYear%>'
                ])?>
                <label class="checkbox">
                    <input type="checkbox" <%if(EndYear == null){%>checked<%}%>/> <?=\Yii::t('app', 'Продолжаю учиться')?>
                </label>
            </div>
        </div>
        <div class="form-row">
            <label><?=\CHtml::activeLabel($form, 'Degree')?></label>
            <?=CHtml::dropDownList(CHtml::activeName($form, 'educations[<%=i%>][Degree]'), null, $degrees, [
                'encode' => false,
                'data-selected' => '<%=Degree%>'
            ])?>
        </div>
        <div class="form-row form-row-remove">
            <a href="#" class="pseudo-link iconed-link" data-action="remove"><i class="icon-minus-sign"></i> <span><?=\Yii::t('app', 'Удалить')?></span></a>
        </div>
        <%if(Id != null){%>
        <input type="hidden" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][Id]')?>" value="<%=Id%>" />
        <%}%>
        <input type="hidden" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][Delete]')?>" value="" />
    </div>
</script>
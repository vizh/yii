<?php
/**
 * @var Educations $form
 */
use education\models\Degree;
use user\models\forms\edit\Educations;
$degrees = array_merge(['' => 'Выберите степень'], Degree::getAll())
?>

<script type="text/template" id="education-item-tpl">
    <div class="user-career-item">
        <%if(typeof Errors != "undefined"){%>
            <div class="alert alert-error errorSummary"></div>
        <%}%>
        <div class="form-row">
            <?=\CHtml::activeLabel($form, 'CityName')?>
            <input type="text" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][CityName]')?>" value="" class="span5" placeholder="<?=\Yii::t('app', 'Не выбран')?>" data-default-source='<?=$form->getCityDefaultSource()?>'/>
            <input type="hidden" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][CityId]')?>" value=""/>
        </div>
        <div class="form-row">
            <?=\CHtml::activeLabel($form, 'UniversityName')?>
            <input type="text" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][UniversityName]')?>" value="" class="span5" disabled="disabled"/>
            <input type="hidden" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][UniversityId]')?>" value="" class="span5"/>
        </div>
        <div class="form-row">
            <?=\CHtml::activeLabel($form, 'FacultyName')?>
            <input type="text" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][FacultyName]')?>" value="" class="span5" disabled="disabled"/>
            <input type="hidden" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][FacultyId]')?>" value="" class="span5"/>
        </div>
        <div class="form-row">
            <?=\CHtml::activeLabel($form, 'Specialty')?>
            <input type="text" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][Specialty]')?>" value="" class="span5" disabled="disabled"/>
        </div>
        <div class="form-row form-row-date">
            <label><?=\CHtml::activeLabel($form, 'EndYear')?></label>
            <div class="form-inline">
                <?=CHtml::dropDownList(CHtml::activeName($form, 'educations[<%=i%>][EndYear]'), null, $form->getEndYearsRange(), [
                    'encode' => false
                ])?>
                <label class="checkbox">
                    <input type="checkbox" /> <?=\Yii::t('app', 'Продолжаю учиться')?>
                </label>
            </div>
        </div>
        <div class="form-row">
            <label><?=\CHtml::activeLabel($form, 'Degree')?></label>
            <?=CHtml::dropDownList(CHtml::activeName($form, 'educations[<%=i%>][Degree]'), null, $degrees, [
                'encode' => false
            ])?>
        </div>
        <div class="form-row form-row-remove">
            <a href="#" class="pseudo-link iconed-link" data-action="remove"><i class="icon-minus-sign"></i> <span><?=\Yii::t('app', 'Удалить')?></span></a>
        </div>
        <input type="hidden" name="<?=\CHtml::activeName($form, 'educations[<%=i%>][Delete]')?>" value="" />
    </div>
</script>


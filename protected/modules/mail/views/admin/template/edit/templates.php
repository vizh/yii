<?php
/**
 * @var \application\components\controllers\AdminMainController $this
 * @var Template $form
 * @var \application\widgets\ActiveForm $activeForm
 */

use \mail\models\forms\admin\Template;
?>

<script type="text/template" id="event-criteria-tpl">
    <div class="row-fluid m-top_20">
        <div class="span7">
            <?=$activeForm->textField($form, 'Conditions[<%=i%>][eventLabel]', ['class' => 'input-block-level', 'placeholder' => 'Мероприятие']);?>
            <?=$activeForm->hiddenField($form, 'Conditions[<%=i%>][eventId]');?>
        </div>
        <div class="span3">
            <?=$activeForm->textField($form, 'Conditions[<%=i%>][rolesSearch]', ['class' => 'input-block-level', 'placeholder' => 'Роли', 'data-source' => json_encode($form->getEventRolesData())]);?>
        </div>
        <div class="span2">
            <?=$activeForm->dropDownList($form, 'Conditions[<%=i%>][type]', $form->getTypeData(), ['class' => 'input-block-level']);?>
            <button name="" class="btn btn-danger m-top_5" type="button">Удалить</button>
        </div>
        <?=$activeForm->hiddenField($form, 'Conditions[<%=i%>][by]', ['value' => Template::ByEvent]);?>
    </div>
</script>

<script type="text/template" id="email-criteria-tpl">
    <div class="row-fluid m-top_20">
        <div class="span10">
            <?=$activeForm->textArea($form, 'Conditions[<%=i%>][emails]', ['class' => 'input-block-level', 'placeholder' => 'Список E-mail через запятую']);?>
        </div>
        <div class="span2">
            <?=$activeForm->dropDownList($form, 'Conditions[<%=i%>][type]', $form->getTypeData(), ['class' => 'input-block-level']);?>
            <button name="" class="btn btn-danger m-top_5" type="button">Удалить</button>
        </div>
        <?=$activeForm->hiddenField($form, 'Conditions[<%=i%>][by]', ['value' => Template::ByEmail]);?>
    </div>
</script>

<script type="text/template" id="runetid-criteria-tpl">
    <div class="row-fluid m-top_20">
        <div class="span10">
            <?=$activeForm->textArea($form, 'Conditions[<%=i%>][runetIdList]', ['class' => 'input-block-level', 'placeholder' => 'Список RUNET-ID через запятую']);?>
        </div>
        <div class="span2">
            <?=$activeForm->dropDownList($form, 'Conditions[<%=i%>][type]', $form->getTypeData(), ['class' => 'input-block-level']);?>
            <button name="" class="btn btn-danger m-top_5" type="button">Удалить</button>
        </div>
        <?=$activeForm->hiddenField($form, 'Conditions[<%=i%>][by]', ['value' => Template::ByRunetId]);?>
    </div>
</script>

<script type="text/template" id="geo-criteria-tpl">
    <div class="row-fluid m-top_20">
        <div class="span10">
            <?=$activeForm->textField($form, 'Conditions[<%=i%>][label]', ['class' => 'input-block-level', 'placeholder' => 'Город или регион']);?>
        </div>
        <div class="span2">
            <?=$activeForm->dropDownList($form, 'Conditions[<%=i%>][type]', $form->getTypeData(), ['class' => 'input-block-level']);?>
            <button name="" class="btn btn-danger m-top_5" type="button">Удалить</button>
        </div>
        <?=$activeForm->hiddenField($form, 'Conditions[<%=i%>][regionId]');?>
        <?=$activeForm->hiddenField($form, 'Conditions[<%=i%>][countryId]');?>
        <?=$activeForm->hiddenField($form, 'Conditions[<%=i%>][cityId]');?>

        <?=$activeForm->hiddenField($form, 'Conditions[<%=i%>][by]', ['value' => Template::ByGeo]);?>
    </div>
</script>

<?php
/**
 * @var \mail\models\Template $template
 * @var bool $viewHasExternalChanges
 */
use mail\models\forms\admin\Template;

?>
    <script type="text/javascript">
        $(function () {
            TemplateEdit.roles = <?=json_encode($form->getEventRolesData());?>;
            <?foreach ($form->Conditions as $condition):?>
            <?
            switch($condition['by']):
              case Template::ByEvent: echo 'TemplateEdit.createEventCriteria('.json_encode($condition).');';
                break;
              case Template::ByEmail: echo 'TemplateEdit.createEmailCriteria('.json_encode($condition).');';
                break;
              case Template::ByRunetId: echo 'TemplateEdit.createRunetIdCriteria('.json_encode($condition).');';
                break;
              case Template::ByGeo: echo 'TemplateEdit.createGeoCriteria('.json_encode($condition).');';
                break;
            endswitch;
            ?>
            <?endforeach;?>

            <?if ($template->Active):?>
                $('form.form-horizontal input, form.form-horizontal textarea, form.form-horizontal select').attr('disabled', 'disabled');
            <?endif;?>
        });
    </script>

<?=\CHtml::beginForm('', 'POST', ['class' => 'form-horizontal']);?>
    <div class="btn-toolbar">
        <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']);?>
    </div>
    <div class="well">
        <?if (\Yii::app()->getUser()->hasFlash('success')):?>
            <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
        <?endif;?>
        <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>

        <?if ($template->Active && $template->Success):?>
            <h3 class="text-success"><?=\Yii::t('app', 'Рассылка ушла. Всего писем: {n}', ['{n}' => $countAll]);?></h3>
        <?elseif ($template->Active && !$template->Success):?>
            <h3><?=\Yii::t('app', 'Рассылка отправляется. Осталось {n} писем из {n1}.', ['{n}' => $count, '{n1}' => $countAll]);?></h3>
        <?else:?>
            <h3><?=\Yii::t('app', 'Получателей');?>: <?=$countAll;?></h3>
        <?endif;?>


        <h3><?=\Yii::t('app', 'Параметры рассылки');?></h3>
        <div class="control-group">
            <?=\CHtml::activeLabel($form, 'Title', ['class' => 'control-label']);?>
            <div class="controls">
                <?=\CHtml::activeTextField($form, 'Title', ['class' => 'span4']);?>
            </div>
        </div>
        <div class="control-group">
            <?=\CHtml::activeLabel($form, 'Subject', ['class' => 'control-label']);?>
            <div class="controls">
                <?=\CHtml::activeTextField($form, 'Subject', ['class' => 'span4']);?>
            </div>
        </div>
        <div class="control-group">
            <?=\CHtml::activeLabel($form, 'From', ['class' => 'control-label']);?>
            <div class="controls">
                <?=\CHtml::activeTextField($form, 'From', ['class' => 'span4']);?>
            </div>
        </div>
        <div class="control-group">
            <?=\CHtml::activeLabel($form, 'FromName', ['class' => 'control-label']);?>
            <div class="controls">
                <?=\CHtml::activeTextField($form, 'FromName', ['class' => 'span4']);?>
            </div>
        </div>
        <div class="control-group">
            <?=\CHtml::activeLabel($form, 'SendPassbook', ['class' => 'control-label']);?>
            <div class="controls">
                <?=\CHtml::activeCheckBox($form, 'SendPassbook');?>
            </div>
        </div>
        <div class="control-group">
            <?=\CHtml::activeLabel($form, 'SendUnsubscribe', ['class' => 'control-label']);?>
            <div class="controls">
                <?=\CHtml::activeCheckBox($form, 'SendUnsubscribe');?>
            </div>
        </div>
        <div class="control-group">
            <?=\CHtml::activeLabel($form, 'ShowUnsubscribeLink', ['class' => 'control-label']);?>
            <div class="controls">
                <?=\CHtml::activeCheckBox($form, 'ShowUnsubscribeLink');?>
            </div>
        </div>
        <div class="control-group">
            <?=\CHtml::activeLabel($form, 'ShowFooter', ['class' => 'control-label']);?>
            <div class="controls">
                <?=\CHtml::activeCheckBox($form, 'ShowFooter');?>
            </div>
        </div>
        <div class="control-group">
            <?=\CHtml::activeLabel($form, 'SendInvisible', ['class' => 'control-label']);?>
            <div class="controls">
                <?=\CHtml::activeCheckBox($form, 'SendInvisible');?>
            </div>
        </div>
        <div class="control-group">
            <?=\CHtml::activeLabel($form, 'Layout', ['class' => 'control-label']);?>
            <div class="controls">
                <?=\CHtml::activeDropDownList($form, 'Layout', $form->getLayoutData());?>
            </div>
        </div>

        <div class="control-group">
            <?=\CHtml::activeLabel($form, 'Body', ['class' => 'control-label']);?>
            <div class="controls">
                <?if (!$viewHasExternalChanges):?>
                    <?=\CHtml::activeTextArea($form, 'Body', ['class' => 'input-block-level', 'style' => 'height: 500px;']);?>
                    <p class="m-top_10 muted">
                        <?foreach ($form->bodyFieldLabels() as $field => $label):?>
                            <?=$field?> &mdash; <?=$label;?><br/>
                        <?endforeach;?>
                    </p>
                <?else:?>
                    <div class="alert alert-info"><?=\Yii::t('app', 'Шаблон письма притерпел внешние изменения. Отредактируйте его через PHP редактор. Путь к шаблону: <strong>{path}</strong>', ['{path}' => $template->getViewPath()]);?></div>
                <?endif;?>
            </div>
        </div>

        <?=\CHtml::activeHiddenField($form, 'Active', ['value' => (int) $form->Active]);?>
        <?if ($form->Active == 0):?>
            <div class="control-group m-top_40">
                <?=\CHtml::activeLabel($form, 'Active', ['class' => 'control-label text-error']);?>
                <div class="controls">
                    <input type="checkbox" id="confirm-template" />
                    <p class="m-top_5 text-error"><?=\Yii::t('app', 'Внимание после активации внести изменения<br/> в рассылку будет невозможно!');?></p>
                    <button value="1" name="<?=\CHtml::activeName($form, 'Active');?>" class="btn btn-success" type="submit" disabled><?=\Yii::t('app', 'Запустить рассылку');?></button>
                </div>
            </div>

            <div class="control-group m-top_40">
                <?=\CHtml::activeLabel($form, 'Test', ['class' => 'control-label']);?>
                <div class="controls">
                    <?=\CHtml::activeTextField($form, 'TestUsers');?>
                    <button value="1" name="<?=\CHtml::activeName($form, 'Test');?>" class="btn btn-info" type="submit"><?=\Yii::t('app', 'Отправить тест');?></button>
                </div>
            </div>
        <?endif;?>

        <h3><?=\Yii::t('app', 'Выборка');?></h3>
        <?foreach ($form->getConditionData() as $key => $value):?>
            <button name="" data-by="<?=$key;?>" class="btn add-criteria-btn" type="button"><i class="icon-plus"></i> <?=$value;?></button>
        <?endforeach;?>
        <div id="filter">
            <?=\CHtml::activeHiddenField($form, 'Conditions', ['value' => '']);?>
        </div>
    </div>

    <script type="text/template" id="event-criteria-tpl">
        <div class="row-fluid m-top_20">
            <div class="span7">
                <input type="text" name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][eventLabel]');?>" class="input-block-level" placeholder="<?=\Yii::t('app', 'Мероприятие');?>"/>
                <input type="hidden" name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][eventId]');?>" />
            </div>
            <div class="span3">
                <input type="text" name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][rolesSearch]');?>" class="input-block-level" data-source='<?=json_encode($form->getEventRolesData());?>' placeholder="<?=\Yii::t('app', 'Роли');?>"/>
            </div>
            <div class="span2">
                <select name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][type]');?>" class="input-block-level">
                    <?foreach ($form->getTypeData() as $key => $value):?><option value="<?=$key;?>"><?=$value;?></option><?endforeach;?>
                </select>
                <button name="" class="btn btn-danger m-top_5" type="button"><?=\Yii::t('app', 'Удалить');?></button>
            </div>
            <input type="hidden" name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][by]');?>" value="<?=\mail\models\forms\admin\Template::ByEvent;?>" />
        </div>
    </script>

    <script type="text/template" id="email-criteria-tpl">
        <div class="row-fluid m-top_20">
            <div class="span10">
                <textarea name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][emails]');?>" class="input-block-level" placeholder="<?=\Yii::t('app', 'Список E-mail через запятую');?>"/>
            </div>
            <div class="span2">
                <select name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][type]');?>" class="input-block-level">
                    <?foreach ($form->getTypeData() as $key => $value):?><option value="<?=$key;?>"><?=$value;?></option><?endforeach;?>
                </select>
                <button name="" class="btn btn-danger m-top_5" type="button"><?=\Yii::t('app', 'Удалить');?></button>
            </div>
            <input type="hidden" name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][by]');?>" value="<?=\mail\models\forms\admin\Template::ByEmail;?>" />
        </div>
    </script>

    <script type="text/template" id="runetid-criteria-tpl">
        <div class="row-fluid m-top_20">
            <div class="span10">
                <textarea name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][runetIdList]');?>" class="input-block-level" placeholder="<?=\Yii::t('app', 'Список RUNET-ID через запятую');?>"/>
            </div>
            <div class="span2">
                <select name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][type]');?>" class="input-block-level">
                    <?foreach ($form->getTypeData() as $key => $value):?><option value="<?=$key;?>"><?=$value;?></option><?endforeach;?>
                </select>
                <button name="" class="btn btn-danger m-top_5" type="button"><?=\Yii::t('app', 'Удалить');?></button>
            </div>
            <input type="hidden" name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][by]');?>" value="<?=\mail\models\forms\admin\Template::ByRunetId;?>" />
        </div>
    </script>

    <script type="text/template" id="geo-criteria-tpl">
        <div class="row-fluid m-top_20">
            <div class="span10">
                <input type="text" name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][label]');?>" class="input-block-level" placeholder="<?=\Yii::t('app', 'Город или регион');?>"/>
            </div>
            <div class="span2">
                <select name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][type]');?>" class="input-block-level">
                    <?foreach ($form->getTypeData() as $key => $value):?><option value="<?=$key;?>"><?=$value;?></option><?endforeach;?>
                </select>
                <button name="" class="btn btn-danger m-top_5" type="button"><?=\Yii::t('app', 'Удалить');?></button>
            </div>
            <input type="hidden" name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][regionId]');?>" value="" />
            <input type="hidden" name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][countryId]');?>" value="" />
            <input type="hidden" name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][cityId]');?>" value="" />
            <input type="hidden" name="<?=\CHtml::activeName($form, 'Conditions[<%=i%>][by]');?>" value="<?=\mail\models\forms\admin\Template::ByGeo;?>" />
        </div>
    </script>


<?=\CHtml::endForm();?>
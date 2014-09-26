<?php

/** @var $event \event\models\Event */

?>

<?=\CHtml::form('','POST',array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'));?>
    <div class="btn-toolbar">
        <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), array('class' => 'btn btn-success'));?>
    </div>
    <div class="well">
    <div class="row-fluid">
        <?if (\Yii::app()->user->hasFlash('success')):?>
            <div class="alert alert-success"><?=\Yii::app()->user->getFlash('success');?></div>
        <?endif;?>
        <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
        <div class="span8">
            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'Title', array('class' => 'control-label'));?>
                <div class="controls">
                    <?=\CHtml::activeTextField($form, 'Title', array('class' => 'input-block-level'));?>
                </div>
            </div>
            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'Info', array('class' => 'control-label'));?>
                <div class="controls controls-row">
                    <?=\CHtml::activeTextArea($form, 'Info', array('class' => 'input-block-level'));?>
                </div>
            </div>
            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'FullInfo', array('class' => 'control-label'));?>
                <div class="controls controls-row">
                    <?=\CHtml::activeTextArea($form, 'FullInfo', array('class' => 'input-block-level'));?>
                </div>
            </div>

            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'Date', array('class' => 'control-label'));?>
                <div class="controls">
                    <?=\CHtml::activeTextField($form, 'StartDate', array('class' => 'input-small'));?>
                    &ndash;
                    <?=\CHtml::activeTextField($form, 'EndDate', array('class' => 'input-small'));?>
                </div>
            </div>

            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'SiteUrl', array('class' => 'control-label'));?>
                <div class="controls">
                    <?=\CHtml::activeTextField($form, 'SiteUrl', array('class' => 'input-block-level'));?>
                </div>
            </div>

            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'Address', array('class' => 'control-label'));?>
                <?$this->widget('\contact\widgets\AddressControls', array('form' => $form->Address));?>
            </div>

            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'Phone', array('class' => 'control-label'));?>
                <?$this->widget('\contact\widgets\PhoneControls', array('form' => $form->Phone));?>
            </div>

            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'Email', array('class' => 'control-label'));?>
                <div class="controls">
                    <?=\CHtml::activeTextField($form, 'Email');?>
                </div>
            </div>

            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'ProfInterest', array('class' => 'control-label'));?>
                <div class="controls">
                    <?=\CHtml::activeDropDownList($form, 'ProfInterest', \CHtml::listData(\application\models\ProfessionalInterest::model()->findAll(),'Id','Title'), array('multiple' => true));?>
                </div>
            </div>
        </div>

        <div class="span3">
            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'IdName', array('class' => 'control-label'));?>
                <div class="controls">
                    <?=\CHtml::activeTextField($form, 'IdName');?>
                </div>
            </div>

            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'Logo', array('class' => 'control-label'));?>
                <div class="controls">
                    <?php

                    if ($event->LogoSource)
                    {
                        $LogoSource = $event->getPath($event->LogoSource);

                        printf('<a target="_blank" href="%s">Исходник.%s&nbsp;(%s)</a>',
                            $LogoSource,
                            pathinfo($LogoSource, PATHINFO_EXTENSION),
                            CText::humanFileSize(\Yii::getPathOfAlias('webroot').$LogoSource, '%01.0f%s', ':)')
                        );
                    }

                    ?>
                    <?=\CHtml::fileField(\CHtml::activeName($form, 'Logo'));?>
                </div>
                <div class="controls"><?=\CHtml::image($event->getLogo()->get50px());?></div>
            </div>

            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'Type', array('class' => 'control-label'));?>
                <div class="controls">
                    <?=\CHtml::activeDropDownList($form, 'TypeId', \CHtml::listData(\event\models\Type::model()->findAll(), 'Id', 'Title'));?>
                </div>
            </div>

            <? $this->renderPartial('_fbPublish', ['event' => $event]); ?>

            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'Visible', array('class' => 'control-label'));?>
                <div class="controls">
                    <?=\CHtml::activeCheckBox($form, 'Visible');?>
                </div>
            </div>
            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'ShowOnMain', array('class' => 'control-label'));?>
                <div class="controls">
                    <?=\CHtml::activeCheckBox($form, 'ShowOnMain');?>
                </div>
            </div>
            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'Top', array('class' => 'control-label'));?>
                <div class="controls">
                    <?=\CHtml::activeCheckBox($form, 'Top');?>
                </div>
            </div>
            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'Free', array('class' => 'control-label'));?>
                <div class="controls">
                    <?=\CHtml::activeCheckBox($form, 'Free');?>
                </div>
            </div>
            <div class="control-group">
                <?=\CHtml::activeLabel($form, 'UnsubscribeNewUser', array('class' => 'control-label'));?>
                <div class="controls">
                    <?=\CHtml::activeCheckBox($form, 'UnsubscribeNewUser');?>
                </div>
            </div>
            <?if ($event->External == true):?>
                <p class="text-warning"><?=\Yii::t('app', 'Внешнее мероприятие');?></p>
                <div class="control-group">
                    <?=\CHtml::activeLabel($form, 'Approved', array('class' => 'control-label'));?>
                    <div class="controls">
                        <?=\CHtml::activeDropDownList($form, 'Approved', array(
                            \event\models\Approved::Yes => \Yii::t('app', 'Принят'),
                            \event\models\Approved::None => \Yii::t('app', 'На рассмотрении'),
                            \event\models\Approved::No => \Yii::t('app', 'Отклонен')
                        ));?>
                    </div>
                </div>

                <?if (isset($event->Options)):?>
                    <div class="control-group">
                        <label class="control-label"><?=\Yii::t('app', 'Дополнительные услуги, выбранные клиентом');?>:</label>
                        <div class="controls m-top_5">
                            <?foreach (unserialize($event->Options) as $option):?>
                                <nobr>&mdash; <?=$option;?></nobr><br/>
                            <?endforeach;?>
                        </div>
                    </div>
                <?endif?>

                <?if (isset($event->ContactPerson)):?>
                    <div class="control-group">
                        <label class="control-label"><?=\Yii::t('app', 'Контактные данные клиента');?>:</label>
                        <div class="controls m-top_5">
                            <?$person = unserialize($event->ContactPerson);?>
                            <nobr><?=$person['Name'];?></nobr><br/><nobr>(<?=\CHtml::mailto($person['Email']);?>)</nobr><br/><nobr><?=$person['Phone'];?></nobr>
                        </div>
                    </div>
                <?endif;?>
            <?endif;?>

            <?if (!$event->getIsNewRecord()):?>
                <div class="control-group">
                    <div class="controls">
                        <a href="<?=$this->createUrl('/event/admin/edit/product', ['eventId' => $event->Id]);?>" class="btn"><i class="icon-shopping-cart"></i> <?=\Yii::t('app', 'Товары');?></a>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <a href="<?=$this->createUrl('/event/admin/mail/index', ['eventId' => $event->Id]);?>" class="btn"><i class="icon-pencil"></i> <?=\Yii::t('app', 'Рег. письмо');?></a>
                    </div>
                </div>
            <?endif?>
        </div>
    </div>

    <div class="row-fluid m-top_40">
        <div class="span8"><h3><?=\Yii::t('app', 'Виджеты');?></h3></div>
    </div>
    <div class="row-fluid">
        <?php
        foreach ($widgets->All as $widget):
            $widgetsAll[$widget->getPosition()][] = $widget;
        endforeach;
        ?>

        <!-- Виджеты -->
        <div class="span3">
            <h4><?=\Yii::t('app', 'Левая колонка');;?></h4>
            <?foreach ($widgetsAll[\event\components\WidgetPosition::Sidebar] as $widget):?>
                <?$class = get_class($widget);?>
                <div class="m-bottom_10 row-fluid">
                    <div class="span8">
                        <label class="checkbox"><?=\CHtml::activeCheckBox($form, 'Widgets['.$class.'][Activated]', array('checked' => isset($widgets->Used[get_class($widget)]) ? true : false));?> <?=$widget->getTitle();?></label>
                    </div>
                    <div class="span4">
                        <?php
                        if (isset($widgets->Used[$class])):
                            $form->Widgets[$class]['Order'] = $widgets->Used[$class]->Order;
                        endif
                        ;?>
                        <?if ($widget->getAdminPanel() !== NULL && isset($widgets->Used[$class])):?>
                            <a href="<?=$this->createUrl('/event/admin/edit/widget', array('widget' => $class, 'eventId' => $event->Id));?>" class="btn"><i class="icon-edit"></i></a>
                        <?endif;?>
                        <?=\CHtml::activeDropDownList($form, 'Widgets['.$class.'][Order]', array(0,1,2,3,4,5,6,7,8,9,10), array('class' => 'input-mini'));?>
                    </div>
                </div>
            <?endforeach;?>
        </div>

        <div class="span3">
            <h4><?=\Yii::t('app', 'Шапка');;?></h4>
            <?foreach ($widgetsAll[\event\components\WidgetPosition::Header] as $widget):?>
                <?$class = get_class($widget);?>
                <div class="m-bottom_10 row-fluid">
                    <div class="span8">
                        <label class="checkbox"><?=\CHtml::activeCheckBox($form, 'Widgets['.$class.'][Activated]', array('checked' => isset($widgets->Used[$class]) ? true : false));?> <?=$widget->getTitle();?></label>
                    </div>
                    <div class="span4">
                        <?php
                        if (isset($widgets->Used[$class])):
                            $form->Widgets[$class]['Order'] = $widgets->Used[$class]->Order;
                        endif
                        ;?>
                        <?if ($widget->getAdminPanel() !== NULL && isset($widgets->Used[$class])):?>
                            <a href="<?=$this->createUrl('/event/admin/edit/widget', array('widget' => $class, 'eventId' => $event->Id));?>" class="btn"><i class="icon-edit"></i></a>
                        <?endif;?>
                        <?=\CHtml::activeDropDownList($form, 'Widgets['.get_class($widget).'][Order]', array(0,1,2,3,4,5,6,7,8,9,10), array('class' => 'input-mini'));?>
                    </div>
                </div>
            <?endforeach;?>

            <h4><?=\Yii::t('app', 'Контентная область');;?></h4>
            <?foreach ($widgetsAll[\event\components\WidgetPosition::Content] as $widget):?>
                <?$class = get_class($widget);?>
                <div class="m-bottom_10 row-fluid">
                    <div class="span8">
                        <label class="checkbox"><?=\CHtml::activeCheckBox($form, 'Widgets['.get_class($widget).'][Activated]', array('checked' => isset($widgets->Used[get_class($widget)]) ? true : false));?> <?=$widget->getTitle();?></label>
                    </div>
                    <div class="span4">
                        <?php
                        if (isset($widgets->Used[get_class($widget)])):
                            $form->Widgets[get_class($widget)]['Order'] = $widgets->Used[get_class($widget)]->Order;
                        endif
                        ;?>
                        <?if ($widget->getAdminPanel() !== NULL && isset($widgets->Used[get_class($widget)])):?>
                            <a href="<?=$this->createUrl('/event/admin/edit/widget', array('widget' => $class, 'eventId' => $event->Id));?>" class="btn"><i class="icon-edit"></i></a>
                        <?endif;?>
                        <?=\CHtml::activeDropDownList($form, 'Widgets['.get_class($widget).'][Order]', array(0,1,2,3,4,5,6,7,8,9,10), array('class' => 'input-mini'));?>
                    </div>
                </div>
            <?endforeach;?>
        </div>

        <div class="span3">
            <h4><?=\Yii::t('app', 'Табы');;?></h4>
            <?foreach ($widgetsAll[\event\components\WidgetPosition::Tabs] as $widget):?>
                <?$class = get_class($widget);?>
                <div class="m-bottom_10 row-fluid">
                    <div class="span8">
                        <label class="checkbox"><?=\CHtml::activeCheckBox($form, 'Widgets['.get_class($widget).'][Activated]', array('checked' => isset($widgets->Used[get_class($widget)]) ? true : false));?> <?=$widget->getTitle();?></label>
                    </div>
                    <div class="span4">
                        <?php
                        if (isset($widgets->Used[get_class($widget)])):
                            $form->Widgets[get_class($widget)]['Order'] = $widgets->Used[get_class($widget)]->Order;
                        endif
                        ;?>
                        <?if ($widget->getAdminPanel() !== NULL && isset($widgets->Used[get_class($widget)])):?>
                            <a href="<?=$this->createUrl('/event/admin/edit/widget', array('widget' => $class, 'eventId' => $event->Id));?>" class="btn"><i class="icon-edit"></i></a>
                        <?endif;?>
                        <?=\CHtml::activeDropDownList($form, 'Widgets['.get_class($widget).'][Order]', array(0,1,2,3,4,5,6,7,8,9,10), array('class' => 'input-mini'));?>
                    </div>
                </div>
            <?endforeach;?>
        </div>
    </div>
    </div>
<?=\CHtml::endForm();?>
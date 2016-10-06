<?php
/**
 * @var event\models\Event $event
 * @var event\models\forms\admin\Edit $form
 * @var stdClass $widgets
 */

use application\models\ProfessionalInterest;
use event\components\Widget;
use event\components\WidgetPosition;
use event\models\Type;

/** @var Widget $widget */
foreach ($widgets->All as $widget) {
    $widgetsAll[$widget->getPosition()][] = $widget;
}

?>

<?=CHtml::form('', 'POST', [
    'class' => 'form-horizontal',
    'enctype' => 'multipart/form-data'
])?>
    <div class="btn-toolbar">
        <?=CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
    </div>
    <div class="well">
        <div class="row-fluid">
            <div class="span12">
                <?=CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>
                <?if(Yii::app()->user->hasFlash('success')):?>
                    <div class="alert alert-success"><?=Yii::app()->user->getFlash('success')?></div>
                <?endif?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span7">
                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'Title', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?=CHtml::activeTextField($form, 'Title', ['class' => 'input-block-level'])?>
                    </div>
                </div>
                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'Info', ['class' => 'control-label'])?>
                    <div class="controls controls-row">
                        <?=CHtml::activeTextArea($form, 'Info', ['class' => 'input-block-level'])?>
                    </div>
                </div>
                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'FullInfo', ['class' => 'control-label'])?>
                    <div class="controls controls-row">
                        <?=CHtml::activeTextArea($form, 'FullInfo', ['class' => 'input-block-level'])?>
                    </div>
                </div>

                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'Date', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?=CHtml::activeTextField($form, 'StartDate', ['class' => 'input-small'])?>
                        &ndash;
                        <?=CHtml::activeTextField($form, 'EndDate', ['class' => 'input-small'])?>
                    </div>
                </div>

                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'SiteUrl', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?=CHtml::activeTextField($form, 'SiteUrl', ['class' => 'input-block-level'])?>
                    </div>
                </div>

                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'Address', ['class' => 'control-label'])?>
                    <?$this->widget('contact\widgets\AddressControls', ['form' => $form->Address])?>
                </div>

                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'Phone', ['class' => 'control-label'])?>
                    <?$this->widget('contact\widgets\PhoneControls', ['form' => $form->Phone])?>
                </div>

                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'Email', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?=CHtml::activeTextField($form, 'Email')?>
                    </div>
                </div>

                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'ProfInterest', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?=CHtml::activeDropDownList(
                            $form,
                            'ProfInterest',
                            CHtml::listData(ProfessionalInterest::model()->findAll(), 'Id', 'Title'),
                            ['multiple' => true]
                        )?>
                    </div>
                </div>
            </div>

            <div class="span5">
                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'IdName', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?=CHtml::activeTextField($form, 'IdName')?>
                    </div>
                </div>

                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'Logo', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?php
                        if ($event->LogoSource) {
                            $LogoSource = $event->getPath($event->LogoSource);

                            printf('<a target="_blank" href="%s">Исходник.%s&nbsp;(%s)</a>',
                                $LogoSource,
                                pathinfo($LogoSource, PATHINFO_EXTENSION),
                                CText::humanFileSize(\Yii::getPathOfAlias('webroot') . $LogoSource, '%01.0f%s', ':)')
                            );
                        }
                       ?>
                        <?=CHtml::fileField(CHtml::activeName($form, 'Logo'))?>
                    </div>
                    <div class="controls"><?=CHtml::image($event->getLogo()->get50px())?></div>
                </div>

                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'TicketImage', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?=CHtml::activeFileField($form, 'TicketImage')?>
                    </div>
                    <?if($event->getTicketImage()->exists()):?>
                        <div class="controls"><?=CHtml::image($event->getTicketImage()->get120px())?></div>
                    <?endif?>
                </div>

                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'Type', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?=CHtml::activeDropDownList(
                            $form,
                            'TypeId',
                            CHtml::listData(Type::model()->findAll(), 'Id', 'Title')
                        )?>
                    </div>
                </div>

                <?$this->renderPartial('_fbPublish', ['event' => $event])?>

                <div class="control-group">
                    <div class="controls">
                        <?=\CHtml::label($form->getAttributeLabel('Visible') . \CHtml::activeCheckBox($form, 'Visible'), null, array('class' => 'checkbox'))?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?=\CHtml::label($form->getAttributeLabel('ShowOnMain') . \CHtml::activeCheckBox($form, 'ShowOnMain'), null, array('class' => 'checkbox'))?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?=\CHtml::label($form->getAttributeLabel('CloseRegistrationAfterEnd') . \CHtml::activeCheckBox($form, 'CloseRegistrationAfterEnd'), null, array('class' => 'checkbox'))?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?=\CHtml::label($form->getAttributeLabel('DocumentRequired') . \CHtml::activeCheckBox($form, 'DocumentRequired'), null, array('class' => 'checkbox'))?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?=\CHtml::label($form->getAttributeLabel('Top') . \CHtml::activeCheckBox($form, 'Top'), null, array('class' => 'checkbox'))?>

                        <?if(!$event->getIsNewRecord() && $form->Top):?>
                            <p class="m-top_5"><?=\CHtml::link(\Yii::t('app', 'Настроить'), ['promo', 'id' => $event->Id], ['class' => 'btn btn-small'])?></p>
                        <?endif?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?=\CHtml::label($form->getAttributeLabel('Free') . \CHtml::activeCheckBox($form, 'Free'), null, array('class' => 'checkbox'))?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?=\CHtml::label($form->getAttributeLabel('UnsubscribeNewUser') . \CHtml::activeCheckBox($form, 'UnsubscribeNewUser'), null, array('class' => 'checkbox'))?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?=\CHtml::label($form->getAttributeLabel('NotSendRegisterMail') . \CHtml::activeCheckBox($form, 'NotSendRegisterMail'), null, array('class' => 'checkbox'))?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?=\CHtml::label($form->getAttributeLabel('NotSendChangeRoleMail') . \CHtml::activeCheckBox($form, 'NotSendChangeRoleMail'), null, array('class' => 'checkbox'))?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?=\CHtml::label($form->getAttributeLabel('RegisterHideNotSelectedProduct') . \CHtml::activeCheckBox($form, 'RegisterHideNotSelectedProduct'), null, array('class' => 'checkbox'))?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?=\CHtml::label($form->getAttributeLabel('FullWidth') . \CHtml::activeCheckBox($form, 'FullWidth'), null, array('class' => 'checkbox'))?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?=\CHtml::label($form->getAttributeLabel('UserScope') . \CHtml::activeCheckBox($form, 'UserScope'), null, array('class' => 'checkbox'))?>
                    </div>
                </div>
                <?if($event->External == true):?>
                    <p class="text-warning"><?=\Yii::t('app', 'Внешнее мероприятие')?></p>
                    <div class="control-group">
                        <?=\CHtml::activeLabel($form, 'Approved', array('class' => 'control-label'))?>
                        <div class="controls">
                            <?=\CHtml::activeDropDownList($form, 'Approved', array(
                                \event\models\Approved::Yes => \Yii::t('app', 'Принят'),
                                \event\models\Approved::None => \Yii::t('app', 'На рассмотрении'),
                                \event\models\Approved::No => \Yii::t('app', 'Отклонен')
                            ))?>
                        </div>
                    </div>

                    <?if(isset($event->Options)):?>
                        <div class="control-group">
                            <label
                                class="control-label"><?=\Yii::t('app', 'Дополнительные услуги, выбранные клиентом')?>
                                :</label>

                            <div class="controls m-top_5">
                                <?foreach(unserialize($event->Options) as $option):?>
                                    <nobr>&mdash; <?=$option?></nobr><br/>
                                <?endforeach?>
                            </div>
                        </div>
                    <?endif?>

                    <?if(isset($event->ContactPerson)):?>
                        <div class="control-group">
                            <label class="control-label"><?=\Yii::t('app', 'Контактные данные клиента')?>:</label>

                            <div class="controls m-top_5">
                                <?$person = unserialize($event->ContactPerson)?>
                                <nobr><?=$person['Name']?></nobr>
                                <br/>
                                <nobr>(<?=\CHtml::mailto($person['Email'])?>)</nobr>
                                <br/>
                                <nobr><?=$person['Phone']?></nobr>
                            </div>
                        </div>
                    <?endif?>
                <?endif?>

                <div class="control-group">
                    <?=CHtml::activeLabel($form, 'OrganizerInfo', ['class' => 'control-label'])?>
                    <div class="controls m-top_5">
                        <?=CHtml::activeTextField($form, 'OrganizerInfo')?>
                    </div>
                </div>

                <?if(!$event->getIsNewRecord()):?>
                    <div class="control-group">
                        <div class="controls">
                            <a href="<?=$this->createUrl('/event/admin/edit/parts', ['eventId' => $event->Id])?>"
                               class="btn"><i class="icon-tags"></i> <?=\Yii::t('app', 'Части мероприятия')?></a>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <a href="<?=$this->createUrl('/event/admin/edit/product', ['eventId' => $event->Id])?>"
                               class="btn"><i class="icon-shopping-cart"></i> <?=\Yii::t('app', 'Товары')?></a>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <a href="<?=$this->createUrl('/event/admin/mail/index', ['eventId' => $event->Id])?>"
                               class="btn"><i class="icon-pencil"></i> <?=\Yii::t('app', 'Рег. письмо')?></a>
                        </div>
                    </div>
                <?endif?>
            </div>
        </div>

        <div class="row-fluid m-top_40">
            <div class="span8"><h3><?=Yii::t('app', 'Виджеты')?></h3></div>
        </div>
        <div class="row-fluid">
            <!-- Виджеты -->
            <div class="span4">
                <h4><?=Yii::t('app', 'Левая колонка')?></h4>
                <?foreach($widgetsAll[WidgetPosition::Sidebar] as $widget):?>
                    <?$class = get_class($widget)?>
                    <div class="m-bottom_10 row-fluid">
                        <div class="span8">
                            <label
                                class="checkbox"><?=\CHtml::activeCheckBox($form, 'Widgets[' . $class . '][Activated]', array('checked' => isset($widgets->Used[get_class($widget)]) ? true : false))?> <?=$widget->getTitle()?></label>
                        </div>
                        <div class="span4">
                            <?php
                            if (isset($widgets->Used[$class])):
                                $form->Widgets[$class]['Order'] = $widgets->Used[$class]->Order;
                            endif?>
                            <?if($widget->getAdminPanel() !== NULL && isset($widgets->Used[$class])):?>
                                <a href="<?=$this->createUrl('/event/admin/edit/widget', array('widget' => $class, 'eventId' => $event->Id))?>"
                                   class="btn"><i class="icon-edit"></i></a>
                            <?endif?>
                            <?=CHtml::activeDropDownList($form, 'Widgets[' . $class . '][Order]', range(0, 10), ['class' => 'input-mini'])?>
                        </div>
                    </div>
                <?endforeach?>
            </div>

            <div class="span4">
                <h4><?=Yii::t('app', 'Шапка')?></h4>
                <?foreach($widgetsAll[WidgetPosition::Header] as $widget):?>
                    <?$class = get_class($widget)?>
                    <div class="m-bottom_10 row-fluid">
                        <div class="span8">
                            <label
                                class="checkbox"><?=\CHtml::activeCheckBox($form, 'Widgets[' . $class . '][Activated]', array('checked' => isset($widgets->Used[$class]) ? true : false))?> <?=$widget->getTitleAdmin()?></label>
                        </div>
                        <div class="span4">
                            <?php
                            if (isset($widgets->Used[$class])):
                                $form->Widgets[$class]['Order'] = $widgets->Used[$class]->Order;
                            endif?>
                            <?if($widget->getAdminPanel() !== NULL && isset($widgets->Used[$class])):?>
                                <a href="<?=$this->createUrl('/event/admin/edit/widget', array('widget' => $class, 'eventId' => $event->Id))?>"
                                   class="btn"><i class="icon-edit"></i></a>
                            <?endif?>
                            <?=\CHtml::activeDropDownList($form, 'Widgets[' . get_class($widget) . '][Order]', array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10), array('class' => 'input-mini'))?>
                        </div>
                    </div>
                <?endforeach?>

                <h4><?=Yii::t('app', 'Контентная область')?></h4>
                <?foreach($widgetsAll[WidgetPosition::Content] as $widget):?>
                    <?$class = get_class($widget)?>
                    <div class="m-bottom_10 row-fluid">
                        <div class="span8">
                            <label
                                class="checkbox"><?=\CHtml::activeCheckBox($form, 'Widgets[' . get_class($widget) . '][Activated]', array('checked' => isset($widgets->Used[get_class($widget)]) ? true : false))?> <?=$widget->getTitleAdmin()?></label>
                        </div>
                        <div class="span4">
                            <?php
                            if (isset($widgets->Used[get_class($widget)])):
                                $form->Widgets[get_class($widget)]['Order'] = $widgets->Used[get_class($widget)]->Order;
                            endif?>
                            <?if ($widget->getAdminPanel() !== NULL && isset($widgets->Used[get_class($widget)])):?>
                                <a href="<?=$this->createUrl('/event/admin/edit/widget', array('widget' => $class, 'eventId' => $event->Id))?>"
                                   class="btn"><i class="icon-edit"></i></a>
                            <?endif?>
                            <?=\CHtml::activeDropDownList($form, 'Widgets[' . get_class($widget) . '][Order]', array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10), array('class' => 'input-mini'))?>
                        </div>
                    </div>
                <?endforeach?>
            </div>

            <div class="span4">
                <h4><?=\Yii::t('app', 'Табы')?></h4>
                <?foreach($widgetsAll[\event\components\WidgetPosition::Tabs] as $widget):?>
                    <?$class = get_class($widget)?>
                    <div class="m-bottom_10 row-fluid">
                        <div class="span8">
                            <label
                                class="checkbox"><?=\CHtml::activeCheckBox($form, 'Widgets[' . get_class($widget) . '][Activated]', array('checked' => isset($widgets->Used[get_class($widget)]) ? true : false))?> <?=$widget->getTitleAdmin()?></label>
                        </div>
                        <div class="span4">
                            <?php
                            if (isset($widgets->Used[get_class($widget)])):
                                $form->Widgets[get_class($widget)]['Order'] = $widgets->Used[get_class($widget)]->Order;
                            endif?>
                            <?if ($widget->getAdminPanel() !== NULL && isset($widgets->Used[get_class($widget)])):?>
                                <a href="<?=$this->createUrl('/event/admin/edit/widget', array('widget' => $class, 'eventId' => $event->Id))?>"
                                   class="btn"><i class="icon-edit"></i></a>
                            <?endif?>
                            <?=\CHtml::activeDropDownList($form, 'Widgets[' . get_class($widget) . '][Order]', array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10), array('class' => 'input-mini'))?>
                        </div>
                    </div>
                <?endforeach?>
            </div>
        </div>
    </div>
<?=\CHtml::endForm()?>

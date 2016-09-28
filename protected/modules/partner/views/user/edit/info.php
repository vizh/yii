<?php
/**
 * @var partner\components\Controller $this
 * @var User $user
 * @var Event $event
 * @var CActiveForm $activeForm
 * @var user\models\forms\edit\Photo $photoForm
 */

use user\models\User;
use event\models\Event;

?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-user"></i> <?=\Yii::t('app', 'Персональные данные')?></span>

        <div class="panel-heading-controls">
            <?=CHtml::link('<span class="fa fa-external-link"></span> ' . \Yii::t('app', 'Профиль'), $user->getUrl(), ['target' => '_blank', 'class' => 'btn btn-xs btn-info btn-outline'])?>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-4 col-md-4 col-lg-2 col-xs-12">
                <?=CHtml::image($user->getPhoto()->get200px(), '', ['class' => 'img-responsive'])?>

                <h5>Загрузить фото</h5>
                <?$activeForm = $this->beginWidget('CActiveForm', [
                    'htmlOptions' => [
                        'enctype' => 'multipart/form-data'
                    ]
                ])?>
                    <?=$activeForm->fileField($photoForm, 'Image')?>
                    <br>
                    <?=CHtml::submitButton('Сохранить', ['class' => 'btn btn-primary'])?>
                    <?=CHtml::tag('button', [
                            'id' => 'crop',
                            'class' => 'btn btn-warning',
                            'type' => 'button'
                        ], 'Кроп'
                    )?>
                <?$this->endWidget()?>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-8 col-xs-12">
                <h3 class="clear-indents">
                    <?=$user->getFullName()?>
                    <?$user->setLocale('en')?>
                    (<?=$user->getFullName()?>)
                    <sup><?=$user->RunetId?></sup>
                </h3>
                <?if($employment = $user->getEmploymentPrimary()):?>
                    <h5 class="clear-indents m-top_10">
                        <?=$employment->Company->Name?>
                        <?$employment->Company->setLocale('en')?>
                        (<?=$employment->Company->Name?>)
                    </h5>
                <?endif?>

                <div class="btn-group btn-group-sm m-top_10">
                    <?=CHtml::link(\Yii::t('app', 'Редактировать'), ['translate', 'id' => $user->RunetId], ['class' => 'btn', 'target' => '_top'])?>
                    <?if($event->getIsRequiredDocument() && !empty($user->Documents)):?>
                        <?$this->beginWidget('application\widgets\bootstrap\Modal', [
                            'header' => Yii::t('app', 'Паспортные данные'),
                            'htmlOptions' => ['class' => 'modal-blur'],
                            'toggleButton' => [
                                'class' => 'btn',
                                'label' => Yii::t('app', 'Паспортные данные')
                            ]
                        ]);
                        $this->renderPartial('edit/documents', ['user' => $user]);
                        $this->endWidget();
                       ?>
                    <?endif?>
                </div>

                <p class="m-top_20">
                    <span class="fa fa-envelope-o"></span> <?=CHtml::mailto($user->Email)?>
                    <?if($phone = $user->getPhone()):?>
                        <br><span class="fa fa-phone"></span> <?=$phone?>
                    <?endif?>

                    <?if(!empty($user->Birthday)):?>
                        <br>
                        <span class="fa fa-birthday-cake"></span>
                        <?=Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $user->Birthday)?>
                    <?endif?>
                </p>
            </div>
        </div>
    </div>
</div>

<div id="crop-modal" class="modal fade in" tabindex="-1" role="dialog" style="display: none;" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Кроп фото</h4>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <?=CHtml::image($user->getPhoto()->getOriginal(), '', [
                        'id' => 'crop-image',
                        'class' => 'img-responsive',
                        'style' => 'display: inline; max-width: 100%; width: 800px; height: auto;',
                        'data-user-id' => $user->Id
                    ])?>
                </div>

                <div class="text-center">
                    <button id="save-crop" type="button" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
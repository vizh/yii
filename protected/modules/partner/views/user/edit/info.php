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
        <span class="panel-title"><i class="fa fa-user"></i> <?= \Yii::t('app', 'Персональные данные'); ?></span>

        <div class="panel-heading-controls">
            <?= CHtml::link('<span class="fa fa-external-link"></span> ' . \Yii::t('app', 'Профиль'), $user->getUrl(), ['target' => '_blank', 'class' => 'btn btn-xs btn-info btn-outline']); ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-4 col-md-4 col-lg-2 col-xs-12">
                <?= CHtml::image($user->getPhoto()->get200px(), '', ['class' => 'img-responsive']) ?>

                <h5>Загрузить фото</h5>
                <?php $activeForm = $this->beginWidget('CActiveForm', [
                    'htmlOptions' => [
                        'enctype' => 'multipart/form-data'
                    ]
                ]) ?>
                    <?=$activeForm->fileField($photoForm, 'Image')?>
                    <br>
                    <?= CHtml::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                <?php $this->endWidget() ?>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-8 col-xs-12">
                <h3 class="clear-indents">
                    <?= $user->getFullName() ?>
                    <?php $user->setLocale('en') ?>
                    (<?= $user->getFullName() ?>)
                    <sup><?= $user->RunetId ?></sup>
                </h3>
                <?php if ($employment = $user->getEmploymentPrimary()): ?>
                    <h5 class="clear-indents m-top_10">
                        <?= $employment->Company->Name ?>
                        <?php $employment->Company->setLocale('en') ?>
                        (<?= $employment->Company->Name ?>)
                    </h5>
                <?php endif ?>

                <div class="btn-group btn-group-sm m-top_10">
                    <?= CHtml::link(\Yii::t('app', 'Редактировать'), ['translate', 'id' => $user->RunetId], ['class' => 'btn', 'target' => '_top']) ?>
                    <?php if ($event->getIsRequiredDocument() && !empty($user->Documents)): ?>
                        <?php $this->beginWidget('application\widgets\bootstrap\Modal', [
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
                    <?php endif ?>
                </div>

                <p class="m-top_20">
                    <span class="fa fa-envelope-o"></span> <?= CHtml::mailto($user->Email) ?>
                    <?php if ($phone = $user->getPhone()): ?>
                        <br><span class="fa fa-phone"></span> <?= $phone ?>
                    <?php endif ?>

                    <?php if (!empty($user->Birthday)): ?>
                        <br>
                        <span class="fa fa-birthday-cake"></span>
                        <?= Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $user->Birthday) ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</div>
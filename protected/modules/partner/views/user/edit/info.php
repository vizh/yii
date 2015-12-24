<?php
use user\models\User;
use event\models\Event;
/**
 * @var User $user
 * @var Event $event
 * @var $this \partner\components\Controller
 */

$document = isset($event->DocumentRequired) && $event->DocumentRequired && !empty($user->Documents);
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-user"></i> <?=\Yii::t('app', 'Персональные данные');?></span>
        <div class="panel-heading-controls">
            <?=\CHtml::link('<span class="fa fa-external-link"></span> ' . \Yii::t('app', 'Профиль'), $user->getUrl(), ['target' => '_blank', 'class' => 'btn btn-xs btn-info btn-outline']);?>
        </div>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-2 col-lg-1 hidden-xs">
                <?=\CHtml::image($user->getPhoto()->get200px(),'',['class' => 'img-responsive']);?>
            </div>
            <div class="col-sm-10 col-lg-11 col-xs-12">
                <h3 class="clear-indents">
                    <?=$user->getFullName();?>
                    <?php $user->setLocale('en');?>
                    (<?=$user->getFullName();?>)
                    <sup><?=$user->RunetId;?></sup>
                </h3>
                <?php $employment = $user->getEmploymentPrimary();?>
                <?php if ($employment !== null):?>
                    <h5 class="clear-indents m-top_10">
                        <?=$employment->Company->Name;?>
                        <?php $employment->Company->setLocale('en');?>
                        (<?=$employment->Company->Name;?>)
                    </h5>
                <?php endif;?>

                <div class="btn-group btn-group-sm m-top_10">
                    <?=\CHtml::link(\Yii::t('app', 'Редактировать'), ['translate', 'id' => $user->RunetId], ['class' => 'btn', 'target' => '_top']);?>
                    <?php if ($document):?>
                        <?php $this->beginWidget('\application\widgets\bootstrap\Modal', [
                            'header' => \Yii::t('app', 'Паспортные данные'),
                            'htmlOptions' => ['class' => 'modal-blur'],
                            'toggleButton' => [
                                'class' => 'btn',
                                'label' => \Yii::t('app', 'Паспортные данные')
                            ]
                        ]);
                        $this->renderPartial('edit/documents', ['user' => $user]);
                        $this->endWidget();
                        ?>
                    <?php endif;?>
                </div>

                <p class="m-top_20">
                    <span class="fa fa-envelope-o"></span> <?=\CHtml::mailto($user->Email);?>
                    <?php if ($user->getPhone() !== null):?>
                        <br/><span class="fa fa-phone"></span> <?=$user->getPhone();?>
                    <?php endif;?>
                    <?php if (!empty($user->Birthday)):?>
                        <br/><span class="fa fa-birthday-cake"></span> <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $user->Birthday);?>
                    <?php endif;?>
                </p>
            </div>
        </div>
    </div>
</div>
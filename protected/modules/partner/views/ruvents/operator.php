<?php
/**
 * @var \partner\models\forms\OperatorGenerate $form
 * @var \ruvents\models\Account $account
 * @var \ruvents\models\Operator[] $operators
 * @var Controller $this
 * @var \CActiveForm $activeForm
 */
$this->setPageTitle('Генерация аккаунтов операторов');
use partner\components\Controller;
?>

<?$this->beginClip(Controller::PAGE_HEADER_CLIP_ID)?>
    <?=\CHtml::link('<span class="fa fa-print btn-label"></span> ' . \Yii::t('app', 'Печать'), ['print'], ['class' => 'btn btn-info btn-labeled', 'target' => '_blank'])?>
<?$this->endClip()?>

<?$activeForm = $this->beginWidget('CActiveForm')?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-plus-circle"></i> <?=\Yii::t('app', 'Генерация операторов')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
        <div class="row">
            <div class="col-sm-4">
                <?=$activeForm->textField($form, 'Prefix', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('Prefix')])?>
            </div>
            <div class="col-sm-4">
                <?=$activeForm->textField($form, 'CountOperators', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('CountOperators')])?>
            </div>
            <div class="col-sm-4">
                <?=$activeForm->textField($form, 'CountAdmins', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('CountAdmins')])?>
            </div>
        </div>
    </div> <!-- / .panel-body -->
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Сгенерировать'), ['class' => 'btn btn-primary'])?>
    </div>
</div>
<?$this->endWidget()?>

<div class="panel panel-warning">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-qrcode"></i> <?=\Yii::t('app', 'Хэш клиента')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <p class="lead"><?=$account->Hash?></p>
        <hr/>
        <p class="text-center">
            <?=\CHtml::image($this->createUrl('mobile'))?>
        </p>
    </div> <!-- / .panel-body -->
</div>

<?if(!empty($operators)):?>
<div class="panel panel-success">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-list"></i> <?=\Yii::t('app', 'Ранее генерированные операторы')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-success">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Логин</th>
                    <th>Пароль</th>
                    <th>Роль</th>
                </tr>
                </thead>
                <tbody>
                <?foreach($operators as $operator):?>
                    <tr>
                        <td><?=$operator->Login?></td>
                        <td><?=$operator->Password?></td>
                        <td><?=$operator->Role?></td>
                    </tr>
                <?endforeach?>
                </tbody>
            </table>
        </div>
    </div> <!-- / .panel-body -->
</div>
<?endif?>

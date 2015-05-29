<?php
/**
 * @var \partner\models\forms\OperatorGenerate $form
 * @var \ruvents\models\Account $account
 * @var \ruvents\models\Operator[] $operators
 * @var \partner\components\Controller $this
 * @var \CActiveForm $activeForm
 */
$this->setPageTitle('Генерация аккаунтов операторов');
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-plus-circle"></i> <?=\Yii::t('app', 'Генерация операторов');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?php $activeForm = $this->beginWidget('CActiveForm', ['htmlOptions' => ['class' => 'form-inline']]);?>
            <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>');?>
            <div class="form-group">
                <?=$activeForm->textField($form, 'Prefix', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('Prefix')]);?>
            </div>
            <div class="form-group">
                <?=$activeForm->textField($form, 'CountOperators', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('CountOperators')]);?>
            </div>
            <div class="form-group">
                <?=$activeForm->textField($form, 'CountAdmins', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('CountAdmins')]);?>
            </div>
            <div class="form-group">
                <?=\CHtml::submitButton(\Yii::t('app', 'Сгенерировать'), ['class' => 'btn']);?>
            </div>
        <?php $this->endWidget();?>
    </div> <!-- / .panel-body -->
</div>

<div class="panel panel-warning">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-qrcode"></i> <?=\Yii::t('app', 'Хэш клиента');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <p class="lead"><?=$account->Hash;?></p>
        <hr/>
        <p class="text-center">
            <?=\CHtml::image($this->createUrl('mobile'));?>
        </p>
    </div> <!-- / .panel-body -->
</div>

<?php if (!empty($operators)):?>
<div class="panel panel-success">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-list"></i> <?=\Yii::t('app', 'Ранее генерированные операторы');?></span>
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
                <?php foreach ($operators as $operator):?>
                    <tr>
                        <td><?=$operator->Login;?></td>
                        <td><?=$operator->Password;?></td>
                        <td><?=$operator->Role;?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div> <!-- / .panel-body -->
</div>
<?php endif;?>

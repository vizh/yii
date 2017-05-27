<?php

use application\helpers\Flash;
use application\models\paperless\Device;
use application\models\paperless\DeviceSignal;

/**
 * @var \partner\models\forms\paperless\Device $form
 * @var Device $device
 * @var DeviceSignal[] $signals
 * @var $this \partner\components\Controller
 * @var $activeForm CActiveForm
 */

$this->setPageTitle(\Yii::t('app', 'Добавление устройства'));
?>

<? $activeForm = $this->beginWidget('CActiveForm') ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><span class="fa fa-plus"></span> <?= \Yii::t('app', 'Добавление устройства') ?></span>
    </div>
    <div class="panel-body">
        <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
		<?=$activeForm->hiddenField($form, 'Id')?>
        <?= Flash::html() ?>
        <div class="row">
            <div class="col-md-6">
                <?= $activeForm->label($form, 'DeviceNumber') ?>
                <?= $activeForm->textField($form, 'DeviceNumber', ['class' => 'form-control']) ?>

                <?= $activeForm->label($form, 'Type') ?>
                <?= $activeForm->dropDownList($form, 'Type', Device::getTypeLabels(), ['prompt' => '', 'class' => 'form-control']) ?>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <?= $activeForm->checkBox($form, 'Active') ?> <?= $form->getAttributeLabel('Active') ?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <?= $activeForm->label($form, 'Name') ?>
                <?= $activeForm->textField($form, 'Name', ['class' => 'form-control']) ?>

                <?= $activeForm->label($form, 'Comment') ?>
                <?= $activeForm->textArea($form, 'Comment', ['class' => 'form-control', 'rows' => '6']) ?>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <?=CHtml::submitButton($device->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary'])?>
        <?if(false === $device->isNewRecord):?>
            <?=CHtml::submitButton('Применить', ['name' => 'apply', 'class' => 'btn btn-default'])?>
        <?endif?>
    </div>
</div>

<div class="panel panel-info">
	<div class="panel-heading">
        <span class="panel-title">
			<span class="fa fa-plus"></span>
            <?=Yii::t('app', 'Обработанные сигналы')?>
            <?//CHtml::link('Экспорт', ['eventExport', 'id' => $event->Id], ['class' => 'btn btn-primary btn-labeled pull-right', 'style' => 'position:relative;top:-.5em;right:-1em'])?>
		</span>
	</div>
	<div class="panel-body">
		<table class="table">
			<tr>
				<th style="text-align:center">##</th>
				<th style="text-align:center">Обработано</th>
				<th style="text-align:center">RUNET-ID</th>
				<th>Ф.И.О.</th>
				<th>Email</th>
				<th>Телефон</th>
			</tr>
            <?foreach($signals as $signal):?>
                <?if($signal->Participant !== null):?>
                    <?php
                    $user = $signal->Participant->User;
                    $work = $user->getEmploymentPrimary();
                    ?>
					<tr>
						<td style="text-align:right;color:silver">#<?=$signal->Id?></td>
						<td style="text-align:right;color:silver" nowrap>
                            <?=$signal->Processed ? '✉️' : ''?>
                            <?=$signal->ProcessedTime?>
						</td>
						<td><a href="/user/edit/?id=<?=$user->RunetId?>" target="_blank"><?=$user->RunetId?></a></td>
						<td style="text-align:left">
                            <?=$user->getFullName()?>
                            <?if($work !== null):?>
								<br>
								<font color="silver">
                                    <?=implode(' / ', array_filter([$work->Company->Name, $work->Position]))?>
								</font>
                            <?endif?>
						</td>
						<td style="text-align:left"><a href="mailto:<?=$user->Email?>"><?=$user->Email?></a></td>
						<td style="text-align:left" nowrap><?=$user->getPhone()?></td>
					</tr>
                <?endif?>
            <?endforeach?>
		</table>
	</div>
</div>
<?$this->endWidget()?>

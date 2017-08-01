<?php

use partner\components\Controller;
use application\widgets\ActiveForm;

/**
 * @var Controller $this
 */
?>
<? $this->setPageTitle('Коды счетчиков') ?>
<? $activeForm = $this->beginWidget(ActiveForm::className()) ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-pencil"></i> <?= \Yii::t('app', 'Коды счетчиков') ?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?= $activeForm->errorSummary($form) ?>

        <div class="alert alert-info">
            <p>
                Счетчики бывают двух вариантов: видимые и невидимые.
                Как правило для сайта не имеет большого смысла размещать много счетчиков — достаточно одного-двух.
                На страницах сервиса RUNET–ID могут быть размещены только невидимые счетчики.
            </p>
            <p>
                Скопируйте HTML-код счетчика (или счетчиков) в поле ниже и они автоматически будут добавлены на все
                страницы, связанные с вашим мероприятием.
            </p>
        </div>
        <div class="form-group">
            <?= $activeForm->labelEx($form, 'Head'); ?>
            <?= $activeForm->textArea($form, 'Head', ['class' => 'form-control', 'rows' => '4', 'placeholder' => 'Вставьте HTML-код']); ?>
        </div>
        <div class="form-group">
            <?= $activeForm->labelEx($form, 'Body'); ?>
            <?= $activeForm->textArea($form, 'Body', ['class' => 'form-control', 'rows' => '4', 'placeholder' => 'Вставьте HTML-код']); ?>
        </div>

        <div class="form-group">
            <?= $activeForm->labelEx($form, 'AfterPayment'); ?>
            <div class="alert alert-info">
                <p>
                    Данный код счетчика будет установлен на страницу успешной оплаты и выставленного счета, вы также
                    можете использовать следующие переменные в коде для уточнения деталей по каждой оплате:
                    <ul>
                        <li>{transactionId} - уникальный номер транзакции</li>
                        <li>{revenue} - уникальный номер транзакции</li>
                        <li>{productId} - идентификатор товара/заказа</li>
                        <li>{productName} - наименование товара/заказа</li>
                        <li>{productCategory} - наименование категории</li>
                        <li>{productQuantity} - количество товаров</li>
                        <li>{productPrice} - стоимость единицы</li>
                        <li>{productRevenue} - итоговая сумма заказа</li>
                    </ul>
                </p>
            </div>
            <?= $activeForm->textArea($form, 'AfterPayment', ['class' => 'form-control', 'rows' => '4', 'placeholder' => 'Вставьте HTML-код']); ?>
        </div>
    </div>
    <div class="panel-footer">
        <?= \CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<? $this->endWidget() ?>

<?php
/**
 * @var \partner\components\Controller $this
 * @var Operator[] $operators
 * @var \ruvents\models\Account $account
 */

$this->layout = '/layouts/print';
$this->setPageTitle(\Yii::t('app', 'Печать настроек клиента'));
use ruvents\models\Operator;
?>
<h2 class="text-center"><?=\Yii::t('app', 'Хэш клиента')?></h2>
<p class="lead text-center"><?=$account->Hash?></p>
<hr/>

<h2 class="text-center"><?=\Yii::t('app', 'Операторы')?></h2>
<table class="table">
    <thead>
        <tr>
            <th><?=\Yii::t('app', 'Логин')?></th>
            <th><?=\Yii::t('app', 'Пароль')?></th>
        </tr>
    </thead>
    <tbody>
        <?foreach($operators as $operator):?>
            <tr>
                <td><?=$operator->Login?></td>
                <td><?=$operator->Password?></td>
            </tr>
        <?endforeach?>
    </tbody>
</table>
<h2 class="text-center" style="page-break-before: always;"><?=\Yii::t('app', 'Мобильное приложение')?></h2>
<div class="text-center">
    <?=\CHtml::image($this->createUrl('mobile'))?>
</div>
<?php
/**
 * @var \application\components\controllers\AdminMainController $this
 */

$this->setPageTitle('Печать партнерских договоров');
?>
<div class="btn-toolbar"></div>
<div class="well">
    <?= CHtml::link('<i class="icon-print"></i> без печатей', ['print', 'print' => true, 'clear' => true], [
        'class' => 'btn btn-large'
    ]) ?>

    <?= CHtml::link('<i class="icon-print"></i> с печатями', ['print', 'print' => true], [
        'class' => 'btn btn-large'
    ]) ?>
</div>
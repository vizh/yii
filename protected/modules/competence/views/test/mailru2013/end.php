<?php
/**
 * @var $done bool
 * @var $test \competence\models\Test
 */

/** @var \competence\models\Result $result */
$result = \competence\models\Result::model()
    ->byTestId($test->Id)->byUserId(Yii::app()->user->getCurrentUser()->Id)->find();
$fullData = $result !== null ? $result->getResultByData() : null;

$name = get_class(new \competence\models\tests\mailru2013\C6($test));
?>

<div class="row">
    <div class="span8 offset2 m-top_30 text-center">
        <p class="lead"><?= Yii::t('app', 'БОЛЬШОЕ СПАСИБО ЗА УЧАСТИЕ В НАШЕМ ИССЛЕДОВАНИИ') ?>!</p>
    </div>
</div>
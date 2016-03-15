<?php
/**
 * @var application\components\controllers\PublicMainController $this
 * @var competence\models\Test $test
 * @var bool $done
 */

$this->setPageTitle($test->Title);
?>

<div class="row">
    <div class="span12 m-top_30 text-center">
        <?php if (!empty($test->AfterEndText)): ?>
            <?=$test->AfterEndText?>
        <?php else: ?>
            <p class="lead" style="padding: 20px;">
                <?= Yii::t('app', 'Спасибо! Ваша анкета отправлена. Для регистрации нового участника перейдите к шагу 1') ?>!
            </p>
        <?php endif ?>
    </div>
</div>
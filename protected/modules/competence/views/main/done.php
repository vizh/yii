<?php
/**
 * @var application\components\controllers\PublicMainController $this
 * @var competence\models\Test $test
 * @var bool $done
 */

$this->setPageTitle($test->Title);
?>

<div class="row">
    <div class="span8 offset2 m-top_30 text-center">
        <?php if (!empty($test->AfterEndText)): ?>
            <?=$test->AfterEndText;?>
        <?php else: ?>
            <p class="lead">БОЛЬШОЕ СПАСИБО ЗА УЧАСТИЕ В НАШЕМ ИССЛЕДОВАНИИ!</p>
        <?php endif ?>
    </div>
</div>
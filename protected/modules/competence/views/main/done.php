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
        <?if(!empty($test->AfterEndText)):?>
            <?=$test->AfterEndText?>
        <?php else:?>
            <p class="lead" style="padding: 20px;">
                <?=Yii::t('app', 'БОЛЬШОЕ СПАСИБО ЗА УЧАСТИЕ В НАШЕМ ИССЛЕДОВАНИИ')?>!
            </p>
        <?endif?>
    </div>
</div>

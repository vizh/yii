<?php
/**
 * @var bool $done
 * @var competence\models\Test $test
 */
?>

<div class="row">
    <div class="span12 m-top_30 text-center">
        <?if(!empty($test->AfterEndText)):?>
            <?=$test->AfterEndText?>
        <?php else:?>
            <?=Yii::t('app', 'БОЛЬШОЕ СПАСИБО ЗА УЧАСТИЕ В НАШЕМ ИССЛЕДОВАНИИ')?>!
        <?endif?>

        <?if($done):?>
            <p style="color: #ff9900;">Вы уже ответили на вопросы исследования ранее.</p>
        <?endif?>
    </div>
</div>

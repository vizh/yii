<?
/**
 * @var $test \competence\models\Test
 */
?>
<div class="row">
    <div class="span8 offset2 m-top_30 text-center">
        <?php if (!empty($test->AfterText)):?>
            <?=$test->AfterText;?>
        <?php else:?>
            <p class="lead">Здравствуйте!</p>
            <p class="lead">Опрос окончен, спасибо за интерес.</p>
        <?php endif;?>
    </div>
</div>
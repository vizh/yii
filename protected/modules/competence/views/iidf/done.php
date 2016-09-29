<?php
/**
 * @var IidfController $this
 * @var Test $test
 */
use competence\models\Test;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?if(!empty($test->AfterEndText)):?>
                <?=$test->AfterEndText?>
            <?php else:?>
                <p class="lead"><strong>Спасибо, ваш отзыв очень важен для нас!</strong></p>
            <?endif?>
        </div>
    </div>
</div>

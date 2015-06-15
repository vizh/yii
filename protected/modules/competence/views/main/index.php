<?php
/**
 * @var $test \competence\models\Test
 */
?>
<div class="row">
    <div class="span8 offset2 m-top_30 text-center">
        <?=$test->Info;?>
        <div class="text-center m-top_30">
            <form action="" method="post">
                <input type="hidden" name="start" value="1">
                <button type="submit" class="btn btn-success"><?=$test->StartButtonText;?></button>
            </form>
        </div>
    </div>
</div>
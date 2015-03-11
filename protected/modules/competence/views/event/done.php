<?php
/**
 * @var \application\components\controllers\PublicMainController $this
 * @var Event $event
 * @var User $user
 * @var Test $test
 */
use event\models\Event;
use user\models\User;
use competence\models\Test;
?>
<div class="container interview m-top_30 m-bottom_40">
    <div class="row">
        <div class="span8 offset2 m-top_30 text-center">
            <?php if (!empty($test->AfterEndText)):?>
                <?=$test->AfterEndText;?>
            <?php else:?>
                <p class="lead"><strong>Спасибо, ваш отзыв очень важен для нас!</strong></p>
            <?php endif;?>
        </div>
    </div>
</div>

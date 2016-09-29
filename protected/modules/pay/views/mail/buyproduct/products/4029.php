<?php
/**
 * @var \pay\models\Product $product
 * @var \user\models\User $owner
 */
?>
<p>Здравствуйте!</p>

<p>На мероприятие <strong><?=$product->Event->Title?></strong> был успено приобретен товар <strong><?=$product->Title?></strong></p>
<p>
    <strong>Покупатель</strong><br/>
    <?=$owner->getFullName()?>, Email: <?=$owner->Email?>
</p>
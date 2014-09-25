<div class="container brief m-top_40 m-bottom_60">
    <ul class="nav nav-tabs">
        <?foreach ($this->getSteps() as $action => $params):?>
            <li class="<?if($action == $this->getAction()->getId()):?>active<?elseif (!$params[1]):?>disabled<?endif;?>">
                <a href="#" <?if ($params[1]):?>data-action="<?=$action;?>"<?endif;?>><?=$params[0];?></a>
            </li>
        <?endforeach;?>
    </ul>

    <?=$content?>
</div>
<div class="container brief m-top_40 m-bottom_60">
    <ul class="nav nav-pills">
        <?foreach ($this->getSteps() as $key => $action):?>
            <li class="<?if ($action == $this->getAction()->Id):?>active<?else:?>disabled<?endif;?>"><a href="#"><?=$this->getStepTitle($action);?></a></li>
        <?endforeach;?>
    </ul>

    <?=$content?>
</div>
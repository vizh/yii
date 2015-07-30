<?php
/**
 * @var \event\widgets\content\Slider $this
 * @var string[] $slides
 */
?>
<?php if (isset($this->WidgetContentSliderBeforetext)):?>
    <?=$this->WidgetContentSliderBeforetext;?>
<?php endif;?>
<div class="fotorama" data-width="100%">
    <?foreach ($slides as $slide):?>
        <?=$slide;?>
    <?endforeach;?>
</div>
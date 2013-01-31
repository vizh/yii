<?php
/**
 * @var $this \event\widgets\PhotoSlider
 */
$images = is_array($this->PhotoSliderImages) ? $this->PhotoSliderImages : array($this->PhotoSliderImages);
$flag = true;
?>

<div id="event-photos" class="photos">
  <img src="<?=$images[0];?>" width="240" height="180" alt="" id="event-photo" class="photo">
  <div id="event-thumbs" class="thumbs">
    <div class="slider">
      <div class="slides">
        <?foreach ($images as $image):?>
        <div class="slide">
          <img src="<?=$image;?>" width="40" height="30" alt="" class="thumb <?=$flag ? 'current' : '';?>">
        </div>
          <?$flag = false;?>
        <?endforeach;?>
      </div>
    </div>
    <i id="event-thumbs_prev" class="icon-chevron-left"></i>
    <i id="event-thumbs_next" class="icon-chevron-right"></i>
  </div>
</div>
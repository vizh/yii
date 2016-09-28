<div id="event-photos" class="photos">
  <img src="" width="240" alt="" id="event-photo" class="photo">
  <div id="event-thumbs" class="thumbs">
    <div class="slider">
      <div class="slides">
      <?foreach($this->getPhotos() as $photo):?>
        <img src="<?=$photo->get40px()?>" width="40" alt="" class="thumb" data-240px="<?=$photo->get240px()?>">
      <?endforeach?>
      </div>
    </div>
    <i id="event-thumbs_prev" class="icon-chevron-left"></i>
    <i id="event-thumbs_next" class="icon-chevron-right"></i>
  </div>
</div>
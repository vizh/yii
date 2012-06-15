<div id="edit_photo" class="edit-block">
  <div class="profile_picture">
    <img class="medium" src="<?=$this->Photo;?>" alt="">
    <img class="small" src="<?=$this->MiniPhoto;?>" alt="">
    <a id="delete_photo" href="#" class="delete_photo"><span>удалить фото</span></a>
  </div>
  <div id="new_profile_picture">
    <p>Выберите фотографию размером до 2 мегабайт в формате *.jpg, *.gif или *.png.</p>
    <p class="notice">Используйте только свои фотографии, другие изображения будут удаляться.</p>
    <input type="file" name="photo" value="" id="profile_picture_photo">
    <a id="load_photo" class="load_photo" href="#">Загрузить фотографию</a>
  </div>
  <!-- php code is here: http://deepliquid.com/content/Jcrop_Implementation_Theory.html
           samples: http://deepliquid.com/projects/Jcrop/demos.php?demo=live_crop -->
</div>
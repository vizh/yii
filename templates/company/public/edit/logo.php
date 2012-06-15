<div id="edit_logo" class="edit-block">
	<div class="profile_picture_company">
		<img class="medium" src="<?=$this->Logo;?>" alt="">
		<img class="small" src="<?=$this->MiniLogo;?>" alt="">
		<a id="delete_logo" href="#" class="delete_logo"><span>удалить логотип</span></a>
	</div>
	<div id="new_profile_picture">
		<p>Выберите логотип размером до 2 мегабайт в формате *.jpg, *.gif или *.png.</p>
		<input type="file" name="logo" value="" id="profile_picture_logo">
		<a id="load_logo" class="load_logo" href="#">Загрузить логотип</a>
	</div>
	<!-- php code is here: http://deepliquid.com/content/Jcrop_Implementation_Theory.html
					 samples: http://deepliquid.com/projects/Jcrop/demos.php?demo=live_crop -->
</div>
<div id="edit_address" class="edit-block">
	<dl>
		<dt>Страна:</dt>
		<dd>
			<select class="address" name="country" id="country">
				<option value="0" >Выберите страну</option>
				<?foreach($this->Countries as $country):?>
					<option value="<?=$country->CountryId;?>" <?=$this->CountryId == $country->CountryId ? 'selected' : ''?> ><?=$country->Name;?></option>
				<?endforeach;?>
			</select>
		</dd>
	</dl>
	<dl>
		<dt>Регион:</dt>
		<dd>
			<select class="address" name="region" id="region">
				<option value="0" >Выберите регион</option>
				<?foreach($this->Regions as $region):?>
					<option value="<?=$region->RegionId;?>" <?=$this->RegionId == $region->RegionId ? 'selected' : ''?> ><?=$region->Name;?></option>
				<?endforeach;?>
			</select>
		</dd>
	</dl>
	<dl>
		<dt>Город:</dt>
		<dd>
			<select class="address" name="city" id="city">
				<option value="0" >Выберите город</option>
				<?foreach($this->Cities as $city):?>
					<option value="<?=$city->CityId;?>" <?=$this->CityId == $city->CityId ? 'selected' : ''?> ><?=$city->Name;?></option>
				<?endforeach;?>
			</select>
		</dd>
	</dl>
	<dl class="separator">
		<dt>&nbsp;</dt>
		<dd>&nbsp;</dd>
	</dl>
	<dl>
		<dt>Почтовый индекс:</dt>
		<dd><input class="general_input" type="text" name="postalindex"
							 value="<?=$this->PostalIndex;?>" size="40"></dd>
	</dl>
	<dl>
		<dt>Улица:</dt>
		<dd><input class="general_input" type="text" name="street" value="<?=$this->Street;?>" size="40"></dd>
	</dl>
	<dl>
		<dt>Дом:</dt>
		<dd><input class="general_input" type="text" name="housenum" value="<?=isset($this->House[0]) ? $this->House[0] : '';?>" size="40"></dd>
	</dl>
	<dl>
		<dt>Строение:</dt>
		<dd><input class="general_input" type="text" name="building" value="<?=isset($this->House[1]) ? $this->House[1] : '';?>" size="40"></dd>
	</dl>
	<dl>
		<dt>Корпус:</dt>
		<dd><input class="general_input" type="text" name="housing" value="<?=isset($this->House[2]) ? $this->House[2] : '';?>" size="40"></dd>
	</dl>
	<dl>
		<dt>Квартира/комната:</dt>
		<dd><input class="general_input" type="text" name="apartment" value="<?=$this->Apartment;?>" size="40"></dd>
	</dl>
	<dl class="separator">
		<dt>&nbsp;</dt>
		<dd>&nbsp;</dd>
	</dl>
	<dl>
		<dt>&nbsp;</dt>
		<dd><a id="save_address" class="save_settings" href="">Сохранить изменения</a></dd>
	</dl>
</div>
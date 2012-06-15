<tr>
	<td class="f">Адрес:</td>
	<td>
		<?if($this->address):?>
			<a href="http://maps.yandex.ru/?text=<?=$this->encodeAddress?>&z=17&l=map" target="_blank"><?=$this->address?></a>
		<?else:?>
			точный адрес компании не установлен
		<?endif;?>
	</td>
</tr>
<?if($this->address):?>
  <tr><td colspan="2"><div id="YMapsID" class="c-map" addr="<?=$this->address?>"></div></td></tr>
<?endif;?>
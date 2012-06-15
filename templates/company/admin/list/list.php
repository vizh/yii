<form name="search_form&quot;" action="" method="post">
	<strong>Фильтр:</strong>
	<input type="hidden" value="search" name="action">
	<input type="text" value="<?=$this->Query;?>" maxlength="255" size="33" name="query_string">
	<select name="field">
		<option value="id" <?=$this->Field == 'id' ? 'selected="selected"' : '';?>>ID компании</option>
		<option value="name" <?=$this->Field == 'name' ? 'selected="selected"' : '';?>>Название компании</option>
	</select>
	<input type="submit" value="Поиск!">
</form>

<table width="100%" cellspacing="1" cellpadding="2" border="0" style="margin-top: 15px;">
<tbody>
<tr align="center" style="background-color: #6d705d; color: #e0e1db; font-weight: bold;">
	<td width="30">ID</td>
	<td>
		Название компании
	</td>
	<td>
		Email
	</td>
	<td>
		Страна
	</td>
	<td>
		Город
	</td>
	<td width="200">
		Создано / Обновлено
	</td>
	<td width="200">Управление</td>
</tr>
<?if (isset($this->Companies)):?>
	<?php echo $this->Companies;?>
<?else:?>
		<tr style="background-color: rgb(226, 227, 221);">
			<td colspan="7" align="left" style="color: #808080">
				<strong>Ни одной компании не найдено. Используйте фильтр для поиска.</strong>
			</td>
		</tr>
<?endif;?>

</tbody>
</table>
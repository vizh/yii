<tbody class="workList tbl-visible"><?=$this->WorkVisible?></tbody>
<tbody class="workList tbl-invisible"><?=$this->WorkInvisible?></tbody>
<?if (! $this->WorkInvisible->IsEmpty()):?>
	<tbody>
		<tr>
			<td class="expand_list">
				<a href="#" id="expand_work">Раскрыть список (+<?=$this->WorkInvisible->Count()?>)</a>
				<a href="#" id="collapse_work" class="invisible">Скрыть список</a>
			</td>
		</tr>
	</tbody>
<?endif;?>
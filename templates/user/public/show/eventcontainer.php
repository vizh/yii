<tbody class="eventList tbl-visible"><?=$this->EventVisible;?></tbody>
<tbody class="eventList tbl-invisible"><?=$this->EventInvisible;?></tbody>
<?if (! $this->EventInvisible->IsEmpty()):?>
	<tbody>
		<tr>
			<td class="expand_list">
				<a href="#" id="expand_event">Раскрыть список (+<?=$this->EventInvisible->Count()?>)</a>
				<a href="#" id="collapse_event" class="invisible">Скрыть список</a>
			</td>
		</tr>
	</tbody>
<?endif;?>
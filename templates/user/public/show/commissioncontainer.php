<tbody class="commissionList tbl-visible">
  <?=$this->CommissionVisible?>
</tbody>
<tbody class="commissionList tbl-invisible">
  <?=$this->CommissionInvisible?>
</tbody>
<?if (!$this->CommissionInvisible->IsEmpty()):?>
	<tbody>
		<tr>
			<td class="expand_list">
				<a href="#" id="expand_commission">Раскрыть список (+<?=$this->CommissionInvisible->Count()?>)</a>
				<a href="#" id="collapse_commission" class="invisible">Скрыть список</a>
			</td>
		</tr>
	</tbody>
<?endif;?>
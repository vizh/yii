<tr>
	<td class="f">Компания</td>
	<td>
		<p>
      <a href="/company/<?=$this->Id?>/" <?if ($this->FullName != ''):?>alt="<?=$this->FullName?>" title="<?=$this->FullName?>"<?endif;?> ><?=$this->Name?></a>
		  <div><strong><?=$this->Position?></strong></div>
			<?=$this->StartWorking?> — <?=$this->FinishWorking?>
		</p>
	</td>
</tr>
<tr>
	<td class="f">Сайт:</td>
	<td>
	<?php foreach($this->Sites as $site): ?>
		<a href="http://<?=$site->Url?>" target="_blank">http://<?=$site->Url?></a>
		<?php if ($this->Size > 1): ?>
			<br />
		<?php endif; ?>
	<?php endforeach; ?>
	</td>
</tr>

<tr>
	<td class="f">Email:</td>
	<td>
	<?php foreach($this->Emails as $email): ?>
		<a href="mailto:<?=$email->Email?>"><?=$email->Email?></a>
		<?php if ($this->Size > 1): ?>
			<br />
		<?php endif; ?>
	<?php endforeach; ?>
	</td>
</tr>

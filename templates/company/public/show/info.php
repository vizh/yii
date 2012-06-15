<h2 class="c-cont">Информация</h2>

<div class="comp-info">
<?php if (! $this->Info): ?>
<p>Информация о компании не задана.</p>
<?php else: ?>
<?=nl2br($this->Info);?>
<?php endif; ?>
<?if ($this->HasRss):?>
<p>
  Вы можете подписаться на <a target="_blank" href="/company/<?=$this->CompanyId?>/rss/">новости компании</a> через
  <a target="_blank" href="/company/<?=$this->CompanyId?>/rss/"><img src="/images/rss-icon-txt.gif" width="33" height="9" alt="" /></a>
</p>
<?endif;?>
</div>

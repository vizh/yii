<!--  start user-bar -->
<div id="userbar">
	<div class="center">
	<ul>
    <li><span style="color: #000;"><strong><?=number_format($this->CountEventUsers, 0, '.', ' ');?></strong> <?=Yii::t('app', 'регистрация|регистрации|регистраций|регистрации', $this->CountEventUsers);?> на мероприятия</span></li>
		<li>
			<form class="panel-search" action="/search/" method="get" accept-charset="utf-8">
				<input id="search" class="in-text js-autosuggest-field" name="q" type="text" placeholder="поиск по людям, компаниям, новостям" value="" autocomplete="off" x-webkit-speech="x-webkit-speech" />
				<div class="js-autosuggest-output-container"><div class="js-autosuggest-output hidden"></div></div>
			</form>
		</li>
		<li>
			<ul id="ub-person">
				<li><a href="/<?=$this->RocId?>/"><?php echo $this->FullName;?></a></li>
				<li class="logout"><a href="/main/logout/" class="exit">Выйти</a></li>
			</ul>
		</li>
	</ul>
	</div>
	<div class="clear">&nbsp;</div>
</div>
	<!-- end userbar -->
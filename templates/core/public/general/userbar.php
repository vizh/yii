<!--  start user-bar -->
<div id="userbar">
	<div class="center">
	<ul>
		<!--<li><a href="">Обновления</a> (12)</li>
		<li><a href="">Календарь</a> (3)</li>
		<li><a href="">Уведомления</a> (2)</li>-->
		<li>
			<form class="panel-search" action="/search/" method="get" accept-charset="utf-8">
				<input id="search" class="in-text js-autosuggest-field"
                name="q" type="text"
            value="поиск по людям, компаниям, новостям"
                 onfocus="if(this.value=='поиск по людям, компаниям, новостям'){this.value=''}"
                 onblur="if(this.value==''){this.value='поиск по людям, компаниям, новостям'}">
				<div class="js-autosuggest-output-container"><div class="js-autosuggest-output hidden"></div></div>
			</form>
		</li>
		<li>
			<ul id="ub-person">
				<li><a href="/<?=$this->RocId?>/"><?php echo $this->LastName;?> <?php echo $this->FirstName;?> <?php echo $this->FartherName;?></a></li>
				<li class="logout"><a href="/main/logout/" class="exit">Выйти</a></li>
			</ul>
		</li>
	</ul>
	</div>
	<div class="clear">&nbsp;</div>
</div>
	<!-- end userbar -->
<h1 class="event">Исследовательский проект<br />«Экономика Рунета 2011-2012»</h1>

<div id="large-left" class="event-content">
	<!-- content -->
  <div style="text-align: center;">
    <a title="Высшая Школа Экономики" target="_blank" style="display: block; float:left; padding: 40px 40px 20px 40px;" href="http://www.hse.ru/">
      <img src="http://rocid.ru/files/partners/hse-horizontal-black/logo-220.png" alt="Высшая Школа Экономики">
    </a>
    <a title="РАЭК" target="_blank" style="display: block; float: left; padding: 0 40px 20px 40px;" href="http://raec.ru/">
      <img src="http://rocid.ru/files/partners/raec/logo-180.gif" alt="РАЭК">
    </a>

    <div class="clear"></div>
  </div>

	<p>РАЭК и Национальный исследовательский университет - Высшая школа экономики проводят совместное исследовании «Экономика Рунета 2011-2012»,  основная задача которого – оценить текущее состояние и тенденции развития российских рынков интернет-бизнеса.</p>
	<p>Исследовательский проект «Экономика Рунета-2012» направлен на оценку объемов и состояния следующих <strong>основных российских интернет-рынков</strong>:</p>
	<ul style="margin-top: -15px; margin-left: 20px;">
    <?foreach ($this->Trends as $trend):?>
    <li><?=$trend->Title;?></li>
    <?endforeach;?>
	</ul>
	<p>По каждому из рынков предполагается получить следующие <strong>ключевые показатели</strong>:</p>
	<ul style="margin-top: -15px; margin-left: 20px;">
		<li>Объемы рынка</li>
		<li>Прибыльность</li>
		<li>Динамика объема и прибыльности по сравнению с предыдущими годами</li>
		<li>Поквартальная динамика в течение года</li>
		<li>Структура рынка</li>
		<li>Прогноз динамики рынка в 2012 году<br>
		</li>
	</ul>
	<p><strong>Исследование состоит из двух основных частей:</strong></p>
	<ul style="margin-top: -15px; margin-left: 20px;">
		<li>Онлайн опрос экспертов-представителей игроков рынка. Анкета состоит из трех основных частей: информация об эксперте; финансовые данные по компании,  которую представляет эксперт; финансовые оценки рынка в целом.</li>
		<li>Качественные (глубинные) интервью с экспертами, представляющими различные рынки.</li>
	</ul>
	<!--<p><a href="/i-research/vote/"><img src="/images/research/button.png" /></a></p>-->
	<p><a href="http://in-numbers.ru/i-research/" target="_blank">О ходе и результатах исследования</a></p>
	<p>Результаты исследования будут представлены в виде самостоятельного продукта и презентованы интернет-игрокам, широкой общественности,  СМИ,  государству.</p>

  <p>Если у вас возникнут какие-либо вопросы по исследованию, пожалуйста, обращайтесь: <a href="mailto:research2012@raec.ru">research2012@raec.ru</a></p>
	<!--<h2>Ссылки</h2>
	<div style="font-size: 14px;">
		<div>— <a href="#">Исследуемые интернет-рынки</a></div>
		<div>— <a href="<?=RouteRegistry::GetUrl('research', '', 'experts')?>">Экспертная группа (список экспертов по рынкам)</a></div>
		<div>— <a href="#">Заявить о своем желании стать экспертом по одному из рынков</a></div>
	</div>-->
	
<div class="clear"></div>

<!-- end large-left -->
</div>
<div class="sidebar sidebarrapple">

 <?php echo $this->Banner;?>

<!-- end sidebar -->
</div>

  <div class="clear"></div>
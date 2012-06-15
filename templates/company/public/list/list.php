<h1>Список компаний</h1>


<div id="large-left">

<div id="alfabet">

<ul class="abeth">
  <li><a href="/company/list/А">А</a></li>
  <li><a href="/company/list/Б">Б</a></li>
  <li><a href="/company/list/В">В</a></li>
  <li><a href="/company/list/Г">Г</a></li>
  <li><a href="/company/list/Д">Д</a></li>
  <li><a href="/company/list/Е">Е</a></li>
  <li><a href="/company/list/Ж">Ж</a></li>
  <li><a href="/company/list/З">З</a></li>
  <li><a href="/company/list/И">И</a></li>
  <li><a href="/company/list/К">К</a></li>
  <li><a href="/company/list/Л">Л</a></li>
  <li><a href="/company/list/М">М</a></li>
  <li><a href="/company/list/Н">Н</a></li>
  <li><a href="/company/list/О">О</a></li>
  <li><a href="/company/list/П">П</a></li>
  <li><a href="/company/list/Р">Р</a></li>
  <li><a href="/company/list/С">С</a></li>
  <li><a href="/company/list/Т">Т</a></li>
  <li><a href="/company/list/У">У</a></li>
  <li><a href="/company/list/Ф">Ф</a></li>
  <li><a href="/company/list/Х">Х</a></li>
  <li><a href="/company/list/Ц">Ц</a></li>
  <li><a href="/company/list/Ч">Ч</a></li>
  <li><a href="/company/list/Ш">Ш</a></li>
  <li><a href="/company/list/Щ">Щ</a></li>
  <li><a href="/company/list/Э">Э</a></li>
  <li><a href="/company/list/Ю">Ю</a></li>
  <li><a href="/company/list/Я">Я</a></li>
</ul>

<div class="clear"></div>
<ul class="abeth lat">
  <li><a href="/company/list">...</a></li>
  <li><a href="/company/list/A">A</a></li>
  <li><a href="/company/list/B">B</a></li>
  <li><a href="/company/list/C">C</a></li>
  <li><a href="/company/list/D">D</a></li>
  <li><a href="/company/list/E">E</a></li>
  <li><a href="/company/list/F">F</a></li>
  <li><a href="/company/list/G">G</a></li>
  <li><a href="/company/list/H">H</a></li>
  <li><a href="/company/list/I">I</a></li>
  <li><a href="/company/list/J">J</a></li>
  <li><a href="/company/list/K">K</a></li>
  <li><a href="/company/list/L">L</a></li>
  <li><a href="/company/list/M">M</a></li>
  <li><a href="/company/list/N">N</a></li>
  <li><a href="/company/list/O">O</a></li>
  <li><a href="/company/list/P">P</a></li>
  <li><a href="/company/list/Q">Q</a></li>
  <li><a href="/company/list/R">R</a></li>
  <li><a href="/company/list/S">S</a></li>
  <li><a href="/company/list/T">T</a></li>
  <li><a href="/company/list/U">U</a></li>
  <li><a href="/company/list/V">V</a></li>
  <li><a href="/company/list/W">W</a></li>
  <li><a href="/company/list/X">X</a></li>
  <li><a href="/company/list/Y">Y</a></li>
  <li><a href="/company/list/Z">Z</a></li>
</ul>


<div class="clear"></div>
<!-- end alfabet -->
</div>



<div class="rocid-peoples">

<?=$this->Companies?>

<!-- end rocid-peoples -->
</div>

<?=$this->Paginator?>

<!-- end large-left -->
</div>

<div class="sidebar sidebarpeoples">
<h1>По регионам</h1>
<div class="choose-form">
<form id="geoSelect" action="" method="post">
<div class="sel">
<select id="country" name="country">
  <?=$this->Country?>
</select>
</div>
<div class="sel">
<select id="region" name="region">
  <?=$this->Region?> 
</select>
</div>
<div class="sel">
<select id="city" name="city">
  <?=$this->City?> 
</select>
</div>
<div class="subm"><input id="search" name="search" type="submit" value="Поиск" /></div>
</form>
<!-- end choose-form -->
</div>

<?=$this->Banner;?>
   
</div>

  <div class="clear"></div>

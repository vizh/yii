<h1>Список пользователей</h1>


<div id="large-left">

<div id="alfabet">

<ul class="abeth">
  <li><a href="/user/list/А/<?=$this->Location?>">А</a></li>
  <li><a href="/user/list/Б/<?=$this->Location?>">Б</a></li>
  <li><a href="/user/list/В/<?=$this->Location?>">В</a></li>
  <li><a href="/user/list/Г/<?=$this->Location?>">Г</a></li>
  <li><a href="/user/list/Д/<?=$this->Location?>">Д</a></li>
  <li><a href="/user/list/Е/<?=$this->Location?>">Е</a></li>
  <li><a href="/user/list/Ж/<?=$this->Location?>">Ж</a></li>
  <li><a href="/user/list/З/<?=$this->Location?>">З</a></li>
  <li><a href="/user/list/И/<?=$this->Location?>">И</a></li>
  <li><a href="/user/list/К/<?=$this->Location?>">К</a></li>
  <li><a href="/user/list/Л/<?=$this->Location?>">Л</a></li>
  <li><a href="/user/list/М/<?=$this->Location?>">М</a></li>
  <li><a href="/user/list/Н/<?=$this->Location?>">Н</a></li>
  <li><a href="/user/list/О/<?=$this->Location?>">О</a></li>
  <li><a href="/user/list/П/<?=$this->Location?>">П</a></li>
  <li><a href="/user/list/Р/<?=$this->Location?>">Р</a></li>
  <li><a href="/user/list/С/<?=$this->Location?>">С</a></li>
  <li><a href="/user/list/Т/<?=$this->Location?>">Т</a></li>
  <li><a href="/user/list/У/<?=$this->Location?>">У</a></li>
  <li><a href="/user/list/Ф/<?=$this->Location?>">Ф</a></li>
  <li><a href="/user/list/Х/<?=$this->Location?>">Х</a></li>
  <li><a href="/user/list/Ц/<?=$this->Location?>">Ц</a></li>
  <li><a href="/user/list/Ч/<?=$this->Location?>">Ч</a></li>
  <li><a href="/user/list/Ш/<?=$this->Location?>">Ш</a></li>
  <li><a href="/user/list/Щ/<?=$this->Location?>">Щ</a></li>
  <li><a href="/user/list/Э/<?=$this->Location?>">Э</a></li>
  <li><a href="/user/list/Ю/<?=$this->Location?>">Ю</a></li>
  <li><a href="/user/list/Я/<?=$this->Location?>">Я</a></li>
</ul>

<div class="clear"></div>
<ul class="abeth lat">
  <li><a href="/user/list/all/<?=$this->Location?>">...</a></li>
  <li><a href="/user/list/A/<?=$this->Location?>">A</a></li>
  <li><a href="/user/list/B/<?=$this->Location?>">B</a></li>
  <li><a href="/user/list/C/<?=$this->Location?>">C</a></li>
  <li><a href="/user/list/D/<?=$this->Location?>">D</a></li>
  <li><a href="/user/list/E/<?=$this->Location?>">E</a></li>
  <li><a href="/user/list/F/<?=$this->Location?>">F</a></li>
  <li><a href="/user/list/G/<?=$this->Location?>">G</a></li>
  <li><a href="/user/list/H/<?=$this->Location?>">H</a></li>
  <li><a href="/user/list/I/<?=$this->Location?>">I</a></li>
  <li><a href="/user/list/J/<?=$this->Location?>">J</a></li>
  <li><a href="/user/list/K/<?=$this->Location?>">K</a></li>
  <li><a href="/user/list/L/<?=$this->Location?>">L</a></li>
  <li><a href="/user/list/M/<?=$this->Location?>">M</a></li>
  <li><a href="/user/list/N/<?=$this->Location?>">N</a></li>
  <li><a href="/user/list/O/<?=$this->Location?>">O</a></li>
  <li><a href="/user/list/P/<?=$this->Location?>">P</a></li>
  <li><a href="/user/list/Q/<?=$this->Location?>">Q</a></li>
  <li><a href="/user/list/R/<?=$this->Location?>">R</a></li>
  <li><a href="/user/list/S/<?=$this->Location?>">S</a></li>
  <li><a href="/user/list/T/<?=$this->Location?>">T</a></li>
  <li><a href="/user/list/U/<?=$this->Location?>">U</a></li>
  <li><a href="/user/list/V/<?=$this->Location?>">V</a></li>
  <li><a href="/user/list/W/<?=$this->Location?>">W</a></li>
  <li><a href="/user/list/X/<?=$this->Location?>">X</a></li>
  <li><a href="/user/list/Y/<?=$this->Location?>">Y</a></li>
  <li><a href="/user/list/Z/<?=$this->Location?>">Z</a></li>
</ul>


<div class="clear"></div>
<!-- end alfabet -->
</div>



<div class="rocid-peoples">

<?=$this->Users?>

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
<div class="subm"><input id="search" name="search" type="submit" value="<?=$this->SearchWord?>" /></div>
</form>
<!-- end choose-form -->
</div>

        <?php echo $this->Banner;?>

</div>

  <div class="clear"></div>

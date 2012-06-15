 <ul class="prevnext">
    <li class="p"><a href="<?=$this->BackLink?>" <?php if ($this->Page == 1):?>class="inactive"<?php endif;?>>предыдущая</a></li>
    <li class="n"><a href="<?=$this->NextLink?>" <?php if ($this->Page == $this->Count):?>class="inactive"<?php endif;?>>следующая</a></li>
  </ul>
  <div class="clear"></div>
  <ul class="paginator">
    <?=$this->Pages?>
  </ul>
<div class="clear"></div>
  <!-- Варианты страниц -->
  
<!--  <ul class="prevnext">
    <li class="p"><a href="">предыдущая</a></li>
    <li class="n"><a href="">следующая</a></li>
  </ul>
  <div class="clear"></div>
  <ul class="paginator">
    <li><a href="">1</a></li>
    <li><a href="">2</a></li>
    <li><a href="">3</a></li>
    <li><a href="">4</a></li>
    <li><a href="">5</a></li>
    <li><a href="">6</a></li>
    <li><a href="" class="curr">7</a></li>
    <li><a href="">8</a></li>
    <li><a href="">9</a></li>
    <li><a href="">10</a></li>
    <li><a href="">11</a></li>
    <li><a href="">12</a></li>
    <li><a href="">...</a></li>
  </ul>
  <div class="clear"></div>
  
  <ul class="prevnext">
    <li class="p"><a href="">предыдущая</a></li>
    <li class="n"><a href="" class="inactive">следующая</a></li>
  </ul>
  <div class="clear"></div>
  <ul class="paginator">
    <li><a href="">9</a></li>
    <li><a href="">8</a></li>
    <li><a href="">9</a></li>
    <li><a href="">10</a></li>
    <li><a href="">11</a></li>
    <li><a href="">12</a></li>
    <li><a href="">13</a></li>
    <li><a href="">14</a></li>
    <li><a href="">15</a></li>
    <li><a href="">16</a></li>
    <li><a href="">17</a></li>
    <li><a href="">18</a></li>
    <li><a href="" class="curr">19</a></li>
  </ul>
  <div class="clear"></div>-->
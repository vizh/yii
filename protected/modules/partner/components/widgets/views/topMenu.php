<?php
/**
 * @var $menu array
 */

if (\Yii::app()->partner->getAccount() != null):
  ?>
<div class="container navbar-fixed-top-menu">
  <div class="navbar">
    <div class="navbar-inner">
      <div class="nav-collapse">
        <ul class="nav">
          <?foreach ($menu as $item):?>
          <?if (!$item['Access']) { continue; }?>
          <li <?=$item['Active']? 'class="active"' : '';?>><a href="<?=$item['Url'];?>"><?=$item['Title'];?></a></li>
          <?endforeach;?>
        </ul>
        <ul class="nav pull-right">
          <li><a href="<?=\Yii::app()->createUrl('/partner/auth/logout');?>">Выход</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?endif;?>
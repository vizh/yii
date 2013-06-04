<?php
/**
 * @var $menu array
 */
$partner = \Yii::app()->partner;
if ($partner->getAccount() !== null):
  ?>
<div class="container navbar-fixed-top-menu">
  <div class="navbar navbar-inverse">
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
          <?if ($partner->getAccount()->getIsExtended() && $partner->getEvent() !== null):?>
            <li><a href="<?=\Yii::app()->createUrl('/partner/auth/logout', array('extended' => 'reset'));?>">Выход (<?=\Yii::app()->partner->getEvent()->IdName;?>)</a></li>
          <?endif;?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?endif;?>
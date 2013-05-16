<?php
/**
 * @var $this \event\widgets\Users
 * @var $users \user\models\User[]
 * @var $count int
 */
?>


<div id="<?=$this->getNameId();?>" class="tab">
  <div class="row participants units"><?
    foreach ($users as $user):
    ?><div class="span2 participant unit">
        <a href="<?=Yii::app()->createUrl('/user/view/index', array('runetId' => $user->RunetId));?>">
          <img src="<?=$user->getPhoto()->get58px();?>" alt="" width="58" height="58" class="photo">
          <div class="name"><?=$user->getName();?></div>
        </a>
        <?if ($user->getEmploymentPrimary() != null):?>
          <div class="company">
            <small class="muted"><?=$user->getEmploymentPrimary()->Company->Name;?></small>
          </div>
        <?endif;?>
      </div><?
    endforeach;
    ?></div>
  <div class="row m-top_40">
    <div class="span8">
      <p class="text-center"><a href="<?=Yii::app()->createUrl('/event/view/users', array('idName' => $this->event->IdName));?>">Всего зарегистрированно <?=Yii::t('app', '{n} участник|{n} участника|{n} участников|{n} участника', $count);?></a></p>
    </div>
  </div>
</div>
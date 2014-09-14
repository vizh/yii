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
        <?$noIndex = !$user->Settings->IndexProfile;?>
        <?php
          if (sizeof($user->Participants) > 1):
            $roles = array();
            foreach ($user->Participants as $participant):
             $roles[] = $participant->Role->Title;
            endforeach;
            $status = implode(', ', array_unique($roles));
          else:
            $status = $user->Participants[0]->Role->Title;
          endif;
        ?>
        <?if ($noIndex):?><!--noindex--><?endif;?>
        <a href="<?=$user->getUrl();?>" title="<?=$status;?>" <?if ($noIndex):?>rel="nofollow"<?endif;?>>
          <img src="<?=$user->getPhoto()->get58px();?>" alt="" width="58" height="58" class="photo">
          <div class="name"><?=$user->getName();?></div>
        </a>
        <?if ($user->getEmploymentPrimary() != null):?>
          <div class="company">
            <small class="muted"><?=$user->getEmploymentPrimary()->Company->Name;?></small>
          </div>
        <?endif;?>
        <?if ($user->getContactAddress() != null):?>
        <div class="city">
            <small class="muted"><nobr>г. <?=$user->getContactAddress()->City->Name;?></nobr></small>
        </div>
    <?endif;?>
      <?if ($noIndex):?><!--/noindex--><?endif;?>
      </div><?
    endforeach;
    ?></div>
  
  <?if ($this->showCounter):?>
  <div class="row m-top_40">
    <div class="<?=!$this->event->FullWidth ? 'span8' : 'span12';?>">
      <p class="text-center"><a href="<?=Yii::app()->createUrl('/event/view/users', array('idName' => $this->event->IdName));?>">Всего зарегистрировано <?=Yii::t('app', '{n} участник|{n} участника|{n} участников|{n} участника', $paginator->getCount());?></a></p>
    </div>
  </div>
  <?elseif($this->showPagination):?>
    <div class="row m-top_40">
      <div class="span8">
        <?$this->widget('\application\widgets\Paginator', array('paginator' => $paginator));?>
      </div>
    </div>
  <?endif;?>
</div>
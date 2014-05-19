<?/**
 * @var \event\models\Participant[] $participants
 * @var string[] $orderTypeList
 * @var string $order
 * @var int[] $userLinks
 * @var stdClass $userLinksCount
 * @var \application\widgets\Paginator $paginator
 */?>
<div class="participants clearfix">
  <div class="row-fluid">
    <div class="span6">
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
          <?=$orderTypeList[$order];?>
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <?foreach ($orderTypeList as $key => $value):?>
            <li <?if ($key == $order):?>class="active"<?endif;?>><a href="<?=$this->createUrl('/widget/link/index', ['order'=>$key]);?>"><?=$value;?></a></li>
          <?endforeach;?>
        </ul>
      </div>
    </div>
    <?if (!\Yii::app()->getUser()->getIsGuest() && $userLinksCount->all > 0):?>
    <div class="span6 text-right user-links">
      <a href="<?=$this->createUrl('/widget/link/cabinet');?>"><?=\Yii::t('app', 'Предложена {n} встреча|Предложено {n} встречи|Предложено {n} встреч|Предложено {n} встреч', $userLinksCount->all);?></a>
      <?if ($userLinksCount->new !== 0):?>
        <span class="label label-success">+<?=$userLinksCount->new;?></span>
      <?endif;?>
    </div>
    <?endif;?>
  </div>
  <hr class="m-top_10 m-bottom_10"/>
  <div class="clearfix">
  <?foreach($users as $user):?>
    <div class="participant">
      <a class="photo" href="<?=$user->getUrl();?>" target="_blank">
        <img src="<?=$user->getPhoto()->get50px();?>" alt=""/>
      </a>
      <div class="participant-body">
        <h4><a href="<?=$user->getUrl();?>" target="_blank"><?=$user->getFullName();?></a></h4>
        <?if ($user->getEmploymentPrimary() !== null):?>
          <p class="employent"><?=$user->getEmploymentPrimary()->Company->Name;?><?if (!empty($user->getEmploymentPrimary()->Position)):?>, <?=$user->getEmploymentPrimary()->Position;?><?endif;?></p>
        <?endif;?>
        <?if (!in_array($user->Id, $userLinks)):?>
          <a href="<?=$this->createUrl('/widget/link/index', ['ownerRunetId' => $user->RunetId, 'action' => 'suggest']);?>" class="btn btn-info btn-mini suggest"><?=\Yii::t('app','Предложить встречу');?></a>
          <a href="#" class="btn btn-mini disabled hide"><?=\Yii::t('app', 'Встреча предложена');?></a>
        <?else:?>
          <a href="#" class="btn btn-mini disabled"><?=\Yii::t('app', 'Встреча предложена');?></a>
        <?endif;?>
      </div>
    </div>
  <?endforeach;?>
  </div>
  <?$this->widget('\application\widgets\Paginator', ['paginator' => $paginator]);?>
</div>

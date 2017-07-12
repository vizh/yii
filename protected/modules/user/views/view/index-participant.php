<?php
/**
 * @var \user\controllers\view\ParticipantCollection $participation
 */
?>

<?if(!empty($participation->participants)):?>
  <div class="b-participated">
    <h4 class="b-header_large light">
      <div class="line"></div>
      <div class="container">
        <div class="title">
            <span class="backing text">
              <?=Yii::t('app', 'Участие в мероприятиях за')?>
              <form action="#" class="form-inline">
                <select name="participationYears" id="participationYears">
                  <option value="0"><?=Yii::t('app', 'За все время')?></option>
                  <?foreach($participation->years as $year):?>
                    <?if($year > 0):?>
                      <option value="<?=$year?>"><?=$year?></option>
                    <?endif?>
                  <?endforeach?>
                </select>
              </form>
            </span>
        </div>
      </div>
    </h4>
    <div class="container">
      <div class="row">
        <?foreach($participation->participants as $participant):?>
          <figure class="i span2" data-year="<?=$participant->event->StartYear?>">
            <?$logoExists = file_exists($participant->event->getLogo()->getOriginal(true))?>
            <a href="<?=$this->createUrl('/event/view/index', array('idName' => $participant->event->IdName))?>" class="event-link <?if(!$logoExists):?>text<?endif?>" title="<?=$participant->event->Title?>">
              <?if($logoExists):?>
                <?=\CHtml::image($participant->event->getLogo()->getOriginal(), $participant->event->Title, array('class' => 'img'))?>
              <?else:?>
                <span><?= \application\components\utility\Texts::cropText($participant->event->Title, 40)?></span>
              <?endif?>
            </a>
            <figcaption class="cnt">
              <?if(empty($participant->sectionRoleDetails)):?>
                <p class="tx"><?=$participant->role->Title?></p>
              <?else:?>
                <?foreach($participant->sectionRoleDetails as $roleDetail):?>
                  <div><a href="javascript:void(0);" class="a"><?=$roleDetail->role->Title?></a></div>
                <?endforeach?>
              <?endif?>
            </figcaption>
            <?if(!empty($participant->sectionRoleDetails)):?>
              <div class="popup">
                <div class="cnt">
                  <?foreach($participant->sectionRoleDetails as $roleDetail):?>
                    <div><a href="javascript:void(0);" class="a"><?=$roleDetail->role->Title?></a></div>
                    <?foreach($roleDetail->sectionLinkUsers as $linkUser):?>
                      <?if($linkUser->Section->getUrl() !== null):?>
                        <p class="tx"><a href="<?=$linkUser->Section->getUrl()?>" target="blank" alt="<?=$linkUser->Section->Title?>"><?=$linkUser->Section->Title?></a></p>
                      <?else:?>
                        <p class="tx"><?=$linkUser->Section->Title?></p>
                      <?endif?>
                    <?endforeach?>
                  <?endforeach?>
                </div>
              </div>
            <?endif?>
          </figure>
        <?endforeach?>
      </div>
      <div class="all">
        <a href="#" class="pseudo-link"><?=Yii::t('app', 'Все мероприятия')?></a>
      </div>
    </div>
  </div>
<?endif?>
<script type="text/javascript">
$(window).load(function() {

  new Chart({
    itemTemplate: $('#chart-item-template').html(),
    height: 220,
    avail: 2 * Math.PI,
    disp: 1.5 * Math.PI,
    clockwise: true,
    border: {
      size: 15,
      color: "#e6e6e6"
    },
    parts: [
      {color: "#ffd02e", val: <?=isset($participation->RoleCount->{\event\models\RoleType::Listener}) ? $participation->RoleCount->{\event\models\RoleType::Listener} : 0;?>, role: "слушателя"},
      {color: "#6363d2", val: <?=isset($participation->RoleCount->{\event\models\RoleType::Speaker}) ? $participation->RoleCount->{\event\models\RoleType::Speaker} : 0;?>, role: "докладчика"},
      {color: "#7d45a1", val: <?=isset($participation->RoleCount->{\event\models\RoleType::Master}) ? $participation->RoleCount->{\event\models\RoleType::Master} : 0;?>, role: "ведущего"}
    ],
    charts: [
      'charts-pie-canvas-1',
      'charts-pie-canvas-2',
      'charts-pie-canvas-3'
    ]          
  }).createOn('charts-pie');

  $('.charts-linear').find('.item').tooltip();

});
</script>
    

<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?=\Yii::t('app', 'Профиль пользователя');?></span>
    </div>
  </div>
</h2>

<div class="user-account">
  <div class="clearfix">
    <div class="container">
      <div class="b-card">
        <h5 class="b-header_small medium">
          <span class="backing">Runet</span>
          <span class="backing">ID</span>
        </h5>
        <div class="row">
          <div class="span3">
            <?=\CHtml::image($user->getPhoto()->get238px(), $user->getFullName(), array('class' => 'avatar'));?>
          </div>
          <div class="span8">
            <div class="row">
              <div class="span4 b-details">
                <b class="id"><?=$user->RunetId;?></b>
                <header>
                  <h4 class="title">
                    <?=$user->getShortName();?><br><span class="family-name"><?=$user->LastName;?></span>
                  </h4>
                  <?php $age = $user->getBirthDate();?>
                  <?if ($age > 0 || $user->LinkAddress !== null):?>
                    <small class="muted">
                      <?if ($age > 0):?>День рождения <?=$age;?>, <?endif;?>
                      <?if ($user->getContactAddress() !== null && $user->getContactAddress()->City !== null):?><?=$user->getContactAddress()->City->Name;?><?endif;?>
                    </small>
                  <?endif;?>
                </header>
                <?php $primaryEmployment = $user->getEmploymentPrimary();?>
                <?if ($primaryEmployment !== null):?>
                <div class="b-job">
                  <header>
                    <h6 class="title company">
                      <a href="<?=$this->createUrl('/company/view/index', array('companyId' => $primaryEmployment->Company->Id));?>">
                        <?=$primaryEmployment->Company->Name;?>
                      </a>
                    </h6>
                  </header> 
                  <?if (!empty($primaryEmployment->Position)):?>
                  <article>
                    <p class="text post"><?=$primaryEmployment->Position;?></p>
                  </article>
                  <?endif;?>
                </div>
                <?endif;?>

                <?if ($_SERVER['REMOTE_ADDR'] == '82.142.129.35'):?>
                <?if (!empty($professionalInterests)):?>
                <div class="b-interests">
                  <header>
                    <h6 class="title">Профессиональные интересы</h6>
                  </header>
                  <article>
                    <p class="text"><?=implode(', ', $professionalInterests);?></p>
                  </article>
                </div>
                <?endif;?>
                <?endif;?>

                <?if (!empty($user->CommissionsActive)):?>
                <div class="b-raec">
                  <img src="/images/content/raec-logo_small.jpg" alt="РАЭК" class="logo">
                  <?foreach ($user->CommissionsActive as $commission):?>
                  <p class="text"><?=$commission->Role->Title;?>, <?=$commission->Commission;?></p>
                  <?endforeach;?>
                </div>
                <?endif;?>
              </div>
              <div class="span4 b-contacts">
                <?if ($user->LinkSite !== null):?>
                <dl class="dl-horizontal">
                  <dt><?=\Yii::t('app', 'Сайт:');?></dt>
                  <dd><a href="<?=$user->LinkSite->Site;?>" target="_blank"><?=parse_url($user->LinkSite->Site, PHP_URL_HOST);?></a></dd>
                </dl>
                <?endif;?>
                <?foreach ($user->LinkServiceAccounts as $linkServiceAcc):?>
                  <?if ($linkServiceAcc->ServiceAccount !== null):?>
                    <dl class="dl-horizontal">
                      <dt><?=$linkServiceAcc->ServiceAccount->Type->Title;?>:</dt>
                      <dd><?=$linkServiceAcc->ServiceAccount;?></dd>
                    </dl>
                  <?endif;?>
                <?endforeach;?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="b-statistics">  
      <h4 class="b-header_large light">
        <div class="line"></div>
        <div class="container">
          <div class="title">
            <span class="backing text">Участие в профильных мероприятиях</span>
          </div>
        </div>
      </h4>
      <div class="container">
        <div class="charts">
          <!-- Charts pie -->
          <div class="clearfix">
            <div class="row">
              <div id="charts-pie-1" class="span4 charts-pie items"><canvas id="charts-pie-canvas-1"></canvas></div>
              <div id="charts-pie-2" class="span4 charts-pie items"><canvas id="charts-pie-canvas-2"></canvas></div>
              <div id="charts-pie-3" class="span4 charts-pie items"><canvas id="charts-pie-canvas-3"></canvas></div>
            </div>
          </div>
      </div>
    </div>

    <?if(!empty($participation->Participation)):?>
    <div class="b-participated">
      <h4 class="b-header_large light">
        <div class="line"></div>
        <div class="container">
          <div class="title">
            <span class="backing text">
              Участие в мероприятиях за
              <form action="#" class="form-inline">
                <select name="participationYears" id="participationYears">
                  <option value="0"><?=\Yii::t('app', 'За все время');?></option>
                  <?foreach($participation->Years as $year):?>
                    <?if ($year > 0):?>
                    <option value="<?=$year;?>"><?=$year;?></option>
                    <?endif;?>
                  <?endforeach;?>
                </select>
              </form>
            </span>
          </div>
        </div>
      </h4> 
      <div class="container">
        <?$rowCount = 1;?>
        <div class="row">
        <?foreach ($participation->Participation as $participant):?>
            <figure class="i span2" data-year="<?=$participant->Event->StartYear;?>">
              <?php $logoExists = file_exists($participant->Event->getLogo()->getOriginal(true));?>
              <a href="<?=$this->createUrl('/event/view/index', array('idName' => $participant->Event->IdName));?>" class="event-link <?if(!$logoExists):?>text<?endif;?>" title="<?=$participant->Event->Title;?>">
                <?if ($logoExists):?>
                  <?=\CHtml::image($participant->Event->getLogo()->getOriginal(), $participant->Event->Title, array('class' => 'img'));?>
                <?else:?>
                <span><?=  \application\components\utility\Texts::cropText($participant->Event->Title, 40);?></span>
                <?endif;?>
              </a>
              <figcaption class="cnt">
                <?foreach ($participant->Roles as $role):?>
                  <?if (!$participant->HasSections):?>
                    <p class="tx"><?=$role->Title;?></p>
                  <?else:?>
                    <div><a href="javascript:void(0);" class="a"><?=$role->Title;?></a></div>
                  <?endif;?>
                <?endforeach;?>
              </figcaption>
              <?if($participant->HasSections):?>
              <div class="popup">
                <div class="cnt">
                <?foreach ($participant->Roles as $role):?>
                  <div><a href="javascript:void(0);" class="a"><?=$role->Title;?></a></div>
                  <?foreach ($role->Sections as $section):?>
                    <?if ($section->getUrl() !== null):?>
                      <p class="tx"><a href="<?=$section->getUrl();?>" target="blank" alt="<?=$section->Title;?>"><?=$section->Title;?></a></p>
                    <?else:?>
                      <p class="tx"><?=$section->Title;?></p>
                    <?endif;?>
                  <?endforeach;?>
                <?endforeach;?>
                </div>
              </div>
              <?endif;?>
            </figure>
          <?if (($rowCount % 6) == 0):?>
          </div><div class="row">
          <?endif;?>
          <?$rowCount++;?>
        <?endforeach;?>
        </div>
        <div class="all">
          <a href="#" class="pseudo-link">Все мероприятия</a>
        </div>
      </div>
    </div>
    <?endif;?>
  </div>
</div>
  
<div class="b-participate"> 
  <h4 class="b-header_large light">
    <div class="line"></div>
    <div class="container">
      <div class="title">
        <span class="backing text">Примите участие</span>
      </div>
    </div>
  </h4>    
  <div id="participate-events" class="container">
    <div class="row">
      <?foreach ($recommendedEvents as $event):?>
        <div class="i span3">
          <header class="h">
            <div class="date">
              <?$this->widget('\event\widgets\Date', array('event' => $event));?>
            </div>
            <p class="tx muted"><?=$event->Type->Title;?></p>
            <h5 class="t"><a href="<?=$event->getUrl();?>"><?=$event->Title;?></a></h5>
          </header>
          <article class="cnt">
            <p class="tx"><?=\application\components\utility\Texts::cropText($event->Info,200);?></p>
          </article>
          <footer class="f">
            <a href="<?=$event->getUrl();?>" class="a">
              <i class="icon-circle-arrow-right"></i><?=\Yii::t('app', 'Посетить мероприятие');?>
            </a>
          </footer>
        </div>
      <?endforeach;?>
    </div>
  </div>
</div>

<script type="text/template" id="chart-item-template">
  <div class="item">
    <div class="info">
      <div class="val"><%= value %></div>
      <div class="description">В качестве <b><%= role%></b></div>
    </div>
  </div>
</script>

<script type="text/template" id="single-chart-item-template">
  <div class="item">
    <span class="val"><b><%= value %></b>%</span>
    <span class="description"><%= role %></span>
  </div>
</script>
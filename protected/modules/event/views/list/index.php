<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?=\Yii::t('app', 'Мероприятия')?></span>
    </div>
  </div>
</h2>

<div class="container">
  <?=\CHtml::form('', 'POST', array('class' => 'form-inline form-filter span12'))?>
    <?=\CHtml::activeDropDownList($filter, 'Type', $filter->getTypeList($month, $year),array('class' => 'span3 form-element_select'))?>
    <?=\CHtml::activeDropDownList($filter, 'City', $filter->getCityList($month, $year),array('class' => 'span3 form-element_select'))?>
    <?=\CHtml::activeTextField($filter, 'Query', array('placeholder' => \Yii::t('app', 'Поиск мероприятия'), 'class' => 'span5'))?>
    <?=\CHtml::imageButton('/images/search-type-image-light.png', array('width' => '20', 'height' => '19', 'class' => 'form-element_image'))?>
  <?=\CHtml::endForm()?>
</div>

<div class="events-box">
  <div class="container">
    <div class="row">
      <div class="events-month-select datetime span2 offset5">
        <a href="<?=$prevUrl?>" class="nav prev">
          <i class="icon-arrow-left"></i>
        </a>
        <div class="date">
          <h3 class="month"><?=\Yii::app()->getLocale()->getMonthName($month,'wide',true)?></h3>
          <div class="dropdown year">
            <a class="dropdown-toggle pseudo-link" data-toggle="dropdown" href="#"><?=$year?></a>
            <ul class="dropdown-menu" role="menu">
              <?for($y = date('Y')+1; $y >= 2007; $y--):?>
                <li><a href="<?=$this->createUrl('/event/list/index', array('Month' => $month,'Year' => $y))?>"><?=$y?></a></li>
              <?endfor?>
            </ul>
          </div>
        </div>
        <a href="<?=$nextUrl?>" class="nav next">
          <i class="icon-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>

  <?if(!empty($events)):?>
    <?$unitsOnRow = 3?>
    <?$i = 0?>
    <?while(true):?>
      <?$sliceEvents = array_slice($events, $i*$unitsOnRow, $unitsOnRow)?>
      <?if(empty($sliceEvents)) break?>
      <div class="container">
        <div class="row units events">
          <?foreach($sliceEvents as $event):?><div class="unit span4 event <?if($event->getFormattedEndDate('yyyy-MM-dd') < date('Y-m-d')):?>past<?endif?>" itemscope itemtype="http://schema.org/Event">
              <header>
                <p class="type"><small><?=$event->Type->Title?></small></p>
                <h3 class="date" itemprop="startDate" content="<?=$event->getFormattedStartDate('yyyy-MM-dd')?>"><?$this->widget('\event\widgets\Date', array('event' => $event))?></h3>
                <h3 class="title"><a href="<?=$event->getUrl()?>" itemprop="name"><?=$event->Title?></a></h3>
                <?if($event->getContactAddress() !== null):?>
                  <small class="muted" itemprop="location" itemscope itemtype="http://schema.org/Place">
                    <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                      <?=$event->getContactAddress()->getWithSchema()?>
                    </span>
                  </small>
                <?endif?>
              </header>
              <article>
                <p itemprop="description"><?=\application\components\utility\Texts::cropText($event->Info, \Yii::app()->params['EventPreviewLength'])?></p>
              </article>
              <footer>
                <?if(in_array($event->Id, $eventWithCurrentUser)):?>
                  <a href="<?=$event->getUrl()?>" class="btn disabled"><?=\Yii::t('app', 'Вы уже зарегистрированы')?></a>
                <?elseif (isset($event->Free) && $event->Free == 1):?>
                  <a href="<?=$event->getUrl()?>" class="btn btn-large btn-info"><?=\Yii::t('app', 'Регистрация бесплатна')?></a>
                <?endif?>
                <?if(in_array($event->Id, $eventWithPayAccounts)):?>
                  <p class="muted"><small><?=\Yii::t('app', 'Регистрация через RUNET-ID')?></small></p>
                <?endif?>
              </footer>
            </div><?endforeach?><?if(!isset($events[($i+1)*$unitsOnRow])):?><a class="unit span4 event add" href="<?=$this->createUrl('/event/create/index')?>">
                <h4><?=\Yii::t('app', 'Добавить')?><br/><?=\Yii::t('app', 'мероприятие')?></h4>
                <p class="muted"><small><?=\Yii::t('app', 'Вы&nbsp;можете предложить свое мероприятие для размещения в&nbsp;календаре')?></small></p>
              </a>
            <?endif?>
        </div>
      </div>

      <?if(isset($topEvents[$i])):?>
        <?$event = $topEvents[$i]?>
        <?$this->widget('\event\widgets\Promo', ['event' => $event, 'isCurrentUserParticipant' => in_array($event->Id, $eventWithCurrentUser)])?>
      <?endif?>
      <?$i++?>
    <?endwhile?>
  <?else:?>
    <div class="container">
      <div class="row units events">
        <a class="unit span4 event add" href="<?=$this->createUrl('/event/create/index')?>">
          <h4><?=\Yii::t('app', 'Добавить')?><br/><?=\Yii::t('app', 'мероприятие')?></h4>
          <p class="muted"><small><?=\Yii::t('app', 'Вы&nbsp;можете предложить свое мероприятие для размещения в&nbsp;календаре')?></small></p>
        </a>
      </div>
    </div>
  <?endif?>

  <ul class="pager">
    <li><a href="<?=$prevUrl?>">&larr;&nbsp;Старые</a></li>
    <li><a href="<?=$nextUrl?>">Новые&nbsp;&rarr;</a></li>
  </ul>
</div>

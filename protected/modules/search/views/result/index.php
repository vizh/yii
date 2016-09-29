<script>
  $(function () {
    $('a[href="#<?=$activeTabId?>"]').trigger('click');
  });
</script>

<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?=\Yii::t('app', 'Результаты поиска')?></span>
    </div>
  </div>
</h2>

<div class="search-results">
  <div class="container">
    <div id="search-tabs" class="tabs">
      <?if(empty($term)):?>
        <header class="h">
          <h4 class="t"><?=\Yii::t('app', 'Вы не указали поисковый запрос!')?></h4>
        </header>
      <?elseif (empty($results->Results)):?>
        <header class="h">
          <h4 class="t"><?=\Yii::t('app', 'По запросу &laquo;<b>{term}</b>&raquo; ничего не найдено!', array('{term}' => $term))?></h4>
        </header>
      <?else:?>
      <header class="h">
        <h4 class="t"><?=\Yii::t('app', 'По запросу &laquo;<b>{term}</b>&raquo; найдено:', array('{term}' => $term))?></h4>
      </header>

      <ul class="nav">
        <li><a href="#<?=\search\components\SearchResultTabId::User?>" class="pseudo-link">
          <?=\Yii::t('app', '{n} пользователь|{n} пользователя|{n} пользователей|{n} пользователя', $results->Counts['user\models\User'])?>
        </a></li>
        <li>/</li>
        <li><a href="#<?=\search\components\SearchResultTabId::Companies?>" class="pseudo-link active">
          <?=\Yii::t('app', '{n} компания|{n} компании|{n} компаний|{n} компания', $results->Counts['company\models\Company'])?>
        </a></li>
        <li>/</li>
        <li><a href="#<?=\search\components\SearchResultTabId::Events?>" class="pseudo-link">
          <?=\Yii::t('app', '{n} мероприятие|{n} мероприятия|{n} мероприятий|{n} мероприятие', $results->Counts['event\models\Event'])?>
        </a></li>
      </ul>

      <?$model = 'user\models\User'?>
      <?if(!empty($results->Results[$model])):?>
      <div id="<?=\search\components\SearchResultTabId::User?>" class="tab users-list">
        <div class="row">
          <div class="span8 offset2">
            <table class="table">
              <tbody>
                <?foreach($results->Results[$model] as $user):?>
                <tr class="user-h">
                  <td colspan="3">
                    <div>
                      <b class="h pull-left muted">Runet ID</b>
                      <hr>
                      <b class="id pull-right"><?=$user->RunetId?></b>
                    </div>
                  </td>
                </tr>
                <tr class="user-cnt">
                  <td class="span1">
                    <a href="<?=$this->createUrl('/user/view/index', array('runetId' => $user->RunetId))?>">
                      <?=\CHtml::image($user->getPhoto()->get58px(), $user->getFullName())?>
                    </a>
                  </td>
                  <td class="span4 user">
                    <a href="<?=$this->createUrl('/user/view/index', array('runetId' => $user->RunetId))?>">
                      <h4 class="title"><?=$user->LastName?></h4>
                      <p class="name"><?=$user->getShortName()?></p>
                    </a>
                  </td>
                  <td class="span3">
                    <p class="job muted">
                      <?$employment = $user->getEmploymentPrimary()?>
                      <?if($employment !== null):?>
                      <b><?=$employment->Company->Name?></b><br><?=$employment->Position?>
                      <?endif?>
                    </p>
                  </td>
                </tr>
                <?endforeach?>
              </tbody>
            </table>
          </div>
        </div>

        <?$this->widget('\application\widgets\Paginator', array(
          'paginator' => $paginators->$model
        ))?>
      </div>
      <?endif?>

      <?$model = 'company\models\Company'?>
      <?if(!empty($results->Results[$model])):?>
      <div id="<?=\search\components\SearchResultTabId::Companies?>" class="tab companies-list">
        <div class="row">
          <div class="span8 offset2">
            <table class="table">
              <tbody>
                <?foreach($results->Results[$model] as $company):?>
                <tr>
                  <td class="span1">
                    <a href="<?=$this->createUrl('/company/view/index', array('companyId' => $company->Id))?>">
                      <?=\CHtml::image($company->getLogo()->get58px(), $company->Name)?>
                    </a>
                  </td>
                  <td class="span3">
                    <h4 class="title">
                      <a href="<?=$this->createUrl('/company/view/index', array('companyId' => $company->Id))?>"><?=$company->Name?></a>
                    </h4>
                    <?if(!empty($company->LinkAddress)):?>
                    <p class="location"><?=$company->LinkAddress->Address->City->Name?></p>
                    <?endif?>
                    <p class="employees"><?=\Yii::t('app', '<b>{n}</b> сотрудник|<b>{n}</b> сотрудника|<b>{n}</b> сотрудников|<b>{n}</b> сотрудника', sizeof($company->Employments))?></p>
                  </td>
                  <td class="span2">
                    <?foreach($company->LinkPhones as $link):?>
                    <p><?=$link->Phone?></p>
                    <?endforeach?>
                  </td>
                  <td class="span2 t-right">
                    <?foreach($company->LinkEmails as $link):?>
                    <p><a href="mailto:<?=$link->Email->Email?>"><?=$link->Email->Email?></a> <?if(!empty($link->Email->Title)):?>(<?=$link->Email->Title?>)<?endif?></p>
                    <?endforeach?>

                    <?if(!empty($company->LinkSite)):?>
                    <p><a href="<?=$company->LinkSite->Site?>"><?=$company->LinkSite->Site->Url?></a></p>
                    <?endif?>
                  </td>
                </tr>
                <?endforeach?>
              </tbody>
            </table>
          </div>
        </div>

        <?$this->widget('\application\widgets\Paginator', array(
          'paginator' => $paginators->$model
        ))?>
      </div>
      <?endif?>

      <?$model = 'event\models\Event'?>
      <?if(!empty($results->Results[$model])):?>
      <div id="<?=\search\components\SearchResultTabId::Events?>" class="tab event-list">
        <div class="row">
          <div class="span8 offset2">
            <table class="table">
              <tbody>
                <?foreach($results->Results[$model] as $event):?>
                <tr>
                  <td class="span1">
                    <a href="<?=$event->getUrl()?>">
                      <?=\CHtml::image($event->getLogo()->getOriginal(), $event->Title)?>
                    </a>
                  </td>
                  <td>
                    <h4 class="title">
                      <a href="<?=$event->getUrl()?>"><?=$event->Title?></a>
                    </h4>
                    <?if(!empty($event->Info)):?>
                      <p><?=$event->Info?></p>
                    <?endif?>
                  </td>
                </tr>
                <?endforeach?>
              </tbody>
            </table>
          </div>
        </div>

        <?$this->widget('\application\widgets\Paginator', array(
          'paginator' => $paginators->$model
        ))?>
      </div>
      <?endif?>


      <?endif?>
    </div>
  </div>
</div>
<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?=\Yii::t('app', 'Профиль компании')?></span>
    </div>
  </div>
</h2>

<div class="company-account">
  <div class="container">

    <div class="b-card">
      <h5 class="b-header_small medium">
        <span class="backing">Runet</span>
        <span class="backing">ID</span>
      </h5>

      <?if($showEdit):?>
      <h5 class="b-header_small" style="margin-left: 790px;">
        <a href="<?=$this->createUrl('/company/edit/index', array('companyId' => $company->Id))?>" class="backing"><?=\Yii::t('app','Редактировать')?></a>
      </h5>
      <?endif?>

      <div class="row" itemscope itemtype="http://schema.org/Organization">
        <div class="span3">
          <?=\CHtml::image($company->getLogo()->get200px(), $company->Name, ['itemprop' => 'logo'])?>
        </div>
        <div class="span8">
          <div class="row">
            <div class="span4 b-details">
              <header>
                <h3 class="title" itemprop="name"><?=$company->Name?></h3>
                <?if(!empty($company->FullName)):?>
                <h4 class="transcription"><?=$company->FullName?></h4>
                <?endif?>
              </header>

              <?if(!empty($company->FullInfo)):?>
                <article id="company-description" class="description" itemprop="description">
                  <?=$company->FullInfo?>
                </article>
                <?if(mb_strlen($company->FullInfo, 'utf-8') > 260):?>
                  <a href="#" id="company-description_toggle" class="pseudo-link all"><?=\Yii::t('app', 'Полное описание')?></a>
                <?endif?>
              <?endif?>
            </div>
            <div class="span4 b-contacts">
              <?if(!empty($company->LinkEmails)):?>
              <dl class="dl-horizontal">
                <dt>Эл. почта:</dt>
                <?foreach($company->LinkEmails as $link):?>
                <dd><a href="mailto:<?=$link->Email->Email?>" itemprop="email"><?=$link->Email->Email?></a> <?if(!empty($link->Email->Title)):?>(<?=$link->Email->Title?>)<?endif?></dd>
                <?endforeach?>
              </dl>
              <?endif?>

              <?if(!empty($company->LinkSite)):?>
              <dl class="dl-horizontal">
                <dt>Сайт:</dt>
                <dd><a href="<?=$company->LinkSite->Site?>" itemprop="url"><?=$company->LinkSite->Site->Url?></a></dd>
              </dl>
              <?endif?>
              <?if(!empty($company->LinkPhones)):?>
              <dl class="dl-horizontal">
                <dt>Телефон:</dt>
                <dd>
                  <?foreach($company->LinkPhones as $link):?>
                    <b itemprop="telephone"><?=$link->Phone?></b>
                  <?endforeach?>
                </dd>
              </dl>
              <?endif?>

              <?if(!empty($company->LinkAddress)):?>
              <dl class="dl-horizontal" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                <dt>Адрес:</dt>
                <dd><?=$company->LinkAddress->Address->getWithSchema()?></dd>
              </dl>
              <?endif?>
            </div>
          </div>
        </div>
      </div>
    </div>


    <?if(!empty($employments)):?>
    <div class="b-employees units">
      <h4 class="title"><?=\Yii::t('app', 'Сотрудники компании')?></h4>
      <div class="row">
        <?foreach($employments as $employment):?><div class="employee unit span2">
          <?$noIndex = !$employment->User->Settings->IndexProfile?>
          <?if($noIndex):?><!--noindex--><?endif?>
          <a href="<?=$this->createUrl('/user/view/index', array('runetId' => $employment->User->RunetId))?>" class="imgcrop-140" <?if($noIndex):?>rel="nofollow"<?endif?>>
            <?=\CHtml::image($employment->User->Photo->get200px(), $employment->User->getFullName(), array('width' => 138, 'height' => 138))?>
          </a>
          <p class="name"><a href="<?=$this->createUrl('/user/view/index', array('runetId' => $employment->User->RunetId))?>" <?if($noIndex):?>rel="nofollow"<?endif?>><?=$employment->User->getFullName()?></a></p>
          <p class="post"><?=$employment->Position?></p>
          <?if($noIndex):?><!--/noindex--><?endif?>
        </div><?endforeach?>
    </div>
    <?endif?>

    <?if(!empty($employmentsEx)):?>
    <div class="b-employees_ex units">
      <h5 class="title"><?=\Yii::t('app', 'Работали раньше')?></h5>
      <div class="row">
        <?foreach($employmentsEx as $employment):?><div class="employee_ex unit span2">
          <?$noIndex = !$employment->User->Settings->IndexProfile?>
          <?if($noIndex):?><!--noindex--><?endif?>
          <a href="<?=$this->createUrl('/user/view/index', array('runetId' => $employment->User->RunetId))?>" <?if($noIndex):?>rel="nofollow"<?endif?>>
            <?=\CHtml::image($employment->User->Photo->get90px(), $employment->User->getFullName(), array('width' => 58, 'height' => 58, 'class' => 'photo'))?>
            <p class="name"><?=$employment->User->getFullName()?></p>
          </a>
          <p class="company">
            <?=$employment->Position?>
          </p>
          <?if($noIndex):?><!--/noindex--><?endif?>
        </div><?endforeach?>
      </div>
    </div>
    <?endif?>
  </div>
</div>
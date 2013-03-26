<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?=\Yii::t('app', 'Профиль компании');?></span>
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
      <div class="row">
        <div class="span3">
          <?=\CHtml::image($company->getLogo(), $company->Name, array('width' => 200, 'height' => 120));?>
        </div>
        <div class="span8">
          <div class="row">
            <div class="span4 b-details">
              <header>
                <h3 class="title"><?=$company->Name;?></h3>
                <?if (!empty($company->FullName)):?>
                <h4 class="transcription"><?=$company->FullName;?></h4>
                <?endif;?>
              </header>

              <?if (!empty($company->FullInfo)):?>
                <article id="company-description" class="description">
                  <?=$company->FullInfo;?>
                </article>
                <?if (mb_strlen($company->FullInfo, 'utf-8') > 260):?>
                  <a href="#" id="company-description_toggle" class="pseudo-link all"><?=\Yii::t('app', 'Полное описание');?></a>
                <?php endif;?>
              <?endif;?>
            </div>
            <div class="span4 b-contacts">
              <?if (!empty($company->LinkEmails)):?>
              <dl class="dl-horizontal">
                <dt>Эл. почта:</dt>
                <?php foreach ($company->LinkEmails as $link):?>
                <dd><a href="mailto:<?=$link->Email->Email;?>"><?=$link->Email->Email;?></a> <?if(!empty($link->Email->Title)):?>(<?=$link->Email->Title;?>)<?php endif;?></dd>
                <?php endforeach;?>
              </dl>
              <?endif;?>

              <?if(!empty($company->LinkSite)):?>
              <dl class="dl-horizontal">
                <dt>Сайт:</dt>
                <dd><a href="<?=$company->LinkSite->Site;?>"><?=$company->LinkSite->Site->Url;?></a></dd>
              </dl>
              <?endif;?>
              <?if(!empty($company->LinkPhones)):?>
              <dl class="dl-horizontal">
                <dt>Телефон:</dt>
                <dd>
                  <?php foreach ($company->LinkPhones as $link):?>
                    <b><?=$link->Phone;?></b>
                  <?php endforeach;?>
                </dd>
              </dl>
              <?endif;?>

              <?if (!empty($company->LinkAddress)):?>
              <dl class="dl-horizontal">
                <dt>Адрес:</dt>
                <dd><?=$company->LinkAddress->Address;?></dd>
              </dl>
              <?endif;?>
            </div>
          </div>
        </div>
      </div>
    </div>


    <?if (!empty($employments)):?>
    <div class="b-employees units">
      <h4 class="title"><?=\Yii::t('app', 'Сотрудники компании');?></h4>
      <div class="row">
        <?foreach ($employments as $employment):?>
        <div class="employee unit span2">
          <a href="<?=$this->createUrl('/user/view/index', array('runetId' => $employment->User->RunetId));?>">
            <?=\CHtml::image($employment->User->Photo->get200px(), $employment->User->getFullName(), array('width' => 138, 'height' => 138));?>
            <p class="name"><?=$employment->User->getFullName();?></p>
          </a>
          <p class="post"><?=$employment->Position;?></p>
        </div>
        <?endforeach;?>
    </div>
    <?endif;?>

    <?if (!empty($employmentsEx)):?>
    <div class="b-employees_ex units">
      <h5 class="title"><?=\Yii::t('app', 'Работали раньше');?></h5>
      <div class="row">
        <?foreach ($employmentsEx as $employment):?>
        <div class="employee_ex unit span2">
          <a href="<?=$this->createUrl('/user/view/index', array('runetId' => $employment->User->RunetId));?>">
            <?=\CHtml::image($employment->User->Photo->get90px(), $employment->User->getFullName(), array('width' => 58, 'height' => 58, 'class' => 'photo'));?>
            <p class="name"><?=$employment->User->getFullName();?></p>
          </a>
          <p class="company">
            <?=$employment->Position;?>
          </p>
        </div>
        <?endforeach;?>
      </div>
    </div>
    <?endif;?>
  </div>
</div>
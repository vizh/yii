<section id="section" role="main">
  <h2 class="b-header_large light">
    <div class="line"></div>
    <div class="container">
      <div class="title">
        <span class="backing runet">Runet</span>
        <span class="backing text"><?php echo \Yii::t('app', 'Профиль компании');?></span>
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
            <?php echo \CHtml::image($company->getLogo(), $company->Name, array('width' => 200, 'height' => 120));?>
          </div>
          <div class="span8">
            <div class="row">
              <div class="span4 b-details">
                <header>
                  <h3 class="title"><?php echo $company->Name;?></h3>
                  <?php if (!empty($company->FullName)):?>
                  <h4 class="transcription"><?php echo $company->FullName;?></h4>
                  <?php endif;?>
                </header>
                
                <?php if (!empty($company->FullInfo)):?>
                  <article id="company-description" class="description">
                    <?php echo $company->FullInfo;?>
                  </article>
                  <?php if (mb_strlen($company->FullInfo, 'utf-8') > 260):?>
                    <a href="#" id="company-description_toggle" class="pseudo-link all"><?php echo \Yii::t('app', 'Полное описание');?></a>
                  <?php endif;?>
                <?php endif;?>
              </div>
              <div class="span4 b-contacts">
                <?php if (!empty($company->LinkEmails)):?>
                <dl class="dl-horizontal">
                  <dt>Эл. почта:</dt>
                  <?php foreach ($company->LinkEmails as $link):?>
                  <dd><a href="mailto:<?php echo $link->Email->Email;?>"><?php echo $link->Email->Email;?></a> <?php if(!empty($link->Email->Title)):?>(<?php echo $link->Email->Title;?>)<?php endif;?></dd>
                  <?php endforeach;?>
                </dl>
                <?php endif;?>
                
                <?php if(!empty($company->LinkSite)):?>
                <dl class="dl-horizontal">
                  <dt>Сайт:</dt>
                  <dd><a href="<?php echo $company->LinkSite->Site;?>"><?php echo $company->LinkSite->Site->Url;?></a></dd>
                </dl>
                <?php endif;?>
                <?php if (!empty($company->LinkPhones)):?>
                <dl class="dl-horizontal">
                  <dt>Телефон:</dt>
                  <dd>
                    <?php foreach ($company->LinkPhones as $link):?>
                      <b><?php echo $link->Phone;?></b>
                    <?php endforeach;?>
                  </dd>
                </dl>
                <?php endif;?>
                
                <?php if (!empty($company->LinkAddress)):?>
                <dl class="dl-horizontal">
                  <dt>Адрес:</dt>
                  <dd><?php echo $company->LinkAddress->Address;?></dd>
                </dl>
                <?php endif;?>
              </div>
            </div>
          </div>
        </div>
      </div>
        
      
      <?php if (!empty($employments)):?>
      <div class="b-employees units">
        <h4 class="title"><?php echo \Yii::t('app', 'Сотрудники компании');?></h4>
        <div class="row">
          <?php foreach ($employments as $employment):?>
          <div class="employee unit span2">
            <a href="<?php echo $this->createUrl('/user/view/index', array('RunetId' => $employment->User->RunetId));?>">
              <?php echo \CHtml::image($employment->User->Photo->get200px(), $employment->User->getFullName(), array('width' => 138, 'height' => 138));?>
              <p class="name"><?php echo $employment->User->getFullName();?></p>
            </a>
            <p class="post"><?php echo $employment->Position;?></p>
          </div>
          <?php endforeach;?>
      </div>
      <?php endif;?>

      <?php if (!empty($employmentsEx)):?>
      <div class="b-employees_ex units">
        <h5 class="title"><?php echo \Yii::t('app', 'Работали раньше');?></h5>
        <div class="row">
          <?php foreach ($employmentsEx as $employment):?>
          <div class="employee_ex unit span2">
            <a href="<?php echo $this->createUrl('/user/view/index', array('RunetId' => $employment->User->RunetId));?>">
              <?php echo \CHtml::image($employment->User->Photo->get90px(), $employment->User->getFullName(), array('width' => 58, 'height' => 58, 'class' => 'photo'));?>
              <p class="name"><?php echo $employment->User->getFullName();?></p>
            </a>
            <p class="company">
              <?php echo $employment->Position;?>
            </p>
          </div>
          <?php endforeach;?>
        </div>
      </div>
      <?php endif;?>
    </div>
  </div>
</section>
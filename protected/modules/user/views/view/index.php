<?php
/**
 * @var \user\models\User $user
 * @var string[] $professionalInterests
 * @var \user\controllers\view\ParticipantCollection $participation
 */

use event\models\RoleType;

$hasContacts = !empty($user->LinkSite) || !empty($user->LinkServiceAccounts);
?>
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
                {color: "#ffd02e", val: <?=isset($participation->count[RoleType::LISTENER]) ? $participation->count[RoleType::LISTENER] : 0?>, role: "слушателя"},
                {color: "#6363d2", val: <?=isset($participation->count[RoleType::SPEAKER]) ? $participation->count[RoleType::SPEAKER] : 0?>, role: "докладчика"},
                {color: "#7d45a1", val: <?=isset($participation->count[RoleType::MASTER]) ? $participation->count[RoleType::MASTER] : 0?>, role: "ведущего"}
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
            <span class="backing text"><?=Yii::t('app', 'Профиль пользователя')?></span>
        </div>
    </div>
</h2>

<div class="user-account">
<div class="clearfix">
    <div class="container">
        <div class="b-card"  itemscope="" itemtype="http://schema.org/Person">
            <h5 class="b-header_small medium">
                <span class="backing">Runet</span>
                <span class="backing">ID</span>
            </h5>
            <div class="row">
                <div class="span3">
                    <?=\CHtml::image($user->getPhoto()->get238px(), $user->getFullName(), array('class' => 'avatar'))?>
                </div>
                <div class="span8">
                    <div class="row">
                        <div class="span4 b-details">
                            <b class="id"><?=$user->RunetId?></b>
                            <header>
                                <h4 class="title">
                                    <span itemprop="givenName"><?=$user->FirstName?></span> <span itemprop="additionalName"><?=$user->FatherName?></span>
                                    <br><span class="family-name" itemprop="familyName"><?=$user->LastName?></span>
                                </h4>
                                <?$age = $user->getBirthDate()?>
                                <?if($age > 0 || $user->LinkAddress !== null):?>
                                    <small class="muted">
                                        <?if($age > 0):?><?=Yii::t('app', 'День рождения')?> <span itemprop="birthDate" datetime="<?=$user->Birthday?>"><?=$age?></span>,<?endif?>
                                        <?if($user->getContactAddress() !== null && $user->getContactAddress()->City !== null):?><?=$user->getContactAddress()->City->Name?><?endif?>
                                    </small>
                                <?endif?>
                            </header>
                            <?$primaryEmployment = $user->getEmploymentPrimary()?>
                            <?if($primaryEmployment !== null):?>
                                <div class="b-job">
                                    <header>
                                        <h6 class="title company">
                                            <a href="<?=$this->createUrl('/company/view/index', array('companyId' => $primaryEmployment->Company->Id))?>" itemprop="affiliation">
                                                <?=$primaryEmployment->Company->Name?>
                                            </a>
                                        </h6>
                                    </header>
                                    <?if(!empty($primaryEmployment->Position)):?>
                                        <article>
                                            <p class="text post"><?=$primaryEmployment->Position?></p>
                                        </article>
                                    <?endif?>
                                </div>
                            <?endif?>

                            <?if($_SERVER['REMOTE_ADDR'] == '82.142.129.35'):?>
                                <?if(!empty($professionalInterests)):?>
                                    <div class="b-interests">
                                        <header>
                                            <h6 class="title"><?=Yii::t('app', 'Профессиональные интересы')?></h6>
                                        </header>
                                        <article>
                                            <p class="text"><?=implode(', ', $professionalInterests)?></p>
                                        </article>
                                    </div>
                                <?endif?>
                            <?endif?>

                            <?if(!empty($user->CommissionsActive)):?>
                                <div class="b-raec">
                                    <img src="/images/content/raec-logo_small.jpg" alt="РАЭК" class="logo">
                                    <?foreach($user->CommissionsActive as $commission):?>
                                        <p class="text"><?=$commission->Role->Title?>, <?=$commission->Commission?></p>
                                    <?endforeach?>
                                </div>
                            <?endif?>

                            <?if(!empty($user->IRIParticipantsActive)):?>
                                <div class="b-iri">
                                    <?=\CHtml::link(\CHtml::image('/images/content/iri-logo_small.jpg', Yii::t('app', 'Институт Развития Интернета'), ['class' => 'logo']), 'http://ири.рф', ['target' => '_blank'])?>
                                    <?foreach($user->IRIParticipantsActive as $participant):?>
                                        <p class="text"><?=$participant?></p>
                                    <?endforeach?>
                                </div>
                            <?endif?>

                            <?if(!empty($user->ICTParticipantsActive)):?>
                                <div class="b-iri">
                                    <?=\CHtml::link(\CHtml::image('/images/content/ict-logo-small.png', Yii::t('app', 'ICT'), ['class' => 'logo']), 'http://ict.moskow', ['target' => '_blank'])?>
                                    <?foreach($user->ICTParticipantsActive as $participant):?>
                                        <p class="text"><?=$participant?></p>
                                    <?endforeach?>
                                </div>
                            <?endif?>
                        </div>


                        <div id="user-account-tabs" class="span4 tabs">
                            <ul class="nav">
                                <?if(!empty($employmentHistory)):?><li><a href="#user-account-tab_career" class="pseudo-link"><?=Yii::t('app', 'Карьера')?></a></li><?endif?>
                                <?if($hasContacts):?><li><a href="#user-account-tab_contacts" class="pseudo-link"><?=Yii::t('app', 'Контакты')?></a></li><?endif?>
                            </ul>

                            <?if(!empty($employmentHistory)):?>
                                <div id="user-account-tab_career" class="tab b-career">
                                    <?foreach($employmentHistory as $employments):?>
                                        <dl class="dl-horizontal">
                                            <dd>
                                                <h6 class="b-career_company"><a href="<?=$employments[0]->Company->getUrl()?>" itemprop="memberOf"><?=$employments[0]->Company->Name?></a></h6>
                                                <?foreach($employments as $employment):?>
                                                    <?if(!empty($employment->Position)):?>
                                                        <p class="b-career_post"  itemprop="jobTitle"><?=$employment->Position?></p>
                                                        <?if(($interval = $employment->getWorkingInterval()) !== null):?>
                                                            <p class="b-career_length muted"><small>
                                                                    <?if($interval->Years > 0):?>
                                                                        <?=Yii::t('app', '{n} год |{n} года |{n} лет |{n} года ', $interval->Years)?>
                                                                    <?endif?>
                                                                    <?if($interval->Months > 0):?>
                                                                        <?=Yii::t('app', '{n} месяц|{n} месяца|{n} месяцев|{n} месяца', $interval->Months)?>
                                                                    <?endif?>
                                                                </small></p>
                                                        <?endif?>
                                                    <?endif?>
                                                <?endforeach?>
                                            </dd>
                                            <?php
                                            $start = $employments[sizeof($employments)-1]->StartYear;
                                            $end = $employments[0]->EndYear;
                                           ?>
                                            <?if(!empty($start)):?>
                                                <dt><?=$start?> &mdash; <?=!empty($end) ? $end : Yii::t('app', 'н.в.')?></dt>
                                            <?php elseif (!empty($end)):?>
                                                <dt><?=Yii::t('app', 'до')?> <?=$end?></dt>
                                            <?endif?>
                                        </dl>
                                    <?endforeach?>
                                </div>
                            <?endif?>

                            <?if($hasContacts):?>
                                <div id="user-account-tab_contacts" class="tab b-contacts">
                                    <?if($user->LinkSite !== null):?>
                                        <dl class="dl-horizontal">
                                            <dt><?=Yii::t('app', 'Сайт:')?></dt>
                                            <dd><a href="<?=$user->LinkSite->Site?>" target="_blank"><?=parse_url($user->LinkSite->Site, PHP_URL_HOST)?></a></dd>
                                        </dl>
                                    <?endif?>
                                    <?foreach($user->LinkServiceAccounts as $linkServiceAcc):?>
                                        <?if($linkServiceAcc->ServiceAccount !== null):?>
                                            <dl class="dl-horizontal">
                                                <dt><?=$linkServiceAcc->ServiceAccount->Type->Title?>:</dt>
                                                <dd><?=$linkServiceAcc->ServiceAccount?></dd>
                                            </dl>
                                        <?endif?>
                                    <?endforeach?>
                                </div>
                            <?endif?>

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
                    <span class="backing text"><?=Yii::t('app','Участие в профильных мероприятиях')?></span>
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
        <?$this->renderPartial('index-participant', ['participation' => $participation])?>
    </div>
</div>

<div class="b-participate">
    <h4 class="b-header_large light">
        <div class="line"></div>
        <div class="container">
            <div class="title">
                <span class="backing text"><?=Yii::t('app', 'Примите участие')?></span>
            </div>
        </div>
    </h4>
    <div id="participate-events" class="container">
        <div class="row">
            <?foreach($recommendedEvents as $event):?>
                <div class="i span3">
                    <header class="h">
                        <div class="date">
                            <?$this->widget('\event\widgets\Date', array('event' => $event))?>
                        </div>
                        <p class="tx muted"><?=$event->Type->Title?></p>
                        <h5 class="t"><a href="<?=$event->getUrl()?>"><?=$event->Title?></a></h5>
                    </header>
                    <article class="cnt">
                        <p class="tx"><?=\application\components\utility\Texts::cropText($event->Info,200)?></p>
                    </article>
                    <footer class="f">
                        <a href="<?=$event->getUrl()?>" class="a">
                            <i class="icon-circle-arrow-right"></i><?=Yii::t('app', 'Посетить мероприятие')?>
                        </a>
                    </footer>
                </div>
            <?endforeach?>
        </div>
    </div>
</div>

<script type="text/template" id="chart-item-template">
    <div class="item">
        <div class="info">
            <div class="val"><%= value %></div>
            <div class="description"><?=Yii::t('app', 'В качестве')?> <b><%= role%></b></div>
        </div>
    </div>
</script>

<script type="text/template" id="single-chart-item-template">
    <div class="item">
        <span class="val"><b><%= value %></b>%</span>
        <span class="description"><%= role %></span>
    </div>
</script>

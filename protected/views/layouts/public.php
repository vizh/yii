<!DOCTYPE HTML>
<html>
<head>
    <title><?=CHtml::encode($this->pageTitle)?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=1024">
    <meta name="format-detection" content="telephone=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="google-site-verification" content="j6z-Xgf-Q_q6jFA-UANgpdjIdqPN7J43TiepOX-58EM"/>
    <link
        href='//fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic&subset=latin,cyrillic'
        rel='stylesheet' type='text/css'>
    <link rel="icon" href="/favicon.ico">
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/stylesheets/ie/lte-ie-9.css">
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/stylesheets/ie/lte-ie-8.css">
    <script src="/javascripts/ie/html5shiv.js"></script>
    <![endif]-->
    <!--[if lte IE 7]>
    <link rel="stylesheet" href="/stylesheets/ie/lte-ie-7.css">
    <![endif]-->
    <? $this->renderClip('event-counter-head'); ?>
</head>
<body id="<?=$this->bodyId?>">

<noscript>JavaScript disabled</noscript>
<header id="header" role="banner">
    <div class="navbar navbar-fixed-top navbar-inverse">
        <?$this->widget('application\widgets\Navbar')?>
        <?$this->widget('application\widgets\Searchbar')?>
        <?if(isset($this->navbar) && !empty($this->navbar)):?>
            <?=$this->navbar?>
        <?endif?>
    </div>
</header>

<section id="section" role="main">
    <?=$content?>
</section>

<footer id="footer" role="contentinfo">
    <div class="b-events-type">
        <div class="container units">
            <div class="unit">
                <img src="/images/blank.gif" alt="" class="i-event_large i-event_conference">

                <p class="caption"><?=Yii::t('app', 'Конференция')?></p>
            </div>
            <div class="unit">
                <img src="/images/blank.gif" alt="" class="i-event_large i-event_training">

                <p class="caption"><?=Yii::t('app', 'Семинар тренинг')?></p>
            </div>
            <div class="unit">
                <img src="/images/blank.gif" alt="" class="i-event_large i-event_webinar">

                <p class="caption"><?=Yii::t('app', 'Вебинар')?></p>
            </div>
            <div class="unit">
                <img src="/images/blank.gif" alt="" class="i-event_large i-event_roundtable">

                <p class="caption"><?=Yii::t('app', 'Круглый стол')?></p>
            </div>
            <div class="unit">
                <img src="/images/blank.gif" alt="" class="i-event_large i-event_confpartner">

                <p class="caption"><?=Yii::t('app', 'Партнерская конференция')?></p>
            </div>
            <div class="unit">
                <img src="/images/blank.gif" alt="" class="i-event_large i-event_contestprize">

                <p class="caption"><?=Yii::t('app', 'Конкурс премия')?></p>
            </div>
            <div class="unit">
                <img src="/images/blank.gif" alt="" class="i-event_large i-event_eventsother">

                <p class="caption"><?=Yii::t('app', 'Другие мероприятия')?></p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="row">
                    <nav class="nav" role="navigation">
                        <span class="span2 item">
                          <a href="<?=$this->createUrl('/page/info/about')?>"><?=Yii::t('app', 'О проекте')?></a>
                        </span>
                        <span class="span2 item">
                          <a href="<?=$this->createUrl('/page/info/adv')?>"><?=Yii::t('app', 'Реклама')?></a>
                        </span>
                        <span class="span2 item">
                          <a href="<?=$this->createUrl('/page/info/agreement')?>"><?=Yii::t('app', 'Соглашение')?></a>
                        </span>
                        <span class="span2 item">
                          <a href="<?=$this->createUrl('/page/info/pay')?>"><?=Yii::t('app', 'Оплата')?></a>
                        </span>
                        <span class="span2 item">
                          <a href="<?=$this->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Мероприятия')?></a>
                        </span>
                        <span class="span2 item">
                          <a href="<?=$this->createUrl('/company/list/index')?>"><?=Yii::t('app', 'Компании')?></a>
                        </span>
                        <span class="span2 item">
                          <a href="<?=$this->createUrl('/page/info/contacts')?>"><?=Yii::t('app', 'Контакты')?></a>
                        </span>
                    </nav>
                </div>
            </div>
            <form id="search-footer" class="span4" action="<?=$this->createUrl('/search/result/index')?>"
                  role="search">
                <input type="text" class="form-element_text" name="term"
                       placeholder="<?=Yii::t('app', 'Поиск по людям, компаниям, новостям')?>">
                <input type="image" class="form-element_image pull-right" src="/images/search-type-image-dark.png"
                       width="20" height="19">
            </form>
        </div>
    </div>

    <div class="logo-divider">
        <img src="/images/logo-footer.png" width="200" height="20" alt="" class="logo">
    </div>

    <div class="container">
        <div class="clearfix">
            <div class="clearfix pull-left">
                <div class="development pull-left">
                    Оплата за участие в мероприятиях<br/>осуществляется при поддержке <a href="http://payonline.ru" target="_blank">PayOnline</a><br/><br/>
                    <img src="/img/pay/visa.png" alt="VISA"/>
                    <img src="/img/pay/mastercard.png" alt="Master Card"/>
                    <img src="/img/pay/paypal.png" alt="Master Card"/>
                    <img src="/img/pay/moneymail.png" alt="Master Card"/>
                    <!--<img src="/img/pay/webmoney.png" alt="Master Card"/>-->
                    <img src="/img/pay/yandex-money.png" alt="Master Card"/>
                </div>
            </div>
            <div class="development pull-right">
                <div class="m-bottom_10">
                    <?=\CHtml::link(\CHtml::image('/images/hotline.png', 'Горячая линия рунета'), 'http://hotline.rocit.ru', ['target' => '_blank'])?>
                </div>
                &copy;&nbsp;2008-<?=date('Y')?>, ООО &laquo;РУВЕНТС&raquo;<br/>
                При поддержке: <a href="http://internetmediaholding.com" title="Internet Media Holding" target="_blank">Internet Media Holding</a>
            </div>
        </div>
    </div>
</footer>

<?$this->renderPartial('//layouts/counters/google')?>
<?$this->renderPartial('//layouts/counters/yandex')?>

<?$this->widget('application\widgets\ModalAuth')?>
<?$this->renderClip('event-counter-body')?>
<?$this->renderClip('event-after-payment-code')?>
</body>
</html>
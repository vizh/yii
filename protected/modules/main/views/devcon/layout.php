<!doctype html>
<html>
<head>
  <title><?=CHtml::encode($this->pageTitle);?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="google-site-verification" content="j6z-Xgf-Q_q6jFA-UANgpdjIdqPN7J43TiepOX-58EM" />
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
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
</head>

<body>
<noscript>JavaScript disabled</noscript>

<section id="section" role="main">
    <div class="devcon">
        <div class="container m-top_30 m-bottom_30">
            <div class="row">
                <div class="span9 offset2">
                    <a target="_blank" href="http://www.msdevcon.ru/"><img src="/img/event/devcon14/logo.png" alt=""/></a>
                </div>
            </div>
        </div>

        <div class="devcon-hero"></div>

        <div class="container m-top_40">
            <h3 class="text-center competence-title">Анкета участника</h3>
        </div>

        <?=$content;?>

    </div>
</section>

</body>
</html>
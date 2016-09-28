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
</head>
<style>
    html, body {
        min-width: 648px !important;
        width: 648px !important;
    }
    .container {
        width: 648px !important;
    }
    .span12 {
        width: 600px !important;
    }
    h3 {
        font-size: 15px !important;
        margin-bottom: 5px !important;
        margin-top: 5px !important;
    }
</style>
<body id="<?=$this->bodyId?>">
<noscript>JavaScript disabled</noscript>
<section id="section" role="main">
    <?=$content?>
</section>

<?$this->renderPartial('//layouts/counters/google')?>
<?$this->renderPartial('//layouts/counters/yandex')?>

</body>
</html>
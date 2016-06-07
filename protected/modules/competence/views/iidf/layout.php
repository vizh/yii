<?php
/**
 * @var MainController $this
 */
use application\components\controllers\MainController;
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie8" lang="<?=\Yii::app()->getLanguage()?>"> <![endif]-->
<!--[if IE 9]><html class="ie9 gt-ie8" lang="<?=\Yii::app()->getLanguage()?>"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie" lang="<?=\Yii::app()->getLanguage()?>"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Open Sans font from Google CDN -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin,cyrillic" rel="stylesheet" type="text/css">
    <title><?=CHtml::encode(\Yii::t('app', 'Анкета участника'))?></title>
    <style type="text/css">
        @font-face {
            font-family: "Open Sans";
            src: url(/fonts/opensans/OpenSans-Regular.ttf);
        }
        @font-face {
            font-family: "Open Sans";
            src: url(/fonts/opensans/OpenSans-Bold.ttf);
            font-weight: bold;
        }
        @font-face {
            font-family: "Open Sans";
            src: url(/fonts/opensans/OpenSans-Light.ttf);
            font-style: italic, oblique;
        }

        html, body {
            font-family: "Open Sans", sans-serif;
        }
    </style>
</head>
<body>
    <div class="logo">
        <a href="http://iidf.ru/" target="_blank"><img src="http://getlogo.org/img/free/193/200x/" alt="ФРИИ" title="ФРИИ" /></a>
    </div>
    <div id="content-wrapper">
        <?=$content?>
        <div class="bg" style="width: 100%; margin-left: -50%;"></div>
    </div>
</body>
</html>
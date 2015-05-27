<?php
//https://wrapbootstrap.com/theme/pixeladmin-premium-admin-theme-WB07403R9
/**
 * @var Controller $this
 */
use \partner\components\Controller;
?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8" lang="<?=\Yii::app()->getLanguage()?>"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8" lang="<?=\Yii::app()->getLanguage()?>"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie" lang="<?=\Yii::app()->getLanguage()?>"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- Open Sans font from Google CDN -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin,cyrillic" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <title><?=\CHtml::encode($this->pageTitle); ?></title>
    <!--[if lt IE 9]>
    <script src="/js/ie.min.js"></script>
    <![endif]-->
</head>
<body class="theme-default">
<div id="main-wrapper">
    <div id="content-wrapper">
        <div class="page-header">
            <div class="row">
                <h1 class="col-xs-12 col-sm-4 text-left-sm">
                    <?if ($this->titleIcon !== null):?>
                        <i class="fa fa-<?=$this->titleIcon;?>"></i>
                    <?endif;?>
                    <?=\CHtml::encode($this->pageTitle)?>
                </h1>
            </div>
        </div>
        <?=$content?>
    </div>
    <div id="main-menu-bg">
        <?$this->widget('partner\widgets\Sidebar', ['event' => $this->getAction()->getEvent()]);?>
    </div>
</div>
<script>window.PixelAdmin.start(init);</script>
</body>
</html>
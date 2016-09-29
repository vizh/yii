<?php
/**
 * @var Controller $this
 */
use \partner\components\Controller;
\Yii::app()->getClientScript()->registerScript('print', 'window.print();');
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie8" lang="<?=\Yii::app()->getLanguage()?>"> <![endif]-->
<!--[if IE 9]><html class="ie9 gt-ie8" lang="<?=\Yii::app()->getLanguage()?>"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie" lang="<?=\Yii::app()->getLanguage()?>"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <!-- Open Sans font from Google CDN -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin,cyrillic" rel="stylesheet" type="text/css">
    <title><?=\CHtml::encode($this->pageTitle)?></title>
</head>
<body style="width: 700px;">
    <?=$content?>
</body>
</html>
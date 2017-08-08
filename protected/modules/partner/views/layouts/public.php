<?php

/**
 * @var Controller $this
 * @source https://wrapbootstrap.com/theme/pixeladmin-premium-admin-theme-WB07403R9
 */

use partner\components\Controller;

$sidebar = $this->showSidebar && Yii::app()->partner->getIsSetEvent();
$language = Yii::app()->getLanguage();

?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie8" lang="<?=$language?>"> <![endif]-->
<!--[if IE 9]><html class="ie9 gt-ie8" lang="<?=$language?>"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie" lang="<?=$language?>"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin,cyrillic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/partner/vendor.css">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <script src="/partner/vendor.js"></script>
    <title><?=CHtml::encode($this->pageTitle)?></title>
</head>
<body class="theme-default <?=$this->bodyClass?>" ng-app="PartnerApp">
<style type="text/css">
    <?if($sidebar):?>
        @media (max-width: 1200px) {
            #content-wrapper {
                min-width: 970px !important;
            }
            #main-wrapper {
                overflow: auto !important;
            }
        }
    <?endif?>
    <?if(!$this->showNavbar):?>
        #content-wrapper {
            padding-top: 0;
        }
    <?endif?>
    <?if($this->bgTransparent):?>
        body {
            background: transparent !important;
        }
        #content-wrapper {
            padding: 0
        }
    <?endif?>
</style>

<?if($this->showNavbar):?>
    <?$this->widget('partner\widgets\Navbar')?>
<?endif?>

<div <?if($sidebar):?>id="main-wrapper"<?endif?>>
    <?if($sidebar):?>
        <?$this->widget('partner\widgets\Sidebar', ['event' => $this->getEvent()])?>
    <?endif?>

    <div id="content-wrapper">
        <?if($this->showPageHeader):?>
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h1><?=CHtml::encode($this->pageTitle)?></h1>
                    </div>
                    <div class="col-sm-6 text-right hidden-xs">
                        <?=$this->clips[Controller::PAGE_HEADER_CLIP_ID]?>
                    </div>
                    <div class="visible-xs m-top_5 col-xs-12">
                        <?=$this->clips[Controller::PAGE_HEADER_CLIP_ID]?>
                    </div>
                </div>
            </div>
        <?endif?>
        <?=$content?>
        <?=$this->clips[Controller::PAGE_FOOTER_CLIP_ID]?>
    </div>

    <?if($sidebar):?>
        <div id="main-menu-bg"></div>
    <?endif?>
</div>
<script>window.PixelAdmin.start(init)</script>
<?$this->widget('\application\widgets\ModalAuth', ['bootstrapVersion' => 3])?>
</body>
</html>
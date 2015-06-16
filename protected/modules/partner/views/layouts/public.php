<?php
//https://wrapbootstrap.com/theme/pixeladmin-premium-admin-theme-WB07403R9
/**
 * @var Controller $this
 */
use \partner\components\Controller;

$sidebar = $this->showSidebar && \Yii::app()->partner->getIsSetEvent();
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
</head>
<body class="theme-default mmc <?=$this->bodyClass;?>">

<?$this->widget('partner\widgets\Navbar');?>

<div <?php if ($sidebar):?>id="main-wrapper"<?php endif;?>>
    <?php if ($sidebar):?>
        <?$this->widget('partner\widgets\Sidebar', ['event' => $this->getAction()->getEvent()]);?>
    <?php endif;?>

    <div id="content-wrapper">
        <?php if ($this->showPageHeader):?>
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h1><?=\CHtml::encode($this->pageTitle)?></h1>
                    </div>
                    <div class="col-sm-6 text-right hidden-xs">
                        <?=$this->clips[Controller::PAGE_HEADER_CLIP_ID];?>
                    </div>
                    <div class="visible-xs m-top_5 col-xs-12">
                        <?=$this->clips[Controller::PAGE_HEADER_CLIP_ID];?>
                    </div>
                </div>
            </div>
        <?php endif;?>
        <?=$content?>
    </div>

    <?php if ($sidebar):?>
        <div id="main-menu-bg"></div>
    <?php endif;?>
</div>
<script>window.PixelAdmin.start(init);</script>
<?php $this->widget('\application\widgets\ModalAuth', ['bootstrapVersion' => 3]);?>
</body>
</html>
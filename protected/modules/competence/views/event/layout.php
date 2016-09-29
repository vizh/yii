<?php
/**
 *  @var PublicMainController $this
 */

use application\components\controllers\PublicMainController;
use event\components\WidgetPosition;
?>
<!doctype html>
<html>
<head>
    <title><?=CHtml::encode(\Yii::t('app', 'Анкета участника'))?></title>
    <meta charset="utf-8">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
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
    <section id="section" role="main">
        <?foreach($this->getEvent()->Widgets as $widget):?>
            <?if($widget->getPosition() == WidgetPosition::Header):?>
                <?php
                $widget->getWidget()->eventPage = false;
                $widget->run();
               ?>
            <?endif?>
        <?endforeach?>
        <div class="container m-top_40">
            <h3 class="text-center competence-title"><?=CHtml::encode($this->getTest()->Title)?></h3>
        </div>
        <?=$content?>
    </section>
</body>
</html>
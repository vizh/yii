<!DOCTYPE HTML>
<html style="min-width: 0;" ng-app="WidgetApp">
    <head>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link href='//fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    </head>
    <body id="widget-<?=$this->getId()?>">
        <div class="container-fluid">
            <?=$content?>
        </div>
        <div>&nbsp;</div>
    </body>
</html>
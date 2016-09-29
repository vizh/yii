<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>RUNET-ID <?=CHtml::encode($this->pageTitle)?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
</head>

<body>

<?$this->widget('application\widgets\admin\Navbar')?>
<?$this->widget('application\widgets\admin\Sidebar')?>

<div class="content" ng-app="AdminApp">

    <div class="header">
        <h1 class="page-title"><?=$this->pageTitle?></h1>
    </div>

    <div class="container-fluid">
        <?=$content?>
    </div>
</div>


</body>
</html>





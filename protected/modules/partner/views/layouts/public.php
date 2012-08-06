<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="Shortcut Icon" href="/images/favicon.ico" type="image/x-icon" />
  <meta name='robots' content='noindex,nofollow' />

  <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>

<?php $this->widget('\partner\components\widgets\TopMenu');?>

<div class="container">
  <div class="rocid-logo">
    <h1>ROC<span>ID</span>:// <span class="rocid-logo-suffix">Партнерский интерфейс</span></h1>
  </div>
</div>

<div class="container content-block">
  <?php $this->widget('\partner\components\widgets\BottomMenu', array('menu' => $this->getBottomMenu()));?>
  <?=$content;?>
</div>
</body>
</html>
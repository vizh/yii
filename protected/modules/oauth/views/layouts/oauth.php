<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="Shortcut Icon" href="/images/favicon.ico" type="image/x-icon" />
  <meta name='robots' content='noindex,nofollow' />

  <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
  <div class="container"> 
    <div class="m-bottom_40">
      <img src="/images/logo.png" width="250px" />
    </div>
    <?php if (\Yii::app()->user->hasFlash('message')):?>
      <div class="alert alert-message m-bottom_20">
        <?php echo \Yii::app()->user->getFlash('message');?>
      </div>
    <?php endif;?>
    <?php echo $content;?>
  </div>
</body>
</html>
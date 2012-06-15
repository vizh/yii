<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#"  xmlns:fb="http://www.facebook.com/2008/fbml" class="simple">
<head>
  <title><?php echo  $this->Title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="Shortcut Icon" href="/images/favicon.ico" type="image/x-icon" />
  <meta name='robots' content='noindex,nofollow' />
  <link rel="stylesheet" type="text/css" href="/css/style.css" media="all" />
  <link rel="stylesheet" type="text/css" href="/css/mystyle.css" media="all" />
  <script type="text/javascript" src="/js/libs/jquery-1.6.4.min.js"></script>

  <?php echo $this->heads['HeadTitle']; ?>
  <?php echo $this->heads['HeadLink']; ?>
  <?php echo $this->heads['HeadMeta']; ?>
  <?php echo $this->heads['HeadScript']; ?>
  <?php echo $this->heads['HeadStyle']; ?>
  <?php echo $this->MetaTags; ?>

</head>
<body class="simple">
<div id="simple_wrapper">
  <?php echo $this->Content; ?>
</div>
</body>
</html>

 

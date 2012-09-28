<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery/cookie.js" type="text/javascript"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery/dropdown.js" type="text/javascript"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery/modal.js" type="text/javascript"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery/button.js" type="text/javascript"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery/rejectalert.js" type="text/javascript"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/placefilter.js" type="text/javascript"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/usertoolbar.js" type="text/javascript"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/json2.js" type="text/javascript"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery/ui/jquery-ui-1.8.22.custom.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery/ui/css/ui-lightness/jquery-ui-1.8.22.custom.css" />
  <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl;?>/css/style.css" />
  <title><?php echo Yii::app()->controller->getPageTitle();?></title>
</head>
<body> 
  <script type="text/javascript">
    $(function () {
      <?php if (Yii::app()->request->getUrl() == '/'):?>
      PlaceFilter.submitFilter();
      <?php endif;?>
        
      $.rejectAlert({
        reject : {
          firefox2 : true,
          msie7: true,
          msie8: true,
          unknown: true
        },
        selector : $('body .container .content'),
        title    : '<?php echo Yii::t('app', 'You are using an obsolete browser');?>',
        message  : '<?php echo Yii::t('app', 'Our site supports it only in part. To avoid this, download and install one of these browsers:');?>'
      });
    });
  </script>
  
  <div class="navbar">
    <div class="navbar-inner m-bottom_10">
      <div class="container">
        <form id="filter">
        <ul class="nav">
          <li class="city">
            <a href="#"><span><?php echo $this->cities[0]->Name;?></span></a>
            <ul class="dropdown-menu">
              <li class="header clearfix">
                <span></span>
                <a class="close" href="#">×</a>
              </li>
              <li class="divider"></li>
              <?php foreach ($this->cities as $city):?>
                <li><a href="#" data-fieldval='{"city" : "<?php echo $city->Id;?>"}' data-cityid="<?php echo $city->Id;?>"><?php echo $city->Name;?></a></li>
              <?php endforeach;?>
            </ul>
            <input type="hidden" value="<?php echo $this->cities[0]->Id;?>" name="filter[city]" />
          </li>

          <li class="date">
            <a href="#"><span><?php echo Yii::t('app', 'Date');?></span></a>
            <ul class="dropdown-menu">
              <li class="header clearfix">
                  <span></span>
                  <a class="close" href="#">×</a>
              </li>
              <li class="divider"></li>
              <?php
                $today    = date('d.m.Y', time());
                $tomorrow = date('d.m.Y', time() + 86400);
              ?>
              <li><a href="#" data-fieldval='{"date][from" : "<?php echo $today;?>", "date][to" : "<?php echo $today;?>"}'><?php echo Yii::t('app', 'Today');?></a></li>
              <li><a href="#" data-fieldval='{"date][from" : "<?php echo $tomorrow;?>", "date][to" : "<?php echo $tomorrow;?>"}'><?php echo Yii::t('app', 'Tomorrow');?></a></li>
              <li class="divider"></li>
              <li class="clearfix footer">
                <span><?php echo Yii::t('app', 'From');?></span>
                <input type="text" name="filter[date][from]" value="" />
                <span><?php echo Yii::t('app', 'To');?></span>
                <input type="text" name="filter[date][to]" value="" />
              </li>
            </ul>
          </li>

          <li class="time">
            <a href="#"><span><?php echo Yii::t('app', 'Time');?></span></a>
            <ul class="dropdown-menu">
              <li class="header clearfix">
                <span></span>
                <a class="close" href="#">×</a>
              </li>
              <li class="divider"></li>
              <li><a href="#" data-fieldval='{"time][from" : "06:00", "time][to" : "12:00"}'><?php echo Yii::t('app', 'Morning');?></a></li>
              <li><a href="#" data-fieldval='{"time][from" : "12:00", "time][to" : "17:00"}'><?php echo Yii::t('app', 'Day');?></a></li>
              <li><a href="#" data-fieldval='{"time][from" : "17:00", "time][to" : "00:00"}'><?php echo Yii::t('app', 'Evening');?></a></li>
              <li><a href="#" data-fieldval='{"time][from" : "00:00", "time][to" : "06:00"}'><?php echo Yii::t('app', 'Night');?></a></li>
              <li class="divider"></li>
              <li class="clearfix footer">
                <span><?php echo Yii::t('app', 'From');?></span>
                <input type="text" name="filter[time][from]" value="" />
                <span><?php echo Yii::t('app', 'To');?></span>
                <input type="text" name="filter[time][to]" value="" />
              </li>
            </ul>
          </li>

          <li class="category">
            <a href="#"><span><?php echo Yii::t('app', 'Category');?></span></a>
            <ul class="dropdown-menu">
              <li class="header clearfix">
                <span></span>
                <a class="close" href="#">×</a>
              </li>
              <li class="divider"></li>
              <?php foreach ($this->categories as $category):?>
                <li><label class="checkbox"><input type="checkbox" value="<?php echo $category->Id;?>" name="filter[category][]" /><?php echo $category->Name;?></label></li>
              <?php endforeach;?>
            </ul>
          </li>
          
          <li class="clear">
            <a href="#">× <?php echo Yii::t('app', 'clear filter');?></a>
          </li>
        </ul>
        </form>
        <ul class="nav pull-right" id="userToolbar">
          <?php if ( Yii::app()->user->isGuest):?>
            <li>
              <a href="javascript: UserToolbar.showLoginForm();"><?php echo Yii::t('app', 'Login');?></a>
              <div class="modal hide" id="loginForm">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">×</button>
                  <h3><?php echo Yii::t('app', 'Login');?></h3>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal">
                    <div class="alert alert-error hide"></div>
                    <div class="clearfix m-bottom_20">
                      <div class="f-left m-right_20">
                        <label class="m-bottom_5"><?php echo Yii::t('app', 'Email');?></label>
                        <input type="text" name="email" value="" />
                      </div>
                      <div class="f-left">
                        <label class="m-bottom_5"><?php echo Yii::t('app', 'Password');?></label>
                        <input type="password" name="password" value="" />
                      </div>
                    </div>
                    <input type="submit" class="btn btn-primary m-right_5" value="<?php echo Yii::t('app', 'Login');?>" data-loading-text="<?php echo Yii::t('app', 'Please wait...');?>" />
                    <a href="<?php echo $this->createUrl('user/register');?>" class="btn"><?php echo Yii::t('app', 'Register');?></a>
                  </form>
                </div>
              </div>
            </li>
            <li>
              <a class="separator" href="#">|</a>
            </li>
            <li><a href="/register/"><?php echo Yii::t('app', 'Register');?></a></li>
          <?php else:?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toogle="dropdown" href="#"><?php echo Yii::app()->user->fullName;?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo $this->createUrl('/user/settings');?>"><?php echo Yii::t('app', 'Settings');?></a></li>
                <li><a href="<?php echo $this->createUrl('/review/listbyuser');?>"><?php echo Yii::t('app', 'My review');?></a></li>
                <li><a href="<?php echo $this->createUrl('/calendar/calendar/index');?>"><?php echo Yii::t('app', 'My calendar');?></a></li>
                <li><a href="<?php echo $this->createUrl('/newplace');?>"><?php echo Yii::t('app', 'Add new place');?></a></li>
                <li class="divider"></li>
                <li><a href="<?php echo $this->createUrl('/user/logout');?>"><?php echo Yii::t('app', 'Exit');?></a></li>
              </ul>
            </li>
          <?php endif;?>
        </ul>
      </div>
    </div>
    <div class="container clearfix">
      <?php if (Yii::app()->request->getUrl() == '/'):?>
      <div class="f-left">
        <form class="form-search" id="search">
          <input type="text" value="" name="search[query]" placeholder="<?php echo Yii::t('app', 'Search all places');?>"/> <input type="submit" class="btn" value="<?php echo Yii::t('app','Search');?>" />
        </form>
      </div>
      <?php endif;?>
      <div class="f-right">
        <a href="/"><img src="<?php echo Yii::app()->theme->baseUrl;?>/images/logo.png" border="0" /></a>
        <a href="<?php echo $this->createUrl('/blog/');?>" class="italic m-top_5 m-left_20 d-block">
          <?php echo Yii::t('blog', 'Our Blog');?>
        </a>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="content">
      <noscript><div class="alert alert-error"><h3><?php echo Yii::t('app', 'For correct operation of the site enable JavaScript in your browser!');?></h3></div></noscript>        
      
      <?php if (Yii::app()->request->getUrl() == '/'):?>
      <div class="row m-bottom_5">
        <div class="span9 t-center" id="mainBanner">
          <?php echo Yii::t('app', 'Learn about the best places in your city!');?>
        </div>
      </div>
      <div class="hr-dotted m-bottom_40"></div>
      <?php endif;?>
      
      <?php echo $content;?>
    </div>
  </div>
</body>
</html>

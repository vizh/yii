<?php
/**
 * В этом файле задаются не традиционные пути для приложения Default
 */

//GM2012 ---- ПОСЛЕ ИСПОЛЬЗОВАНИЯ УДАЛИТЬ
RouteRegistry::AddRoute('gm2012', array('/gm2012/:rocid/:role/:code/',
	array('module'=>'event', 'section'=>'widget', 'command'=>'quick', 'rocid' => '0', 'role' => '0', 'code' => ''),
	array('rocid' => '/\d+/', 'role' => '/\d+/')));


RouteRegistry::AddRoute('Main', array('/',
	array('module'=>'main', 'section' => '', 'command' => 'index')));
	
RouteRegistry::AddRoute('Main.FastAuth', array('/auth/:rocid/:hash/',
	array('module'=>'main', 'section' => '', 'command' => 'fastauth', 'rocid' => '0', 'hash' => ''),
	array('rocid' => '/\d+/')));

RouteRegistry::AddRoute('Main.Login', array('/login/',
	array('module'=>'main', 'section' => '', 'command' => 'login')));

RouteRegistry::AddRoute('User', array('/:rocid/',
	array('module'=>'user', 'section'=>'', 'command'=>'show', 'rocid' => '0'),
	array('rocid' => '/\d+/')));

RouteRegistry::AddRoute('User.Redirect', array('/person/:rocid/',
	array('module'=>'user', 'section'=>'', 'command'=>'redirect', 'rocid' => '0'),
	array('rocid' => '/\d+/')));
	
RouteRegistry::AddRoute('Company', array('/company/:companyid/',
	array('module'=>'company', 'section'=>'', 'command'=>'show', 'companyid' => '0'),
	array('companyid' => '/\d+/')));

RouteRegistry::AddRoute('CompanyRss', array('/company/:companyid/rss/',
	array('module'=>'company', 'section'=>'', 'command'=>'rss', 'companyid' => '0'),
	array('companyid' => '/\d+/')));

RouteRegistry::AddRoute('CompanyEdit', array('/company/:companyid/edit/',
	array('module'=>'company', 'section'=>'', 'command'=>'edit', 'companyid' => '0'),
	array('companyid' => '/\d+/')));

RouteRegistry::AddRoute('CompanySave', array('/company/:companyid/edit/save/',
	array('module'=>'company', 'section'=>'edit', 'command'=>'save', 'companyid' => '0'),
	array('companyid' => '/\d+/')));

RouteRegistry::AddRoute('EventsList', array('/events/',
	array('module'=>'event', 'section'=>'', 'command'=>'main')));

RouteRegistry::AddRoute('EventUsers', array('/events/users/:idName/',
	array('module'=>'event', 'section'=>'show', 'command'=>'users', 'idName' => '0')));

RouteRegistry::AddRoute('EventShow.StartUpMixer', array('/events/startupmixer2012/',
    array('module'=>'event', 'section'=>'temp', 'command'=>'mixer')));

RouteRegistry::AddRoute('EventShow', array('/events/:idName/:date/',
    array('module'=>'event', 'section'=>'', 'command'=>'show', 'idName' => '0', 'date' => ''),
	array('date' => '/(\d+)-(\d+)-(\d+)/')));

RouteRegistry::AddRoute('newsmain', array('/news/',
	array('module'=>'news', 'section' => '', 'command' => 'index')));

RouteRegistry::AddRoute('newsshow', array('/news/:newslink/',
	array('module'=>'news', 'section'=>'', 'command'=>'show', 'newslink' => 0),
	array('newslink' => '/\d+-.*/is')));

RouteRegistry::AddRoute('NewsRocidCover', array('/news/rocid-cover/:coverId/',
	array('module'=>'news', 'section' => '', 'command' => 'rocidcover', 'coverId' => 0)));

RouteRegistry::AddRoute('RssCategory', array('/news/category/:name/rss/',
	array('module'=>'news', 'section'=>'rss', 'command'=>'category', 'name' => '')));

RouteRegistry::AddRoute('VideoIndex', array('/video/',
	array('module'=>'video', 'section' => '', 'command' => 'index')));

RouteRegistry::AddRoute('VideoShow', array('/video/:videolink/',
	array('module'=>'video', 'section'=>'', 'command'=>'show', 'videolink' => 0),
	array('videolink' => '/\d+-.*/is')));

RouteRegistry::AddRoute('SearchIndex', array('/search/',
	array('module'=>'search', 'section' => '', 'command' => 'index')));

RouteRegistry::AddRoute('JobTestList', array('/job/test/',
	array('module'=>'job', 'section' => 'test', 'command' => 'list')));

RouteRegistry::AddRoute('JobShow', array('/job/:id/',
	array('module'=>'job', 'section'=>'', 'command'=>'show', 'id' => '0'),
	array('id' => '/\d+/')));

RouteRegistry::AddRoute('JobStreamShow', array('/job/stream/id/:id/',
	array('module'=>'job', 'section'=>'stream', 'command'=>'show', 'id' => '0'),
	array('id' => '/\d+/')));

RouteRegistry::AddRoute('JobTestShow', array('/job/test/id/:id/',
	array('module'=>'job', 'section'=>'test', 'command'=>'show', 'id' => '0'),
	array('id' => '/\d+/')));

RouteRegistry::AddRoute('JobTestProcess', array('/job/test/process/:id/',
	array('module'=>'job', 'section'=>'test', 'command'=>'process', 'id' => '0'),
	array('id' => '/\d+/')));

RouteRegistry::AddRoute('JobTestResult', array('/job/test/result/:id/',
	array('module'=>'job', 'section'=>'test', 'command'=>'showresult', 'id' => '0'),
	array('id' => '/\d+/')));

RouteRegistry::AddRoute('test2', array('test',
	array('module'=>'test', 'section'=>'', 'command'=>'test3', 'name' => 'Name1')
	));

RouteRegistry::AddRoute('convert', array('convert',
	array('module'=>'convert', 'section'=>'', 'command'=>'all')
	));


/**
 * GATE COMMANDS
 */

RouteRegistry::AddRoute('Gate.Role', array('/system/gate/role.php',
	array('module'=>'gate', 'section'=>'', 'command'=>'role')
	));

RouteRegistry::AddRoute('Gate.Update', array('/system/gate/update.php',
	array('module'=>'gate', 'section'=>'', 'command'=>'update')
	));

RouteRegistry::AddRoute('Gate.New', array('/system/gate/new.php',
	array('module'=>'gate', 'section'=>'', 'command'=>'new')
	));

RouteRegistry::AddRoute('Gate.User', array('/system/gate/user.php',
	array('module'=>'gate', 'section'=>'', 'command'=>'user')
	));

RouteRegistry::AddRoute('Gate.Company', array('/system/gate/company.php',
	array('module'=>'gate', 'section'=>'', 'command'=>'company')
	));

RouteRegistry::AddRoute('Gate.Registration', array('/system/gate/registration.php',
	array('module'=>'gate', 'section'=>'', 'command'=>'registration')
	));

RouteRegistry::AddRoute('Gate.Registration.Delete', array('/system/gate/registration.delete.php',
	array('module'=>'gate', 'section'=>'registration', 'command'=>'delete')
	));

RouteRegistry::AddRoute('Gate.Participants', array('/system/gate/participants.php',
	array('module'=>'gate', 'section'=>'', 'command'=>'participants')
	));

RouteRegistry::AddRoute('Gate.Login', array('/system/gate/login.php',
	array('module'=>'gate', 'section'=>'', 'command'=>'login')
	));

RouteRegistry::AddRoute('Gate.Test', array('/system/gate/test.php',
	array('module'=>'gate', 'section'=>'', 'command'=>'test')
	));

RouteRegistry::AddRoute('Gate.Program', array('/system/gate/program.php',
	array('module'=>'gate', 'section'=>'', 'command'=>'program')
	));

RouteRegistry::AddRoute('Gate.Program.Section', array('/system/gate/program.section.php',
	array('module'=>'gate', 'section'=>'program', 'command'=>'section')
	));

RouteRegistry::AddRoute('Gate.Program.Participants', array('/system/gate/program.participants.php',
	array('module'=>'gate', 'section'=>'program', 'command'=>'participants')
	));

RouteRegistry::AddRoute('Tech Get', array('/system/gate/_get.php',
	array('module'=>'gate', 'section'=>'', 'command'=>'get')
	));

RouteRegistry::AddRoute('Gate.Pay.Add', array('/system/gate/pay.add.php',
	array('module'=>'gate', 'section'=>'pay', 'command'=>'add')
	));

RouteRegistry::AddRoute('Gate.Pay.Delete', array('/system/gate/pay.delete.php',
	array('module'=>'gate', 'section'=>'pay', 'command'=>'delete')
	));

RouteRegistry::AddRoute('Gate.Pay.List', array('/system/gate/pay.list.php',
	array('module'=>'gate', 'section'=>'pay', 'command'=>'list')
	));

RouteRegistry::AddRoute('Gate.Pay.Coupon', array('/system/gate/pay.coupon.php',
	array('module'=>'gate', 'section'=>'pay', 'command'=>'coupon')
	));

RouteRegistry::AddRoute('Gate.Pay.Product', array('/system/gate/pay.product.php',
	array('module'=>'gate', 'section'=>'pay', 'command'=>'product')
	));



RouteRegistry::AddRoute('LunchIndex', array('/lunch/:lunchId/',
	array('module'=>'lunch', 'section' => '', 'command' => 'index', 'lunchId' => 0)));

//Yandex RSS

RouteRegistry::AddRoute('YandexRSS', array('/yandex.rss',
	array('module'=>'news', 'section' => 'rss', 'command' => 'yandex')));


//i-research

RouteRegistry::AddRoute('research.index', array('/i-research/',
	array('module'=>'research', 'section' => '', 'command' => 'index')));

RouteRegistry::AddRoute('research.experts', array('/i-research/experts/',
	array('module'=>'research', 'section' => '', 'command' => 'experts')));

RouteRegistry::AddRoute('research.approve.vote', array('/i-research/approve/vote/:rocId/:timestamp/:hash/',
	array('module'=>'research', 'section' => 'approve', 'command' => 'vote')));

RouteRegistry::AddRoute('research.approve', array('/i-research/approve/',
	array('module'=>'research', 'section' => '', 'command' => 'approve')));

RouteRegistry::AddRoute('research.vote', array('/i-research/vote/',
	array('module'=>'research', 'section' => '', 'command' => 'vote')));

RouteRegistry::AddRoute('research.vote.statistics', array('/i-research/vote/statistics/',
	array('module'=>'research', 'section' => 'vote', 'command' => 'statistics')));

RouteRegistry::AddRoute('research.vote.result', array('/i-research/vote/result/',
	array('module'=>'research', 'section' => 'vote', 'command' => 'result')));


/******************* PARTNER  ***************************/
RouteRegistry::AddRoute('partner.index', array('/partner/',
	array('module'=>'partner', 'section' => '', 'command' => 'index')));

RouteRegistry::AddRoute('partner.order.index', array('/partner/order/',
	array('module'=>'partner', 'section' => 'order', 'command' => 'index')));

RouteRegistry::AddRoute('partner.user.index', array('/partner/user/',
	array('module'=>'partner', 'section' => 'user', 'command' => 'index')));

RouteRegistry::AddRoute('partner.coupon.index', array('/partner/coupon/',
	array('module'=>'partner', 'section' => 'coupon', 'command' => 'index')));

RouteRegistry::AddRoute('partner.orderitem.index', array('/partner/orderitem/',
	array('module'=>'partner', 'section' => 'orderitem', 'command' => 'index')));

RouteRegistry::AddRoute('partner.orderitem.add', array('/partner/orderitem/add/',
	array('module'=>'partner', 'section' => 'orderitem', 'command' => 'add')));
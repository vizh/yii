<?php
/**
 * В этом файле задаются не традиционные пути для приложения Mobile
 */

RouteRegistry::AddRoute('main', array('/',
	array('module'=>'main', 'section' => '', 'command' => 'index')));

RouteRegistry::AddRoute('EventUsers', array('/events/users/:idName/',
	array('module'=>'event', 'section'=>'show', 'command'=>'users', 'idName' => '0')));

RouteRegistry::AddRoute('EventShow', array('/events/:idName/:date/',
    array('module'=>'event', 'section'=>'', 'command'=>'show', 'idName' => '0', 'date' => ''),
	array('date' => '/(\d+)-(\d+)-(\d+)/'))); 
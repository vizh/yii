<?php

RouteRegistry::AddRoute('main', array('/:eventId/',
	array('module'=>'main', 'section' => '', 'command' => 'index', 'eventId' => 0),
  array('eventId' => '/\d+/')));

RouteRegistry::AddRoute('auth', array('/auth/:eventId/:rocId/',
	array('module'=>'main', 'section' => '', 'command' => 'auth', 'eventId' => 0, 'rocId' => 0)));

/**
 * Работа с юр лицами
 */
RouteRegistry::AddRoute('Juridical.Index', array('/juridical/',
	array('module'=>'juridical', 'section' => '', 'command' => 'index')));
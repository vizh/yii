<?php

return array(

  /***  DENY BLOCK  ***/
  array(
    'deny',
    'roles' => array('mobile'),
    'controllers' => array('event'),
    'actions' => array('register')
  ),
  array(
    'deny',
    'roles' => array('mobile'),
    'controllers' => array('user'),
    'actions' => array('create')
  ),
  array(
    'deny',
    'roles' => array('mobile'),
    'controllers' => array('pay')
  ),
  /*** END DENY BLOCK ***/


  array(
    'allow',
    'users' => array('?'),
    'controllers' => array('raec')
  ),
  array(
    'allow',
    'roles' => ['base'],
    'controllers' => ['user'],
    'actions' => ['auth', 'search', 'create', 'get', 'login', 'purposes', 'professionalinterests', 'edit', 'setdata']
  ),
  array(
    'allow',
    'roles' => array('base'),
    'controllers' => array('section')
  ),
  array(
    'allow',
    'roles' => array('base'),
    'controllers' => array('company')
  ),
  array(
    'allow',
    'roles' => array('base'),
    'controllers' => array('event'),
    'actions' => array('roles', 'register', 'list', 'info', 'companies', 'statistics', 'users', 'purposes', 'halls')
  ),
  array(
    'allow',
    'roles' => array('base'),
    'controllers' => array('pay')
  ),
  array(
    'allow',
    'roles' => array('base'),
    'controllers' => array('invite')
  ),
  array(
    'allow',
    'roles' => array('base'),
    'controllers' => array('purpose')
  ),
  array(
    'allow',
    'roles' => array('base'),
    'controllers' => array('professionalinterest')
  ),


  /*** Спецпроект для сбербанка  ***/
  array(
    'allow',
    'roles' => array('sberbank'),
    'controllers' => array('user'),
    'actions' => array('get')
  ),


  /*** MBLT ***/
  array(
    'allow',
    'roles' => array('mblt'),
    'controllers' => array('event'),
    'actions' => array('users', 'companies')
  ),
  array(
    'allow',
    'roles' => array('mblt'),
    'controllers' => array('company'),
    'actions' => array('get')
  ),

   /** MicroSoft **/
  array(
    'allow',
    'roles' => ['microsoft'],
    'controllers' => ['ms', 'pay']
  ),

  /***  ЗАПРЕЩЕНО ВСЕ ЧТО НЕ РАЗРЕШЕНО   ***/
  array(
    'deny',
    'users' => array('*')
  ),
);
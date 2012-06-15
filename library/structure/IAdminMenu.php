<?php

interface IAdminMenu
{
  /**
   * Название пункта меню
   * @abstract
   * @return string
   */
  public function GetMenuTitle();

  /**
   * Родительский блок
   * @abstract
   * @return string|null
   */
  public function GetMenuParent();

  /**
   * Возвращает массив вида array('module' => '', 'section' => '', 'command' => '');
   * @abstract
   * @return array
   */
  public function GetMenuPath();

  /**
   * @abstract
   * @return void
   */
  public function GetMenuPriority();
}
 

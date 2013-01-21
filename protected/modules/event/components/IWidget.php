<?php
namespace event\components;

interface IWidget{

  /**
   * @return string
   */
  public function getTitle();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return string
   */
  public function getPosition();

  /**
   * @return void
   */
  public function process();

  /**
   * @return void
   */
  public function run();
}
<?php
class TestHook extends AbstractHook
{ 
  public function __toString()
  {
    return 'Подгружен тестовый хук TestHook';
  }
}
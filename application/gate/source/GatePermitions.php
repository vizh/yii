<?php
class GatePermitions
{
  private $permittions = array();
  
  public function AddPermittion($commandId, $accessField = '')
  {
    if (empty($commandId))
    {
      return;
    }
    if (! isset($this->permittions[$commandId]))
    {
      $this->permittions[$commandId] = array();
    }
    if (! empty($accessField))
    {
      $this->permittions[$commandId][$accessField] = 1;
    }
  }
  
  public function RemovePermittion($commandId, $accessField = '')
  {
    if (isset($this->permittions[$commandId]))
    {
      if (! empty($accessField) && isset($this->permittions[$commandId][$accessField]))
      {
        unset($this->permittions[$commandId][$accessField]);
      }
      else if (empty($accessField))
      {
        unset($this->permittions[$commandId]);
      }
    }
  }
  
  public function IsHavePermittion($commandId, $accessField = '')
  {
    if (! isset($this->permittions[$commandId]))
    {
      if (empty($accessField) || isset($this->permittions[$commandId][$accessField]))
      {
        return true;
      }
    }
    else
    {
      return false;
    }
  }
}
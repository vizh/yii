<?php
namespace event\models;
final class RoleType 
{
  const None     = 'none'; 
  const Listener = 'listener';
  const Speaker  = 'speaker';
  const Master   = 'master';
  
  static public function compare($role1, $role2)
  {
    $weight = array(
      self::None     => 0,
      self::Listener => 1,
      self::Speaker  => 2,
      self::Master   => 3
    );
    
    if ($weight[$role1] > $weight[$role2])
    {
      return $role1;
    }
    return $role2;
  }
}
